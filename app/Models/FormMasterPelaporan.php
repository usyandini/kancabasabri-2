<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\MasterItemPelaporanAnggaran;
use App\Models\MasterItemArahanRUPS;
use App\Models\ItemUsulanProgram;

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
    		'kategori',
            'status',
            'unit_kerja',
            'is_template',
    		'id_master',
    		'created_at', 
    		'updated_at'];



}
