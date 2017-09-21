<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemAnggaranMaster extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'item_anggaran_master';

    protected $fillable = [
    	'kode',
    	'name',
    	'type',
    	'created_by',
    	'updated_by'
    ];
}
