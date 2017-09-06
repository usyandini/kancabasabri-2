<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileListAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('file_list_anggaran', function (Blueprint $table) {
            $db = DB::connection('sqlsrv')->getDatabaseName();

            $table->increments('id');
            $table->integer('id_list_anggaran');
            $table->integer('name');
            $table->integer('type');
            $table->integer('size');
            $table->binary('data');
            
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
        Schema::drop('file_list_anggaran');
    }
}
