<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDropping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dropping', function (Blueprint $table) {
            $db = DB::connection('sqlsrv2')->getDatabaseName();

            $table->bigInteger('RECID');
            $table->string('JOURNALNAME',50);
            $table->string('JOURNALNUM',50);
            $table->date('TRANSDATE');
            $table->string('BANK_DROPPING',50);
            $table->string('REKENING_DROPPING',50);
            $table->string('AKUN_DROPPING',50);
            $table->string('CABANG_DROPPING',50);
            $table->string('TXT',100)->nullable();
            $table->double('DEBIT',50)->nullable();
            $table->double('KREDIT',50)->nullable();            
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
        Schema::drop('dropping');
    }
}