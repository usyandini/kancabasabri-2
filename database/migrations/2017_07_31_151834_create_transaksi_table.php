<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function(Blueprint $table) {
            $table->increments('id');
            $table->date('tgl');
            $table->bigInteger('item');
            $table->integer('qty_item');
            $table->string('desc', 100)->nullable();
            $table->bigInteger('sub_pos');
            $table->bigInteger('mata_anggaran');
            $table->bigInteger('akun_bank');
            $table->string('account', 50)->nullable();
            $table->double('anggaran');
            $table->double('total');
            $table->timestamps();
            $table->integer('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transaksi');
    }
}
