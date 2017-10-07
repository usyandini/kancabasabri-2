<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomnUraianProgressToMasterItemPelaporanAnggaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('master_item_pelaporan_anggaran', function(Blueprint $table) {
            $table->string('uraian_progress')->nullable();
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
        Schema::table('master_item_pelaporan_anggaran', function(Blueprint $table) {
            $table->dropColumn('uraian_progress');
        });
    }
}
