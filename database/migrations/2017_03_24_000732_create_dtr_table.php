<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDtrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('dtr', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();            
            $table->date('dtrDate');
            $table->string('tayp');
            $table->decimal('hours',5,2);
            $table->string('code');
            $table->string('location');            
            $table->string('teamleader');
            $table->decimal('adjustment',5,2)->nullable();
            $table->text('adjustmentRemarks')->nullable();
            $table->integer('cutoff_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            //$table->integer('shift_id')->unsigned();
            
        });

        Schema::table('dtr', function($table) {
            $table->foreign('cutoff_id')->references('id')->on('cutoffs');
        });    

        Schema::table('dtr', function($table) {
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
        //
    }
}
