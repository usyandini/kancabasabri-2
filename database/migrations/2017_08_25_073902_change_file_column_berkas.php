<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFileColumnBerkas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('berkas_transaksi', function(Blueprint $table) {
            $table->longText('file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('berkas_transaksi', function(Blueprint $table) {
            $table->dropColumn('file');
            // $table->binary('file')->nullable();
        });
    }
}
