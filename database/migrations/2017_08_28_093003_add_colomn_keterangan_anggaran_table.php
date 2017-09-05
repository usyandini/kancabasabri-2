<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomnKeteranganAnggaranTable extends Migration
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
            $table->string('keterangan')->after('persetujuan');
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
            $table->dropColumn('keterangan');
        });
    }
}
