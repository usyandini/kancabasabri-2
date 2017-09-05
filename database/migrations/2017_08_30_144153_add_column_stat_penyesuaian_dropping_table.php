<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStatPenyesuaianDroppingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penyesuaian_dropping', function(Blueprint $table) {
            $table->integer('stat')->nullable();
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
            $table->dropColumn('stat');
        });
    }
}
