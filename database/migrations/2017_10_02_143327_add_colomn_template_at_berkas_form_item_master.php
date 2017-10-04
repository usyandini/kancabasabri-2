<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomnTemplateAtBerkasFormItemMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('berkas_form_item_master', function(Blueprint $table) {
            $table->boolean('is_template')->nullable();
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
        Schema::table('berkas_form_item_master', function(Blueprint $table) {
            $table->dropColumn(['is_template']);
        });
    }
}
