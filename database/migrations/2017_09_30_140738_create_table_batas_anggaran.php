<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBatasAnggaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('batas_anggaran', function(Blueprint $table){
            $table->increments('id');
            $table->string('unit_kerja');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
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
        Schema::drop('batas_anggaran');
    }
}
