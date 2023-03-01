<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Employee;
use App\Models\Type;
use App\Models\TypeForm;
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

        Type::firstOrCreate([
            'name' => "Deductions",
        ]);

        TypeForm::firstOrCreate([
            'name' => "PF",
            'type_id' => 2,
        ]);
        Employee::firstOrCreate([
            'name'=>'Bhanu',
            'phone_number'=>'9874565210',
            'dept'=>'Education',
            'designation'=>'Mandal Education Officer'
        ]);
    }
}
