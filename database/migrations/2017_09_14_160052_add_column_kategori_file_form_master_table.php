<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnKategoriFileFormMasterTable extends Migration
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
            $table->string('kategori')->after('id_list_form_master')->nullable();
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
         Schema::table('file_form_master', function(Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
}
