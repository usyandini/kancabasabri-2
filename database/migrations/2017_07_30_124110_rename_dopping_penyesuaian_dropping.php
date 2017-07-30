<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameDoppingPenyesuaianDropping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penyesuaian_dropping', function(Blueprint $table) {
            $table->renameColumn('tgl_dopping', 'tgl_dropping');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penyesuaian_dropping', function(Blueprint $table) {
            $table->renameColumn('tgl_dropping', 'tgl_dopping');
        });
    }
}
