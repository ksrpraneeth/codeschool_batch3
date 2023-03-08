<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('forms')->insert([
            ['form_number' => 58, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['form_number' => 59, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['form_number' => 60, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('forms')->truncate();
    }
};
