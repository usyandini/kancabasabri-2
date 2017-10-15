<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemMaster extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'item_master';

    // protected $dateFormat = 'Y-m-d H:i:s';

    protected $dates = ['dob'];
    
    protected $fillable = [
    	'kode_item',
    	'nama_item',
    	// 'jenis_anggaran',
    	// 'kelompok_anggaran',
    	// 'pos_anggaran',
    	'sub_pos',
    	'mata_anggaran',

    	'SEGMEN_1',
    	'SEGMEN_2',
    	'SEGMEN_3',
    	'SEGMEN_4',
    	'SEGMEN_5',
    	'SEGMEN_6',
    	'created_by',
        'is_displayed'
    ];

    public function axAnggaran($transaksi_date)
    {
        $displayvalue = $this->SEGMEN_1.'-'.$this->SEGMEN_2.'-'.$this->SEGMEN_3.'-'.$this->SEGMEN_4.'-'.$this->SEGMEN_5.'-'.$this->SEGMEN_6;
        return $this->hasMany('App\Models\BudgetControl', 'PIL_MAINACCOUNT', 'SEGMEN_1')->where([
            ['PIL_DISPLAYVALUE', $displayvalue], 
            ['PIL_PERIODSTARTDATE', '<=', $transaksi_date], 
            ['PIL_PERIODENDDATE', '>=', $transaksi_date]])->first();
    }

    public function isAxAnggaranAvailable($transaksi_date)
    {
        return $this->axAnggaran($transaksi_date) ? true : false;   
    }

    public function isDisplayed($cabang)
    {
        if ($this->is_displayed == "0") {
            return $this->SEGMEN_3 == $cabang;
        }  

        return true;
    }

    public function budgetHistory($transaksi_date)
    {
        $transaksi_date = strtotime($transaksi_date);
        $displayvalue = $this->SEGMEN_1.'-'.$this->SEGMEN_2.'-'.$this->SEGMEN_3.'-'.$this->SEGMEN_4.'-'.$this->SEGMEN_5.'-'.$this->SEGMEN_6;
        return BudgetControlHistory::where([
            ['account', $displayvalue],
            ['month_period', date('m', $transaksi_date)],
            ['year_period', date('Y', $transaksi_date)]
        ])->first();
    }
}
