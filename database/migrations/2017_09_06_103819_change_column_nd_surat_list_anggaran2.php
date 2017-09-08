<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnNdSuratListAnggaran2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('list_anggaran', function(Blueprint $table) {
            $table->dropColumn('nd_surat');
            $table->integer('id_list_anggaran')->after('id_first');
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
        Schema::table('list_anggaran', function(Blueprint $table) {
            $table->dropColumn('id_list_anggaran');
            $table->integer('nd_surat')->after('id_first');
        });
    }
}
