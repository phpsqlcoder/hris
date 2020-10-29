<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('teamleader');
            $table->string('location');
            $table->decimal('rate',15,2);
            $table->integer('cutoff_id')->unsigned();
        });
         Schema::table('payroll_rates', function($table) {
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
        Schema::dropIfExists('payroll_rates');
    }
}
