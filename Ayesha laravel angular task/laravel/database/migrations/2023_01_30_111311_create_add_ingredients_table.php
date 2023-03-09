<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_ingredients', function (Blueprint $table) {
            $table->id();
            $table->integer('recipe_id');
            $table->integer('ingredient_id');
            $table->foreign("recipe_id")->references("id")->on("recipe_models");
            $table->foreign("ingredient_id")->references("id")->on("ingredients");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_ingredients');
    }
};
