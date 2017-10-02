<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBatchNumberingBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('batches', function(Blueprint $table) {
            $table->string('divisi')->nullable();
            $table->string('cabang')->nullable();
            $table->string('seq_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('batches', function(Blueprint $table) {
            $table->dropColumn(['divisi', 'cabang', 'seq_number']);
        });
    }
}
