<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramPrioritasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_prioritas', function (Blueprint $table) {
            $db = DB::connection('sqlsrv2')->getDatabaseName();
            $table->increments('id');
            $table->string('program_prioritas');
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
        Schema::drop('program_prioritas');
    }
}
