<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemMasterAnggaran extends Model
{
	use SoftDeletes;

    protected $connection = 'sqlsrv';
    protected $table = 'item_master_anggaran';

    protected $fillable = [
    	'jenis',
    	'kelompok',
        'pos_anggaran',
        'sub_pos',
        'mata_anggaran',
        'deleted_at',
    	'created_by',
    	'updated_by'
    ];
}
