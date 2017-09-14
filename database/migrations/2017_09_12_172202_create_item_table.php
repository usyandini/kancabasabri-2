<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_master', function(Blueprint $table){
            $table->increments('id');
            $table->string('kode_item')->unique();
            $table->string('nama_item')->nullable();
            $table->string('jenis_anggaran')->nullable();
            $table->string('kelompok_anggaran')->nullable();
            $table->string('pos_anggaran')->nullable();

            $table->string('sub_pos')->nullable();
            $table->string('mata_anggaran')->nullable();
            $table->string('SEGMEN_1')->nullable(); //COA
            $table->string('SEGMEN_2')->nullable(); //PROGRAM
            $table->string('SEGMEN_3')->nullable(); //KPKC
            $table->string('SEGMEN_4')->nullable(); //SUBPOS
            $table->string('SEGMEN_5')->nullable(); //DIVISI
            $table->string('SEGMEN_6')->nullable(); //MATA ANGGARAN
            $table->integer('created_by')->nullable();
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
        Schema::drop('item_master');
    }
}
