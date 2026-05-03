<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\PassportApplication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PassportApplication>
 */
class PassportApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakerAr = \Faker\Factory::create('ar_SA');

        return [
            'user_id' => User::factory(),
            'branch_id' => Branch::factory(),
            'pickup_branch_id' => Branch::factory(),
            'serial_number' => 'SER-'.strtoupper(Str::random(8)),
            'national_id' => $this->faker->numerify('##########'),
            'full_name' => $fakerAr->name,
            'mother_name' => $fakerAr->name('female'),
            'date_of_birth' => $this->faker->date('Y-m-d', '-18 years'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'address' => $fakerAr->address,
            'status' => $this->faker->randomElement(['pending', 'processing', 'ready', 'collected']),
            'tracking_number' => 'TRK-'.strtoupper(Str::random(10)),
        ];
    }
}
