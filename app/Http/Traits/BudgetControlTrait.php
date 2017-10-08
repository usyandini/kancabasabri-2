<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\BudgetControl;
use App\Models\BudgetControlHistory;
use App\Models\Transaksi;

use Carbon;

trait BudgetControlTrait 
{
	public function calibrateAnggaran($trans, $isInsert)
	{
		$result = [];		
		if (isset($trans->isNew)) {
			$transaksi_date = new Carbon(date("Y-m-d", strtotime($trans->tgl)));	
		} else {
			$transaksi_date = new Carbon(str_replace(':AM', ' AM', $trans->tgl));
		}
		$currentHistory = $this->getHistory($transaksi_date, $trans->account);
		
		if (!$currentHistory) {
			$currentHistory = $this->createHistory($trans, $transaksi_date);
		}

		if ($isInsert || $currentHistory->savepoint_amount != $trans->anggaran) {
			$input['actual_amount'] = $result['actual_anggaran'] = (int)$currentHistory->actual_amount - (int)$trans->total;
			$result['anggaran'] = $currentHistory->savepoint_amount; 
			
			BudgetControlHistory::where('id', $currentHistory->id)->update($input);	
			
			$result['is_anggaran_safe'] = ((int)$result['actual_anggaran'] < 0) ? false : true;
		}

		return $result;
	}

	public function resetCalibrateBecauseDeleteOrUpdate($accounts)
	{
		foreach ($accounts as $acc) {
			$localBudgetControl = BudgetControlHistory::where([
				['month_period', $acc->month], 
				['year_period', $acc->year],
				['account', $acc->account]])->first();
			$this->updateSavePoint((int)$localBudgetControl->savepoint_amount, $localBudgetControl->id);

			$transaksis = Transaksi::where('account', $acc->account)
							->whereYear('tgl', '=', $acc->year)
							->whereMonth('tgl', '=', $acc->month)->get()->filter(function($transaksi) {
						        return !$transaksi->batch->isPosted();
						    });

			foreach ($transaksis as $transaksi) {
				$transaksi_date = new Carbon(str_replace(':AM', ' AM', $transaksi->tgl));
				$currentHistory = $this->getHistory($transaksi_date, $transaksi->account);
				$budgetUpdate['actual_amount'] = $transaksiUpdate['actual_anggaran'] = (int)$currentHistory->actual_amount - (int)$transaksi->total;
				$transaksiUpdate['is_anggaran_safe'] = ((int)$budgetUpdate['actual_amount'] < 0) ? false : true;

				BudgetControlHistory::where('id', $currentHistory->id)->update($budgetUpdate);				
				Transaksi::where('id', $transaksi->id)->update($transaksiUpdate);
			}
		}
	}

	public function calibrateSavePointAndActual($account_data)
	{
		$localBudgetControl = BudgetControlHistory::where([
				['month_period', $account_data->month], 
				['year_period', $account_data->year],
				['account', $account_data->account]])->first();
		$axActual = $this->getAxActual($account_data);
		
		if ($axActual && $localBudgetControl && ((int)$axActual->PIL_AMOUNTAVAILABLE != (int)$localBudgetControl->savepoint_amount)) {
			$this->updateSavePoint((int)$axActual->PIL_AMOUNTAVAILABLE, $localBudgetControl->id);
			return true;
		}
		return false;
	}

	public function createHistory($transaksi_data, $transaksi_date)
	{
		$axBudgetControl = $this->axActual($transaksi_data, $transaksi_date);
		if ($axBudgetControl) {
			$historyInput = [
				'month_period' 	=> $transaksi_date->month,
				'year_period'	=> $transaksi_date->year,
				'account'		=> $transaksi_data->account,
				'savepoint_amount' => (int)$axBudgetControl->PIL_AMOUNTAVAILABLE,
				'actual_amount'	=> (int)$axBudgetControl->PIL_AMOUNTAVAILABLE];

				return BudgetControlHistory::create($historyInput);
			}

		return null;
	}

	public function getHistory($transaksi_date, $account)
	{
		$isAvailable = BudgetControlHistory::where([
			['month_period', $transaksi_date->month], 
			['year_period', $transaksi_date->year],
			['account', $account]])->first();

		return $isAvailable ? $isAvailable : false;
	}

	public function getAxActual($account_data)
	{
		$axBudgetControl = BudgetControl::where('PIL_DISPLAYVALUE', $account_data->account)
			->whereYear('PIL_PERIODENDDATE', '=', $account_data->year)
			->whereYear('PIL_PERIODSTARTDATE', '=', $account_data->year)
			->whereMonth('PIL_PERIODENDDATE', '=', $account_data->month)
			->whereMonth('PIL_PERIODSTARTDATE', '=', $account_data->month)
			->first();

		return $axBudgetControl ? $axBudgetControl : false;	
	}

	public function axActual($transaksi_data, $transaksi_date)
	{
		$axBudgetControl = BudgetControl::where([
			['PIL_DISPLAYVALUE', $transaksi_data->account], 
			['PIL_PERIODSTARTDATE', '<=', $transaksi_date], 
			['PIL_PERIODENDDATE', '>=', $transaksi_date]])->first();

		return $axBudgetControl ? $axBudgetControl : false;
	}

	public function updateSavePoint($newSavePoint, $id)
	{
		$input = ['savepoint_amount' => $newSavePoint, 'actual_amount' => $newSavePoint];
		BudgetControlHistory::where('id', $id)->update($input);
	}
}