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
        DB::table('ddos')->insert([
            ['ddo_code' => '25001002018', 'designation' => 'Asst Accounts Officer', 'office_name' => 'Commissioner of Police Hyderabad City', 'branch_code' => '500004093', 'branch_name' => 'Treasury Branch, Hyderabad(GUNFOUNDRY)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('ddos')->truncate();
    }
};
