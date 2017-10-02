<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangecolumntlTindaklanjut2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tl_tindaklanjut', function(Blueprint $table) {
            $table->longtext('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tl_tindaklanjut', function(Blueprint $table) {
            $table->dropColumn('data');
        });
    }
}
