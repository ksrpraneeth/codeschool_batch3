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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('form_number');
            $table->foreign('form_number')->references('form_number')->on('forms');
            $table->string('form_type');
            $table->decimal('gross', 10 ,2);
            $table->decimal('pt', 10 ,2);
            $table->decimal('tds', 10 ,2);
            $table->decimal('gst', 10 ,2);
            $table->decimal('gis', 10 ,2);
            $table->decimal('telangana_haritha_nidhi', 10 ,2);
            $table->decimal('deduction', 10 ,2);
            $table->decimal('net', 10, 2);
            $table->string('hoa');
            $table->foreign('hoa')->references('hoa')->on('head_of_accounts');
            $table->string('reference_number');
            $table->string('smh');
            $table->text('purpose');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
