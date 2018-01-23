<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pil_kcanggaranheader extends Model
{
    protected $connection = 'sqlsrv2';

    protected $table = 'PIL_KCANGGARANHEADER';

    public $timestamps = false;

    protected $fillable = [
        
        'RECID',
        'PIL_TRANSDATE'
    ];
        // 'PIL_BUDGETTYPE'
    
}
