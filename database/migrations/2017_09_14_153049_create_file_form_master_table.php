<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileFormMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('file_form_master', function (Blueprint $table) {
            $db = DB::connection('sqlsrv2')->getDatabaseName();

            $table->increments('id');
            $table->integer('id_form_master');
            $table->string('name');
            $table->string('type');
            $table->bigInteger('size');
            $table->binary('data');
            $table->binary('jenis');
            $table->string('active');
            
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

         Schema::drop('file_form_master');
    }
}
