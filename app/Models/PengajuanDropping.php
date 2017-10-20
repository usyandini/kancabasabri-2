<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanDropping extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'pengajuan_dropping_cabang';

	 protected $fillable = 
    		['kantor_cabang', 
    		'nomor',
    		'tanggal', 
    		'jumlah_diajukan', 
    		'periode_realisasi', 
    		'name',
    		'size',
    		'type',
    		'data', 
    		'kirim'];
}
