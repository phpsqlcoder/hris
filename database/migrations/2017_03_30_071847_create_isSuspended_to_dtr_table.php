<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIsSuspendedToDtrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('dtr', function (Blueprint $table) {
            $table->integer('isSuspended')->default('0');
            $table->integer('isPosted')->default('0');  
            $table->integer('isLeave')->default('0');             
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
