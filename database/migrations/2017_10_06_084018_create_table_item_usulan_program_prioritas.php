<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableItemUsulanProgramPrioritas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('item_usulan_program', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unit_kerja');
            $table->string('nama_program');
            $table->text('latar_belakang');
            $table->text('dampak_positif');
            $table->text('dampak_negatif');
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
        Schema::drop('item_usulan_program');
    }
}
