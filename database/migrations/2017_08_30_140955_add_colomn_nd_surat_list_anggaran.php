<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomnNdSuratListAnggaran extends Migration
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
            $table->string('nd_surat')->after('id');
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
            $table->dropColumn('nd_surat');
        });
    }
}
