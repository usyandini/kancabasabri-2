<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColomnUnitKerjaToItemUsulanProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('item_usulan_program', function(Blueprint $table) {
            $table->dropColumn('unit_kerja');
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
        Schema::table('item_usulan_program', function(Blueprint $table) {
            $table->string('unit_kerja')->nullable();
        });
    }
}
