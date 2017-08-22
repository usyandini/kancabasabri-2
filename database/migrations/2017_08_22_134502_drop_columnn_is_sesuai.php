<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnnIsSesuai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penyesuaian_dropping', function (Blueprint $table) {
            $table->dropColumn('is_sesuai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penyesuaian_dropping', function(Blueprint $table) {
            $table->boolean('is_sesuai');
        });
    }
}
