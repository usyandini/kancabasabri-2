<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomnItemListAnggaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('list_anggaran', function(Blueprint $table) {
            $table->string('item')->nullable();
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
        Schema::table('list_anggaran', function(Blueprint $table) {
            $table->dropColumn(['item']);
        });
    }
}
