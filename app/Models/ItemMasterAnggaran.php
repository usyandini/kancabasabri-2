<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemMasterAnggaran extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'item_master_anggaran';
    
    protected $fillable = [
    	'jenis',
    	'kelompok',
    	'pos_anggaran',
        'SEGMEN_1',
        'SEGMEN_2',
    	'SEGMEN_5',
        'SEGMEN_6',
    	'satuan',
        'created_by',
    	'updated_by',
        'deleted_at'
    ];
}
