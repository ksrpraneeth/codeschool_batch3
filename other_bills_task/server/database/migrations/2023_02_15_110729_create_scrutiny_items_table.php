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
        Schema::create('scrutiny_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("form_type_id");
            $table->foreign("form_type_id")->references("id")->on("form_types");
            $table->string("scrutiny_desc");
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
        Schema::dropIfExists('scrutiny_items');
    }
};
