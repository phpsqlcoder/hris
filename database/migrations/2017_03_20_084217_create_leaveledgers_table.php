<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveledgersTable extends Migration
{
   
    public function up()
    {
        Schema::create('leaveledgers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();            
            $table->decimal('qty',5,2);
            $table->string('tayp');
            $table->text('remarks');
            $table->date('effectivityDate');
            $table->integer('employee_id')->unsigned();
            $table->integer('leave_id')->unsigned();
        });
        Schema::table('leaveledgers', function($table) {
            $table->foreign('employee_id')->references('id')->on('employees');
        });
        Schema::table('leaveledgers', function($table) {
            $table->foreign('leave_id')->references('id')->on('leaves');
        });
    }

   
    public function down()
    {
        //
    }
}
