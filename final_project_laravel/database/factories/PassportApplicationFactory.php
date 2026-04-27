<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PassportApplication>
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
        return [
            'user_id' => User::factory(),
            'branch_id' => Branch::factory(),
            'serial_number' => 'SER-' . strtoupper(Str::random(8)),
            'national_id' => $this->faker->numerify('##########'),
            'full_name' => $this->faker->name,
            'status' => $this->faker->randomElement(['pending', 'processing', 'ready', 'collected']),
            'tracking_number' => 'TRK-' . strtoupper(Str::random(10)),
        ];
    }
}
