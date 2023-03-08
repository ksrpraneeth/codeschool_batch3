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
        Schema::create('pay_slips', function (Blueprint $table) {
            $table->id();
            // $table->int('emp_id');
            // $table->int('emp_id')->references('emp_code')->on('employees');
            // $table->string('earning_type');
            // $table->string('earning_amount');
            // $table->string('dedn_type');
            // $table->string('dedn_amount');
            // $table->string('total_earnings');
            // $table->string('total_dedn');
            // $table->string('net');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_slips');
    }
};
