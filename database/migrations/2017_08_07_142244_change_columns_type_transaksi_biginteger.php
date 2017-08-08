<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsTypeTransaksiBiginteger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksi', function(Blueprint $table) {
            $table->string('item')->change();
            $table->string('sub_pos')->change();
            $table->string('mata_anggaran')->change();
            $table->string('akun_bank')->change();
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
            $table->bigInteger('sub_pos')->change();
            $table->bigInteger('mata_anggaran')->change();
            $table->bigInteger('akun_bank')->change();
            $table->bigInteger('item')->change();
        });
    }
}
