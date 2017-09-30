<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatasAnggaran extends Model
{
    // use SoftDeletes;
    
    protected $connection = 'sqlsrv';
    protected $table = 'batas_anggaran';

    
    protected $fillable = [
                'unit_kerja', 
                'tanggal_selesai', 
                'active', 
                'created_by', 
                'updated_by'];

    
}
