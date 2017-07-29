<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyTarikTunaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tarik_tunai', function(Blueprint $table) {
            $table->foreign('id_penyesuaian')->references('id')->on('penyesuaian_dropping')->onDelete('cascade');
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
           $table->dropForeign(['id_penyesuaian']); 
        });
    }
}
