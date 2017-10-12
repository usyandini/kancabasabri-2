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
    		'program_prioritas',
    		'sasaran_dicapai', 
            'active',
    		'is_template',
            'uraian_progress',
            'id_list_master',
    		'created_at', 
    		'updated_at'];

}
