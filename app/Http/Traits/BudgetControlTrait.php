<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\BudgetControl;
use App\Models\BudgetControlH;
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
			$transaksi_date = new Carbon(date("Y-m-d", strtotime($trans->tgl)));
			// $transaksi_date = new Carbon(str_replace(':AM', ' AM', $trans->tgl));
		}
		$currentHistory = $this->getHistory($transaksi_date, $trans->account);
		
		if (!$currentHistory) {
			$currentHistory = $this->createHistory($trans, $transaksi_date);
		}

		if ($isInsert || $currentHistory->savepoint_amount != $trans->anggaran) {
			if (!isset($trans->isNew) && $isInsert) {
				
			} else if (!$isInsert) {
				if ($trans->currently_rejected == true) {
					$trans->total = 0;
				}
			}
			$input['actual_amount'] = $result['actual_anggaran'] = (int)$currentHistory->actual_amount - (int)$trans->total;
			$result['anggaran'] = $currentHistory->savepoint_amount; 
			
			BudgetControlH::where('id', $currentHistory->id)->update($input);	
			
			$result['is_anggaran_safe'] = ((int)$result['actual_anggaran'] < 0) ? false : true;
		}

		return $result;
	}

	public function resetSavePoint($account)
	{
		$localBudgetControl = BudgetControlH::where([
			['year_period', $account->year],
			['account', $account->account]])->first();
		$this->updateSavePoint((int)$localBudgetControl->savepoint_amount, $localBudgetControl->id);
	}

	public function resetCalibrateBecauseDeleteOrUpdate($accounts, $afterReject = null)
	{
		foreach ($accounts as $acc) {
			$this->resetSavePoint($acc);
			$transaksis = Transaksi::where('account', $acc->account)
							->whereYear('tgl', '=', $acc->year)->get()->filter(function($transaksi) {
						        return !$transaksi->batch->isPosted();
						    });

			foreach ($transaksis as $transaksi) {
				$transaksi_date = new Carbon(date("Y-m-d", strtotime($transaksi->tgl)));
				// $transaksi_date = new Carbon(str_replace(':AM', ' AM', $transaksi->tgl));
				$currentHistory = $this->getHistory($transaksi_date, $transaksi->account);
				
				if ($transaksi->batch->latestStat()->stat == 3 || $transaksi->batch->latestStat()->stat == 5 || $transaksi->currently_rejected == 1) {
					$transaksi->total = 0;
					$transaksiUpdate['currently_rejected'] = $afterReject ? 1 : $transaksi->currently_rejected;
				} else {
					$transaksiUpdate['currently_rejected'] = 0;
				}

				$budgetUpdate['actual_amount'] = $transaksiUpdate['actual_anggaran'] = (int)$currentHistory->actual_amount - (int)$transaksi->total;
				$transaksiUpdate['is_anggaran_safe'] = ((int)$budgetUpdate['actual_amount'] < 0) ? false : true;

				BudgetControlH::where('id', $currentHistory->id)->update($budgetUpdate);				
				Transaksi::where('id', $transaksi->id)->update($transaksiUpdate);
			}
		}
	}

	public function calibrateSavePointAndActual($account_data)
	{
		$localBudgetControl = BudgetControlH::where([
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
				'year_period'	=> $transaksi_date->year,
				'account'		=> $transaksi_data->account,
				'savepoint_amount' => (int)$axBudgetControl->PIL_AMOUNTAVAILABLE,
				'actual_amount'	=> (int)$axBudgetControl->PIL_AMOUNTAVAILABLE];

				return BudgetControlH::create($historyInput);
			}

		return null;
	}

	public function getHistory($transaksi_date, $account)
	{
		$isAvailable = BudgetControlH::where([
			['year_period', $transaksi_date->year],
			['account', $account]])->first();

		return $isAvailable ? $isAvailable : false;
	}

	public function getAxActual($account_data)
	{
		$axBudgetControl = BudgetControl::where('PIL_DISPLAYVALUE', $account_data->account)
			->whereYear('PIL_PERIODENDDATE', '=', $account_data->year)
			->whereYear('PIL_PERIODSTARTDATE', '=', $account_data->year)
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
		BudgetControlH::where('id', $id)->update($input);
	}
}