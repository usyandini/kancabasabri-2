<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProgramPrioritas extends Model
{
    protected $connection = 'sqlsrv';

	protected $table = 'program_prioritas';

	protected $fillable = ['program_prioritas'];
}
