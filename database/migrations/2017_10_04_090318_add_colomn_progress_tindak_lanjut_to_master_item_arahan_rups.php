<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomnProgressTindakLanjutToMasterItemArahanRups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('master_item_arahan_rups', function(Blueprint $table) {
            $table->boolean('progress_tindak_lanjut')->nullable();
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
        Schema::table('master_item_arahan_rups', function(Blueprint $table) {
            $table->dropColumn('progress_tindak_lanjut');
        });
    }
}
