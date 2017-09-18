<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterItemPelaporanAnggaran extends Model
{
    //

    protected $connection = 'sqlsrv';

    protected $table = 'master_item_pelaporan_anggaran';

    protected $fillable = 
    		['id_form_master', 
            'unit_kerja', 
    		'program_prioritas',
    		'sasaran_dicapai', 
    		'active',
    		'created_at', 
    		'updated_at'];

}
