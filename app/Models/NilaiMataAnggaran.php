<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NilaiMataAnggaran extends Model
{
	// use SoftDeletes;

    protected $connection = 'sqlsrv';
    protected $table = 'nilai_mata_anggaran';

    protected $fillable = [
    	'value',
    	'description',
    	'nilai',
    	'created_by',
    	'updated_by'
    ];
}
