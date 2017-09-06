<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPerizinanUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->integer('perizinan_dropping')->default(0)->nullable();
            $table->integer('perizinan_transaksi')->default(0)->nullable();
            $table->integer('perizinan_anggaran')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn(['perizinan_dropping', 'perizinan_transaksi', 'perizinan_anggaran']);
        });
    }
}
