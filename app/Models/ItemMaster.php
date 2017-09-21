<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemMaster extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'item_master';
    
    protected $fillable = [
    	'kode_item',
    	'nama_item',
    	'jenis_anggaran',
    	'kelompok_anggaran',
    	'pos_anggaran',
    	'sub_pos',
    	'mata_anggaran',

    	'SEGMEN_1',
    	'SEGMEN_2',
    	'SEGMEN_3',
    	'SEGMEN_4',
    	'SEGMEN_5',
    	'SEGMEN_6',
    	'created_by',
    ];
}
