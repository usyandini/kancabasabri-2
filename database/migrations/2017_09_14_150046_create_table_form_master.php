<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFormMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('form_master', function(Blueprint $table) {
            $db = DB::connection('sqlsrv2')->getDatabaseName();
            $table->increments('id');           
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('tw_dari');
            $table->string('tw_ke');
            $table->string('unit_kerja');
            $table->string('kategori');
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
        Schema::drop('form_master');
    }
}
