<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIdBeforeListLaporanAnggaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('list_laporan_anggaran', function(Blueprint $table) {
            $table->integer('id_before')->after('active')->nullable();
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
        Schema::table('list_laporan_anggaran', function(Blueprint $table) {
            $table->dropColumn('id_before');
        });
    }
}
