<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeKolomInTableItemMasterAnggaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_master_anggaran', function(Blueprint $table) {
            $table->dropColumn('SEGMEN_2');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->dropColumn('satuan');
            $table->renameColumn('SEGMEN_1', 'account');
            $table->renameColumn('SEGMEN_5', 'sub_pos');
            $table->renameColumn('SEGMEN_6', 'mata_anggaran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_master_anggaran', function(Blueprint $table) {
            $table->string('SEGMEN_2')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('satuan')->nullable();
            $table->renameColumn('account', 'SEGMEN_1');
            $table->renameColumn('sub_pos', 'SEGMEN_5');
            $table->renameColumn('mata_anggaran', 'SEGMEN_6');
        });   
    }
}
