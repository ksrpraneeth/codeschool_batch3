<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\IfscCode;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        IfscCode::firstOrCreate([
            'ifsc_code'=>'HDFC0000128',
            'bank_name'=>'HDFC BANK LTD',
            'state'=>'Chennai',
            'branch'=>'Chennai Credit Card Operations'
        ]);
        IfscCode::firstOrCreate([
            'ifsc_code'=>'SBIN0070264',
            'bank_name'=>'SBI Bank',
            'state'=>'Hyderabad',
            'branch'=>'Abids'
        ]);
        IfscCode::firstOrCreate([
            'ifsc_code'=>'SBIN0012917',
            'bank_name'=>'SBI Bank',
            'state'=>'Telangana',
            'branch'=>'Ramnagar'
        ]);
    }
}
