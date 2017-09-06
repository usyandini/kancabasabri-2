<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameBatasWaktuAnggaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('anggaran', function(Blueprint $table) {
            $table->renameColumn('batas_waktu', 'tanggal');
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
        Schema::table('anggaran', function(Blueprint $table) {
            $table->renameColumn('tanggal', 'batas_waktu');
        });
    }
}
