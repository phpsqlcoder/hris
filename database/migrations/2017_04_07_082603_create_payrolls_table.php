<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('cutoff_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->integer('present')->unsigned();
            $table->integer('absent')->unsigned();
            $table->integer('leave')->unsigned();
            $table->integer('suspended')->unsigned();
            $table->decimal('rate',5,2);
            $table->decimal('cola',5,2);
            $table->decimal('amount',5,2);
            $table->string('location');            
            $table->string('teamleader');
            $table->string('fullName');
            $table->decimal('adjustment',5,2)->nullable();
            $table->text('adjustmentRemarks')->nullable();
        });
        Schema::table('payrolls', function($table) {
            $table->foreign('employee_id')->references('id')->on('employees');
        }); 
        Schema::table('payrolls', function($table) {
            $table->foreign('cutoff_id')->references('id')->on('cutoffs');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
}
