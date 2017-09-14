<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileListAnggaran extends Model
{
    
    protected $connection = 'sqlsrv';

    protected $table = 'file_list_anggaran';
}
