<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftToDtr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dtr', function (Blueprint $table) {           
            $table->integer('shift_id')->unsigned();            
        });

        Schema::table('dtr', function($table) {
            $table->foreign('shift_id')->references('id')->on('shifts');
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
