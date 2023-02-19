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
        DB::table('head_of_accounts')->insert([
            
            ['mjh' => '2055', 'mjh_desc' => 'Police', 'smjh' => '00', 'smjh_desc' => 'NA', 'mih' => '108', 'mih_desc' => 'State Headquarters Police', 'gsh' => '00', 'gsh_desc' => 'NA', 'sh' => '05', 'sh_desc' => 'City Police Force', 'dh' => '130', 'dh_desc' => 'Office Expenses', 'sdh' => '133', 'sdh_desc' => 'Water and Electricity Charges', 'hoa' => '2055001080005130133NVN', 'hoa_tier' => '2055-00-108-00-05-130-133-NVN', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('head_of_accounts')->truncate();
    }
};
