<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('anggaran', function (Blueprint $table) {
            $db = DB::connection('sqlsrv')->getDatabaseName();

            $table->increments('id');
            $table->string('nd_surat');
            $table->string('tipe_anggaran');
            $table->string('status_anggaran');
            $table->string('unit_kerja');
            $table->string('persetujuan');
            $table->date('batas_waktu');
            
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
        Schema::drop('anggaran');
    }
}
