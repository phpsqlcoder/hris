<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCutoffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cutoffs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();            
            $table->date('start');
            $table->date('end');
            $table->date('payroll');
            $table->integer('isDtrClosed')->default('0');
            $table->integer('isPayrollClosed')->default('0');
            $table->string('dtrClosedBy')->nullable();
            $table->string('payrollClosedBy')->nullable();
            $table->datetime('payrollClosedDate')->nullable();
            $table->datetime('dtrClosedDate')->nullable();
            $table->string('tayp',30);
            $table->string('code');
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
