<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeColomnProgressTindakLanjutToMasterItemArahanRups extends Migration
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

            $table->string('progress_tindak_lanjut')->change();
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

            $table->boolean('progress_tindak_lanjut')->change();
        });
    }
}
