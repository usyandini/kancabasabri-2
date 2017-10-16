<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemAnggaranMaster extends Model
{
	use SoftDeletes;

    protected $connection = 'sqlsrv';
    protected $table = 'item_master_anggaran';

    protected $fillable = [
    	'kode',
    	'name',
    	'type',
    	'created_by',
    	'updated_by'
    ];
}
