<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenyesuaianDroppingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyesuaian_dropping', function(Blueprint $table) {
            $table->increments('id');
            $table->date('tgl_dopping');
            $table->boolean('is_pengembalian');
            $table->double('nominal');
            $table->integer('akun_bank');
            $table->integer('cabang');
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
        Schema::drop('penyesuaian_dropping');
    }
}
