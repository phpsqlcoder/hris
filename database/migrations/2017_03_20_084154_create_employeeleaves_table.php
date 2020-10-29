<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeleavesTable extends Migration
{
   
    public function up()
    {
        Schema::create('employeeleaves', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();            
            $table->decimal('balance',5,2);
            $table->integer('employee_id')->unsigned();
            $table->integer('leave_id')->unsigned();
        });
        Schema::table('employeeleaves', function($table) {
            $table->foreign('employee_id')->references('id')->on('employees');
        });
        Schema::table('employeeleaves', function($table) {
            $table->foreign('leave_id')->references('id')->on('leaves');
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
