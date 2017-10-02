<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTLRekomendasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tl_rekomendasi', function (Blueprint $table) {
            $table->increments('id3');
            $table->integer('id_temuan');
            $table->text('rekomendasi');
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
        Schema::drop('tl_rekomendasi');
    }
}
