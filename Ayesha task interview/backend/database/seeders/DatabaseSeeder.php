<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Deduction;
use App\Models\Earning;
use App\Models\Employee;
use App\Models\SalaryType;
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
        Employee::firstOrCreate([
            'name'=>'Ayesha Fatima',
            'emp_code'=>'1',
            'dept'=>'IT',
            'designation'=>'Software Engineer'
        ]);
        Earning::firstOrCreate([
            'earning_type'=>'Basic Pay',
        ]);
        Earning::firstOrCreate([
            'earning_type'=>'HR allowances',
        ]);
        Deduction::firstOrCreate([
            'dedn_type'=>'Income tax'
        ]);
        Deduction::firstOrCreate([
            'dedn_type'=>'Food Allowances'
        ]);
        SalaryType::firstOrCreate([
            'name'=>'Basic Pay',
            'type'=>'Earning'
        ]);
        SalaryType::firstOrCreate([
            'name'=>'HR Allowances',
            'type'=>'Earning'
        ]);
        SalaryType::firstOrCreate([
            'name'=>'Food Allowances',
            'type'=>'Deduction'
        ]);
        SalaryType::firstOrCreate([
            'name'=>'Income Tax',
            'type'=>'Deduction'
        ]);
    }
}