<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAmountDatetype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payrolls', function (Blueprint $table) {
           
            $table->decimal('amount',15,2)->change();
            $table->decimal('cola',15,2)->change();
            $table->decimal('rate',15,2)->change();
           $table->string('teamleader')->nullable()->change();
           $table->string('location')->nullable()->change();
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
