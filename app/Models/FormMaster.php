<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormMaster extends Model
{
    //

    protected $connection = 'sqlsrv';

    protected $table = 'form_master';

    protected $fillable = 
    		['tanggal_mulai', 
    		'tanggal_selesai',
    		'tw_dari', 
    		'tw_ke', 
    		'unit_kerja', 
    		'kategori',
    		'active',
    		'created_at', 
    		'updated_at'];

}
