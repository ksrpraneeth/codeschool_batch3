<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamegroundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gamegrounds', function (Blueprint $table) {
            $table->id();
            $table->integer('ground_id');
            $table->foreign('ground_id')->references('id')->on('grounds');
            $table->integer('sport_id');
            $table->foreign('sport_id')->references('id')->on('sports');
            $table->time('duration',$precision=0);
            $table->bigInteger('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gamegrounds');
    }
}
