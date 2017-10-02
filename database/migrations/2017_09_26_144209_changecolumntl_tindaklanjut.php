<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangecolumntlTindaklanjut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tl_tindaklanjut', function(Blueprint $table) {
            $table->dropColumn('file');
            $table->string('name')->nullable();
            $table->biginteger('size')->nullable();
            $table->string('type')->nullable();
            $table->string('data')->nullable();
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
        Schema::table('tl_tindaklanjut', function(Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('size');
            $table->dropColumn('type');
            $table->dropColumn('data');
            $table->string('file')->after('tindaklanjut');
        });
    }
}
