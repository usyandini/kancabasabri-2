<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkunBank extends Model
{
    protected $connection = 'sqlsrv2';

    protected $table = 'PIL_BANK_VIEW';

	public function kcabang()
	{
		return $this->belongsTo('App\Models\KantorCabang', 'ID_CABANG', 'VALUE');
	}

	public function isAccessibleByCabang()
	{
		return \Auth::user()->hasAccess('unit_'.$this->ID_CABANG.'00') ? true : false;
	}    
}
