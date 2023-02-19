<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scrutiny_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_type_id');
            $table->foreign('form_type_id')->references('id')->on('form_types');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scrutiny_items');
    }
};