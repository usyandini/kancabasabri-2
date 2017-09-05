<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomnActiveListAnggaran extends Migration
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
            $table->string('active')->after('nd_surat');
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
            $table->dropColumn('active');
        });
    }
}
