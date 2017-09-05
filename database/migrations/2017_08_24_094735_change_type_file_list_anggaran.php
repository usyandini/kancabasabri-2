<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeFileListAnggaran extends Migration
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

            $table->string('name')->change();
            $table->string('type')->change();
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

            $table->integer('name')->change();
            $table->integer('type')->change();
        });
    }
}
