<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomnIdMasterToMasterItemPelaporanAnggaran extends Migration
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
            $table->string('id_list_master')->nullable();
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
            $table->dropColumn('id_list_master');
        });
    }
}
