<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViolationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('violations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->text('details')->nullable();
            $table->string('incidentType',100)->nullable();
            $table->dateTime('incidentDateStart');
            $table->dateTime('incidentDateEnd')->nullable();
            $table->dateTime('suspendDateStart')->nullable();
            $table->dateTime('suspendDateEnd')->nullable();
            $table->integer('employee_id')->unsigned();
        });
        Schema::table('violations', function($table) {
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
