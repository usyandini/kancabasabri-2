<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeColumnDataListLaporanAnggaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('file_form_master', function(Blueprint $table) {

            $table->string('jenis')->change();
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

            $table->binary('data')->change();
            $table->binary('jenis')->change();
        });

    }
}
