<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterItemPelaporanAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('master_item_pelaporan_anggaran', function(Blueprint $table) {
            $db = DB::connection('sqlsrv2')->getDatabaseName();
            $table->increments('id');           
            $table->integer('id_form_master');
            $table->string('unit_kerja');
            $table->string('program_prioritas');
            $table->string('sasaran_dicapai');
            $table->string('active');
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
        Schema::drop('master_item_pelaporan_anggaran');
    }
}
