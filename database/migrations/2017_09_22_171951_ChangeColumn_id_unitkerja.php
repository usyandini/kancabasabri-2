<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnIdUnitkerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tl_tanggal', function(Blueprint $table) {
            $table->dropColumn('id_unitkerja');
            $table->string('unitkerja')->after('id1')->nullable();
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
        Schema::table('tl_tanggal', function(Blueprint $table) {
            $table->dropColumn('unitkerja');
            $table->string('id_unitkerja')->after('id1');
        });
    }
}
