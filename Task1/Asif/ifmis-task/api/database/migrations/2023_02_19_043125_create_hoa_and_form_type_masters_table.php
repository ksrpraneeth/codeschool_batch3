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
        Schema::create('hoa_and_form_type_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_type_id');
            $table->foreign('form_type_id')->references('id')->on('form_types');
            $table->unsignedBigInteger('head_of_account_id');
            $table->foreign('head_of_account_id')->references('id')->on('head_of_accounts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoa_and_form_type_masters');
    }
};
