<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BillId;
use App\Models\Employee;
use App\Models\MenuItem;
use App\Models\Module;
use App\Models\User;
use App\Models\UserModule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate([
            "email" => 's@s.com',
            'password' => Hash::make('12345'),
            'name' => 'Sampath'
        ]);
        $module = Module::firstOrCreate([
            "name" => "Bill ID",
            "icon" => "fas fa-user",
        ]);
        UserModule::firstOrCreate([
            "user_id" => $user->id,
            "module_id" => $module->id
        ]);
        MenuItem::firstOrCreate([
            "module_id" => $module->id,
            "name" => "Employee Master",
            "state" => "employeeMasterstate"
        ]);
        $billId = BillId::firstOrCreate([
            "name" => "1",
            "user_id" => $user->id
        ]);
        Employee::firstOrCreate([
            "name" => "Sampath Bandla",
            "department" => "IT",
            "designation" => "Web Developer",
            "bill_ids_id" => $billId->id,
            "employee_code" => "EMP01",
            "bank_ac_no" => "1234567890",
        ]);
    }
}
