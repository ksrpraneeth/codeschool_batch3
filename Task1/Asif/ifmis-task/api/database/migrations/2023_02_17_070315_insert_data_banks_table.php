<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('banks')->insert([
            ['name' => 'SBI', 'branch' => 'JUBILEE HILLS YUVA BRANCH', 'state' => 'TELANGANA', 'ifsc_code' => 'SBIN0015084', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'ABC Bank', 'branch' => 'PRASHASAN NAGAR', 'state' => 'TELANGANA', 'ifsc_code' => 'ABCD0123456', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('banks')->truncate();
    }
};
