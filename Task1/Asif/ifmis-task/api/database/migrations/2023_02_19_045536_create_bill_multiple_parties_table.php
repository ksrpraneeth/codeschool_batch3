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
        Schema::create('bill_multiple_parties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->string('agency_name');
            $table->string('bank_account_number');
            $table->foreign('bank_account_number')->references('bank_account_number')->on('agency_details');
            $table->string('bank_name');
            $table->string('bank_branch');
            $table->string('ifsc_code');
            $table->decimal('gross', 10, 2);
            $table->decimal('pt', 10, 2);
            $table->decimal('tds', 10, 2);
            $table->decimal('gst', 10, 2);
            $table->decimal('gis', 10, 2);
            $table->decimal('telangana_haritha_nidhi', 10, 2);
            $table->decimal('net', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_multiple_parties');
    }
};
