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
        Schema::create('bill_entries', function (Blueprint $table) {
            $table->id();
            $table->integer("bill_id");
            $table->date("from_date");
            $table->date("to_date");
            $table->integer("type_form_id");
            $table->integer("Total_amount");
            $table->foreign("type_form_id")->references("id")->on("type_forms");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_entries');
    }
};
