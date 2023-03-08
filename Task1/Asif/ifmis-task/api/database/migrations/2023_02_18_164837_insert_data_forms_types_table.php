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
        DB::table('form_types')->insert([
            ['form_id' => 1, 'name' => 'WATER CHARGES', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['form_id' => 1, 'name' => 'ELECTRICITY CHARGES', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['form_id' => 1, 'name' => 'MATERIAL CHARGES', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('form_types')->truncate();
    }
};
