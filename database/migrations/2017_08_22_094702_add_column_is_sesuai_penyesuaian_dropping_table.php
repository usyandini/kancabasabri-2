<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIsSesuaiPenyesuaianDroppingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penyesuaian_dropping', function(Blueprint $table) {
            $table->bigInteger('id_dropping')->after('id');
            $table->boolean('is_sesuai')->before('is_pengembalian');
            $table->integer('created_by')->unsigned()->after('updated_at');
            $table->double('nominal_dropping')->after(['nominal']); 
            $table->string('berkas_penyesuaian')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penyesuaian_dropping', function (Blueprint $table) {
            $table->dropColumn('is_sesuai');
            $table->dropColumn('id_dropping');
            $table->dropColumn('created_by');
            $table->dropColumn('nominal_dropping');
            $table->dropColumn('berkas_penyesuaian');
        });
    }
}
