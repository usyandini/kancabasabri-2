<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTlTanggal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('tl_tanggal', function(Blueprint $table) {
            $table->integer('internal')->nullable();
            $table->integer('kirim')->nullable();
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
        Schema::table('tl_tanggal', function(Blueprint $table) {
            $table->dropColumn(['internal']);
            $table->dropColumn(['kirim']);
        });
    }
}
