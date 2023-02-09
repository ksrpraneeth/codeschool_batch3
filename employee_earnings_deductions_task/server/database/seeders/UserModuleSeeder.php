<?php

namespace Database\Seeders;

use App\Models\UserModule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserModule::create([
            "user_id" => '2',
            "module_id" => '2'
        ]);
    }
}
