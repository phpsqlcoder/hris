<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('employee_id')->unsigned();
            $table->decimal('amount',15,2);
            $table->string('loanType',15,2);
            $table->integer('deductionNumber');
            $table->date('startDate');
            $table->integer('status');
        });
        Schema::table('loans', function($table) {
            $table->foreign('employee_id')->references('id')->on('employees');
        });    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
