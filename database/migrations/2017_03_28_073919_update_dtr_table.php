<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDtrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dtr', function (Blueprint $table) {
            $table->string('tayp')->nullable()->change();
            $table->decimal('hours',5,2)->nullable()->change();
            $table->string('code')->nullable()->change();
            $table->string('location')->nullable()->change();            
            $table->string('teamleader')->nullable()->change();
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
