<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDependentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dependents', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('fullName',100)->nullable();
            $table->string('relationship',100)->nullable();
            $table->date('birthDate')->nullable();
            $table->integer('employee_id')->unsigned();
        });
        Schema::table('dependents', function($table) {
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
        Schema::dropIfExists('dependents');
    }
}
