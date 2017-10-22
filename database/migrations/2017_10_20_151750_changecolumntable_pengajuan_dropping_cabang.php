<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangecolumntablePengajuanDroppingCabang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::table('pengajuan_dropping_cabang', function(Blueprint $table) {
            $table->string('jumlah_diajukan')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan_dropping_cabang', function(Blueprint $table) {
            $table->integer('jumlah_diajukan')->change();
        });
    }
}
