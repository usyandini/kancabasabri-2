<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormMasterPelaporan extends Model
{
    //

    protected $connection = 'sqlsrv';

    protected $table = 'form_master_pelaporan';

    protected $fillable = 
    		['tanggal_mulai', 
    		'tanggal_selesai',
    		'tw_dari', 
    		'tw_ke', 
    		'unit_kerja', 
    		'kategori',
            'active',
    		'is_template',
    		'created_at', 
    		'updated_at'];

}
