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
        Schema::create('earning_dedns', function (Blueprint $table) {
            $table->id();
            $table->integer('bill_transactions_id');
            $table->foreign('bill_transactions_id')->references('id')->on('bill_transactions');
            $table->integer('salary_type_id');
            $table->foreign('salary_type_id')->references('id')->on('salary_types');
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('earning_dedns');
    }
};
