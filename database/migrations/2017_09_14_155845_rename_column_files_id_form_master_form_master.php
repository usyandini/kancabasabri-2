<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnFilesIdFormMasterFormMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('file_form_master', function(Blueprint $table) {
            $table->renameColumn('id_form_master', 'id_list_form_master');
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
        Schema::table('file_form_master', function(Blueprint $table) {
            $table->renameColumn('id_list_form_master', 'id_form_master');
        });
    }
}
