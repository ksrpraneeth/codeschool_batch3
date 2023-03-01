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
            $table->string('form_number');
            $table->string('form_type');
            $table->string('hoa');
            $table->string('reference _number');
            $table->string('purpose');
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
        Schema::dropIfExists('transactions');
    }
};
