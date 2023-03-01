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
        Schema::create('scrutiny_responses', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->string('description');
            $table->string('response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scrutiny_responses');
    }
};
