<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBerkasPenyesuaianDroppingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berkas_penyesuaian', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');            
            $table->bigInteger('size');
            $table->string('type');
            $table->longtext('data');
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
        Schema::drop('berkas_penyesuaian');
    }
}
