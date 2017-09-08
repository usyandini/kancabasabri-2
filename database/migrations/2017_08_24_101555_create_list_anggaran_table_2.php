<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListAnggaranTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('list_anggaran', function (Blueprint $table) {
            $db = DB::connection('sqlsrv')->getDatabaseName();

            $table->increments('id');
            $table->string('jenis');
            $table->string('kelompok');
            $table->string('pos_anggaran');
            $table->string('sub_pos');
            $table->string('mata_anggaran');
            $table->integer('kuantitas');
            $table->string('satuan');
            $table->double('nilai_persatuan');
            $table->string('terpusat');
            $table->string('unit_kerja');
            $table->double('TWI');
            $table->double('TWII');
            $table->double('TWIII');
            $table->double('TWIV');
            $table->double('anggaran_setahun');
            
            $table->timestamps();       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('list_anggaran');
    }
}
