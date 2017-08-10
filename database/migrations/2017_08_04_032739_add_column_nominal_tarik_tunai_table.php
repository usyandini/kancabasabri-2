<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnNominalTarikTunaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tarik_tunai', function (Blueprint $table) {
            $table->double('nominal_tarik');
            $table->double('sisa_dropping');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarik_tunai', function (Blueprint $table) {
            $table->dropColumn(['nominal_tarik']);
            $table->dropColumn(['sisa_dropping']);
        });
    }
}
