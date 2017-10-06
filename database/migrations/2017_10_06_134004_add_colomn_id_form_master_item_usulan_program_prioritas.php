<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomnIdFormMasterItemUsulanProgramPrioritas extends Migration
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
            $table->string('id_form_master')->nullable();
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
            $table->dropColumn('id_form_master');
        });
    }
}
