<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnVerifiedByTarikTunaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tarik_tunai', function(Blueprint $table) {
            $table->integer('verified_by')->after('stat')->nullable();
            $table->dropColumn('berkas_tariktunai');
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
            $table->dropColumn('verified_by');
            $table->string('berkas_tariktunai')->after('sisa_dropping')->nullable();
        });
    }
}
