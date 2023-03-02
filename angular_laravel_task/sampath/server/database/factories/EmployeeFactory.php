<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name,
            'phone' => fake()->phoneNumber,
            'email' => fake()->unique()->safeEmail,
            'dob' => fake()->date(),
            'salary' => fake()->randomNumber(5),
            'position' => fake()->jobTitle,
            'gender' => fake()->randomElement(['male', 'female'])
        ];
    }
}
