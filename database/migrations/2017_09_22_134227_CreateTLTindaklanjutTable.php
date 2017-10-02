<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTLTindaklanjutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tl_tindaklanjut', function (Blueprint $table) {
            $table->increments('id4');
            $table->integer('id_rekomendasi');
            $table->text('tindaklanjut');
            $table->string('file');
            $table->integer('status');
            $table->text('keterangan');
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
        Schema::drop('tl_tindaklanjut');
    }
}
