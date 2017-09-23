<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $connection = 'sqlsrv2';

    protected $table = 'PIL_VIEW_MAINACCOUNT';

    public function kombinasiAvailable($cabang, $divisi)
    {
    	$countKombinasi = count($this->hasOne('App\Models\ItemMaster', 'SEGMEN_1', 'MAINACCOUNTID')
            ->where([
            ['SEGMEN_2', 'THT'],
            ['SEGMEN_3', $cabang],
            ['SEGMEN_4', $divisi]])->get());
    	return $countKombinasi > 0 ? true : false;
    }

    public function kombinasi()
    {
    	return $this->hasOne('App\Models\ItemMaster', 'SEGMEN_1', 'MAINACCOUNTID');
    }
}
