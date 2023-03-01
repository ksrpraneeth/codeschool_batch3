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
        Schema::create('transaction_many_agencies', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->string('agency_name');
            $table->string('agency_bank_account');
            $table->string('ifsc_code');
            $table->string('gross');
            $table->string('ptdedn');
            $table->string('tds');
            $table->string('gst');
            $table->string('gis');
            $table->string('thn');
            $table->string('netamt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_many_agencies');
    }
};
