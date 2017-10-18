<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomnSegmenToItemMasterAnggaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('item_master_anggaran', function(Blueprint $table) {
            $table->string('SEGMEN_1')->nullable();
            $table->string('SEGMEN_2')->nullable();
            $table->renameColumn('sub_pos', 'SEGMEN_5');
            $table->renameColumn('mata_anggaran', 'SEGMEN_6');
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
        Schema::table('item_master_anggaran', function(Blueprint $table) {
            $table->dropColumn('SEGMEN_1');
            $table->dropColumn('SEGMEN_2');
            $table->renameColumn('SEGMEN_5', 'sub_pos');
            $table->renameColumn('SEGMEN_6', 'mata_anggaran');
        });
    }
}
