<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeBudgetcontrolHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_control_history', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('month_period');
            $table->integer('year_period');
            $table->string('account');
            $table->double('savepoint_amount');
            $table->double('actual_amount');
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
        Schema::drop('budget_control_history');
    }
}
