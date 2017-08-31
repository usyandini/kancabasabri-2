<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnSegmenPenyesuaianDroppingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penyesuaian_dropping', function(Blueprint $table) {
            $table->renameColumn('SEGMEN#1', 'SEGMEN_1');
            $table->renameColumn('SEGMEN#2', 'SEGMEN_2');
            $table->renameColumn('SEGMEN#3', 'SEGMEN_3');
            $table->renameColumn('SEGMEN#4', 'SEGMEN_4');
            $table->renameColumn('SEGMEN#5', 'SEGMEN_5');
            $table->renameColumn('SEGMEN#6', 'SEGMEN_6');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penyesuaian_dropping', function(Blueprint $table) {
            $table->renameColumn('SEGMEN_1', 'SEGMEN#1');
            $table->renameColumn('SEGMEN_2', 'SEGMEN#2');
            $table->renameColumn('SEGMEN_3', 'SEGMEN#3');
            $table->renameColumn('SEGMEN_4', 'SEGMEN#4');
            $table->renameColumn('SEGMEN_5', 'SEGMEN#5');
            $table->renameColumn('SEGMEN_6', 'SEGMEN#6');
        });
    }
}
