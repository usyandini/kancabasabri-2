<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIdTarikTunaiBerkasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('berkas_tariktunai', function(Blueprint $table) {
            $table->bigInteger('id_tariktunai')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('berkas_tariktunai', function(Blueprint $table) {
            $table->dropColumn('id_tariktunai');
        });
    }
}
