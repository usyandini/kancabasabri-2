<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnListAnggaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('list_anggaran', function(Blueprint $table) {
            $table->boolean('is_rejected')->default(0)->nullable();
            $table->string('keterangan',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi', function(Blueprint $table) {
            $table->dropColumn(['is_rejected']);
            $table->dropColumn(['keterangan']);
        });
    }
}
