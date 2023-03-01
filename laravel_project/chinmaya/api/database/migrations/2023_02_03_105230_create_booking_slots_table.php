<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_slots', function (Blueprint $table) {
            Schema::create('booking_slots', function (Blueprint $table) {
            $table->id();
            $table->integer('gameground_id');
            $table->foreign('gameground_id')->references('id')->on('gamegrounds');
            $table->integer('day_id');
            $table->foreign('day_id')->references('id')->on('days');
            $table->time('start_time',$precision=0);
            $table->time('end_time',$precision=0);
        });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_slots');
    }
}
