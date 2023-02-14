<?php

namespace Database\Seeders;

use App\Models\IfscCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IfscCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IfscCode::create([
            "ifsc_code" => "SBIN0012906",
            "bank_name" => "SBI",
            "state" => "Telangana",
            "branch" => "Rotary Nagar"
        ]);
    }
}
