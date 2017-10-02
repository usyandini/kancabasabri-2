<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTLTanggalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tl_tanggal', function (Blueprint $table) {
            $table->increments('id1');
            $table->integer('id_unitkerja');
            $table->date('tgl_mulai');
            $table->integer('durasi');
            $table->date('tgl_selesai');
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
        Schema::drop('tl_tanggal');
    }
}
