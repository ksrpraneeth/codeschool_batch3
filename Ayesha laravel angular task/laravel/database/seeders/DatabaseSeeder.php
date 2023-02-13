<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ingredient;
use App\Models\User;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        ingredient::insert([
            ["ingredients"=>"rice"],
            ["ingredients"=>"chicken"],
            ["ingredients"=>"curd"],
            ["ingredients"=>"vegetables"],
            ["ingredients"=>"butter"],
            ["ingredients"=>"paneer"],
            ["ingredients"=>"cream"],

        ]);
        User::insert([
            [
                'name'=>'ayesha',
                'email'=>'ayesha@g.m',
                'password'=>Hash::make('123')
            ]
        ]);
    }
}
