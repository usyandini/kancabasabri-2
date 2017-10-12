<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomnUnitKerjaToFormMaster extends Migration
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
            $table->string('unit_kerja')->nullable();
            $table->renameColumn('active', 'status');
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
            $table->dropColumn('unit_kerja');
            $table->renameColumn('status', 'active');
        });
    }
}
