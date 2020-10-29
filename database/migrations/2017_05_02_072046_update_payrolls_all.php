<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePayrollsAll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->decimal('present',15,2)->change();
            $table->decimal('absent',15,2)->change();
            $table->decimal('leave',15,2)->change();
            $table->decimal('suspended',15,2)->change();
            $table->decimal('amount',15,2)->change();
            $table->decimal('adjustment',15,2)->change();       
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
