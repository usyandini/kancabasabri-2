<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIsDisplayedItemMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_master', function(Blueprint $table) {
            $table->boolean('is_displayed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_master', function(Blueprint $table) {
            $table->dropColumn(['is_displayed']);
        });
    }
}
