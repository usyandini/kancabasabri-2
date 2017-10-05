<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomnIdMasterToFormMasterPelaporan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('form_master_pelaporan', function(Blueprint $table) {
            $table->string('id_master')->nullable();
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
        Schema::table('form_master_pelaporan', function(Blueprint $table) {
            $table->dropColumn('id_master');
        });
    }
}
