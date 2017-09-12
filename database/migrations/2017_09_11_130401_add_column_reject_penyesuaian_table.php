<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRejectPenyesuaianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reject_penyesuaian', function(Blueprint $table) {
            $table->integer('level')->after('id_penyesuaian')->nullable();
            $table->integer('rejected_by')->after('level')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reject_penyesuaian', function(Blueprint $table) {
            $table->dropColumn('level');
            $table->dropColumn('rejected_by');
        });
    }
}
