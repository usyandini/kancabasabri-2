<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListLaporanAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('list_laporan_anggaran', function(Blueprint $table) {
            $db = DB::connection('sqlsrv2')->getDatabaseName();
            $table->increments('id');           
            $table->integer('id_form_master');
            $table->string('program_prioritas');
            $table->string('sasaran_dicapai');
            $table->string('uraian_progress');
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
         Schema::table('list_laporan_anggaran', function(Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
}
