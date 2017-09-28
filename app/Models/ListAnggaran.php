<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListAnggaran extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'list_anggaran';

    protected $fillable = 
    		['jenis', 
    		'kelompok',
    		'pos_anggaran', 
    		'sub_pos', 
            'mata_anggaran', 
    		'item', 
    		'kuantitas',
    		'satuan',
    		'nilai_persatuan',
    		'terpusat',
    		'unit_kerja',
    		'TWI',
    		'TWII',
    		'TWIII',
    		'TWIV',
    		'anggaran_setahun',
    		'id_first',
            'id_list_anggaran',
    		'active',
    		'created_at', 
    		'updated_at'];
}
