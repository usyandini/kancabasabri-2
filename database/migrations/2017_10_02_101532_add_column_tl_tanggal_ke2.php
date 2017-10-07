<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTlTanggalKe2 extends Migration
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
            $table->date('tgl_input')->nullable();
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
            $table->dropColumn(['tgl_input']);
        });
    }
}
