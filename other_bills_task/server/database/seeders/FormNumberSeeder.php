<?php

namespace Database\Seeders;

use App\Models\FormNumber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FormNumber::create(["form_number" => '58']);
    }
}
