<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableItemMasterAnggaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('item_master_anggaran', function(Blueprint $table) {
            $table->increments('id');
            $table->string('jenis');
            $table->string('kelompok');
            $table->string('pos_anggaran');
            $table->string('sub_pos');
            $table->string('mata_anggaran');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->datetime('deleted_at')->nullable();
            $table->timestamps();
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
        Schema::drop('item_master_anggaran');
    }
}
