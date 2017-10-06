<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemUsulanProgram extends Model
{
    //

    protected $connection = 'sqlsrv';

    protected $table = 'item_usulan_program';

    protected $fillable = 
    		  ['unit_kerja',
              'id_form_master',
              'nama_program',
              'latar_belakang',
              'dampak_positif',
              'dampak_negatif',
              'created_at',
              'updated_at'];

      

}
