<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePayrollTableAddFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            
            $table->string('sss')->nullable();
            $table->string('hdmf')->nullable();
            $table->string('philhealth')->nullable();          
            $table->string('contractor')->nullable();

            $table->string('present_amount',15,2)->default(0.00);
            $table->string('absent_amount',15,2)->default(0.00);
            $table->string('leave_amount',15,2)->default(0.00);
            $table->string('suspended_amount',15,2)->default(0.00);

            $table->string('present',15,2)->default(0.00)->change();
            $table->string('absent',15,2)->default(0.00)->change();
            $table->string('leave',15,2)->default(0.00)->change();
            $table->string('suspended',15,2)->default(0.00)->change();
            $table->string('rate',15,2)->default(0.00)->change();
            $table->string('amount',15,2)->default(0.00)->change();

            $table->decimal('sss_amount',15,2)->default(0.00);
            $table->decimal('hdmf_amount',15,2)->default(0.00);
            $table->decimal('philhealth_amount',15,2)->default(0.00);

            $table->decimal('sss_loan_amount',15,2)->default(0.00);
            $table->decimal('hdmf_loan_amount',15,2)->default(0.00);

            $table->string('adjustment_days')->default(0.00);
            
            $table->integer('payroll_date');
            $table->integer('status');
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
