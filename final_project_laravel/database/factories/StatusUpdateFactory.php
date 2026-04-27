<?php

namespace Database\Factories;

use App\Models\PassportApplication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StatusUpdate>
 */
class StatusUpdateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'passport_application_id' => PassportApplication::factory(),
            'status' => $this->faker->randomElement(['pending', 'processing', 'ready', 'collected']),
            'comment' => $this->faker->sentence,
            'updated_by' => User::factory(),
        ];
    }
}
