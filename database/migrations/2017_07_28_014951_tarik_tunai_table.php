<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TarikTunaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarik_tunai', function (Blueprint $table) {
            $table->increments('id_tunai')->unique();
            $table->date('tgl_dopping');
            $table->double('nominal_tunai');
            $table->string('akun_bank',50);
            $table->string('rek_bank',50);
            $table->string('cabang',50);
            $table->string('status',50); 
            $table->double('ket_nominal')->nullable();
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
        Schema::drop('tarik_tunai');
    }
}
