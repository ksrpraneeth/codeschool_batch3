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
        Schema::create('hoa_forms', function (Blueprint $table) {
            $table->id();
            $table->integer('form_type_id');
            $table->foreign('form_type_id')->references('id')->on('form_types');
            $table->integer('hoa_id');
            $table->foreign('hoa_id')->references('id')->on('hoas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoa_forms');
    }
};
