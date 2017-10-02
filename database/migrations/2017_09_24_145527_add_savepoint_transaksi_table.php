<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSavepointTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksi', function(Blueprint $table) {
            $table->double('actual_anggaran')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi', function(Blueprint $table) {
            $table->dropColumn(['actual_anggaran']);
        });
    }
}
