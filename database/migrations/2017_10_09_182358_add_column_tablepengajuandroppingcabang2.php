<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTablepengajuandroppingcabang2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('pengajuan_dropping_cabang', function(Blueprint $table) {
            $table->string('kirim')->nullable();
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
        Schema::table('pengajuan_dropping_cabang', function(Blueprint $table) {
            $table->dropColumn('kirim');
        });
    }
}
