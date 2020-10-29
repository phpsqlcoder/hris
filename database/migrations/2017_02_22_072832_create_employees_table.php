<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('lName',100);
            $table->string('fName',100);
            $table->string('mName',100);
            $table->string('extName',100)->nullable();
            $table->string('fullName');
            $table->string('sss',50)->nullable();
            $table->string('hdmf',50)->nullable();
            $table->string('philhealth',50)->nullable();
            $table->string('tin',50)->nullable();
            $table->string('status')->nullable();
            $table->date('hiredDate')->nullable();
            $table->date('birthDate')->nullable();
            $table->string('birthPlace')->nullable();
            $table->string('image')->nullable();
            $table->string('gender',10)->nullable();
            $table->string('address')->nullable();
            $table->string('contactNo')->nullable();
            $table->string('civilStatus')->nullable();
            $table->string('religion')->nullable();
            $table->string('emergencyContactNo')->nullable();
            $table->string('emergencyContactPerson')->nullable();
            $table->string('empid')->unique();
             $table->string('bloodType',10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
