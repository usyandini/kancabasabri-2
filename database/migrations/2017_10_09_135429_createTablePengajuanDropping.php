<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePengajuanDropping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_dropping_cabang', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kantor_cabang');
            $table->string('nomor')->nullable();
            $table->date('tanggal')->nullable();
            $table->integer('jumlah_diajukan')->nullable();
            $table->string('periode_realisasi')->nullable();
            $table->string('name')->nullable();
            $table->biginteger('size')->nullable();
            $table->string('type')->nullable();
            $table->longtext('data')->nullable();
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
        Schema::drop('pengajuan_dropping_cabang');
    }
}
