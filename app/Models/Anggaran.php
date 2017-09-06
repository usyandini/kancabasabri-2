<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    //
    protected $connection = 'sqlsrv';

    protected $table = 'anggaran';

	 protected $fillable = 
    		['tanggal', 
    		'nd_surat',
    		'unit_kerja', 
    		'tipe_anggaran', 
    		'status_anggaran', 
    		'persetujuan',
    		'keterangan',
    		'active',
    		'created_at', 
    		'updated_at'];
}
