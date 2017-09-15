<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListLaporanAnggaran extends Model
{
    //

    protected $connection = 'sqlsrv';

    protected $table = 'list_laporan_anggaran';

    protected $fillable = 
    		['id_form_master', 
    		'program_prioritas',
    		'sasaran_dicapai', 
    		'uraian_progress', 
    		'active',
            'id_before',
    		'created_at', 
    		'updated_at'];

}
