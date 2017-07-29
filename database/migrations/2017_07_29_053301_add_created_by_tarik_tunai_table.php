<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedByTarikTunaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tarik_tunai', function(Blueprint $table) {
            $table->integer('created_by')->unsigned()->after('id_penyesuaian');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarik_tunai', function(Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['created_by']);
        });
    }
}
