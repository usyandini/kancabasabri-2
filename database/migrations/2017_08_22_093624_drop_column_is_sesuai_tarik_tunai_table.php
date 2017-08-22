<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnIsSesuaiTarikTunaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tarik_tunai', function($table) {
             $table->dropColumn('is_sesuai');
             $table->dropColumn('id_penyesuaian');
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarik_tunai', function($table) {
            $table->boolean('is_sesuai'); 
            $table->integer('id_penyesuaian')->unsigned()->default(null)->nullable();
        });
    }
}
