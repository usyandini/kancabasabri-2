<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArahanRupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arahan_rups', function (Blueprint $table) {
            $db = DB::connection('sqlsrv2')->getDatabaseName();
            $table->increments('id');
            $table->string('arahan_rups');
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
        Schema::drop('arahan_rups');
    }
}
