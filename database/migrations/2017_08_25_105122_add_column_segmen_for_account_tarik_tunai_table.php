<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSegmenForAccountTarikTunaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tarik_tunai', function(Blueprint $table) {
            $table->string('SEGMEN#1')->nullable();
            $table->string('SEGMEN#2')->nullable();
            $table->string('SEGMEN#3')->nullable();
            $table->string('SEGMEN#4')->nullable(); 
            $table->string('SEGMEN#5')->nullable();
            $table->string('SEGMEN#6')->nullable();
            $table->string('ACCOUNT')->nullable();
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
            $table->dropColumn('SEGMEN#1');
            $table->dropColumn('SEGMEN#2');
            $table->dropColumn('SEGMEN#3');
            $table->dropColumn('SEGMEN#4'); 
            $table->dropColumn('SEGMEN#5');
            $table->dropColumn('SEGMEN#6');
            $table->dropColumn('ACCOUNT');
        });
    }
}
