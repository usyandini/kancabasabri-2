<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterItemArahanRUPS extends Model
{
    //

    protected $connection = 'sqlsrv';

    protected $table = 'master_item_arahan_rups';

    protected $fillable = 
    		['id_form_master', 
            'unit_kerja', 
    		'jenis_arahan',
    		'arahan', 
            'active',
    		'is_template',
            'progress_tindak_lanjut',
    		'created_at', 
    		'updated_at'];

}
