<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeDataFileListAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('file_list_anggaran', function(Blueprint $table) {

            $table->bigInteger('size')->change();
            $table->longtext('data')->change();
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
        Schema::table('file_list_anggaran', function(Blueprint $table) {

            $table->integer('size')->change();
            $table->string('data')->change();
        });
    }
}
