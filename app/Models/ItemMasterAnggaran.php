<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemMasterAnggaran extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'item_master_anggaran';
    
    protected $fillable = [
    	 'jenis'
        ,'kelompok'
        ,'pos_anggaran'
        ,'sub_pos'
        ,'mata_anggaran'
        ,'account'
        ,'deleted_at'
    ];
}
