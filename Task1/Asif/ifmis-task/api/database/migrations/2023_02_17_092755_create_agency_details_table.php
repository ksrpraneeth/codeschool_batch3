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
        Schema::create('agency_details', function (Blueprint $table) {
            $table->id();
            $table->string('agency_name');
            $table->string('bank_account_number')->unique();
            $table->string('ifsc_code');
            $table->foreign('ifsc_code')->references('ifsc_code')->on('banks');
            $table->string('gst_number')->nullable();
            $table->string('pan_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_details');
    }
};
