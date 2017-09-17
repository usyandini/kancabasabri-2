<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnVerifiedByPenyesuaianDroppingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penyesuaian_dropping', function(Blueprint $table) {
            $table->integer('1_verified_by')->after('stat')->nullable();
            $table->integer('2_verified_by')->after('stat')->nullable();
            $table->dropColumn('berkas_penyesuaian');
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
            $table->dropColumn('1_verified_by');
            $table->dropColumn('2_verified_by');
            $table->string('berkas_penyesuaian')->after('nominal_dropping')->nullable();
        });
    }
}
