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
            $db = DB::connection('sqlsrv2')->getDatabaseName();

            $table->increments('id');
            $table->bigInteger('id_dropping');
            
            $table->date('tgl_dopping');
            $table->double('nominal');
            $table->string('akun_bank',50);
            $table->string('rek_bank',50);
            $table->string('cabang',50);
            $table->boolean('is_sesuai'); 
            $table->integer('id_penyesuaian')->unsigned()->default(null)->nullable();
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
