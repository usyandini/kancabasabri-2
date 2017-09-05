<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomnIdFirstAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('list_anggaran', function(Blueprint $table) {
            $table->integer('id_first')->after('anggaran_setahun');
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
        Schema::table('list_anggaran', function(Blueprint $table) {
            $table->dropColumn('id_first');
        });
    }
}
