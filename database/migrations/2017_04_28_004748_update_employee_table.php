<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('employees', function (Blueprint $table) {            
            $table->decimal('sss_contribution',15,2)->default(0.00);
            $table->decimal('hdmf_contribution',15,2)->default(0.00);
            $table->decimal('philhealth_contribution',15,2)->default(0.00);          
            $table->date('rateUpdateDate')->default('2017-01-01');
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
