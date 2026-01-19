<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ListBooking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sparing>
 */
class SparingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->paragraph,
            'other_team' => User::factory(),
            'created_by' => User::factory(),
            'id_list_booking' => ListBooking::factory(),
            'status' => $this->faker->randomElement(['waiting', 'done']),
        ];
    }
}
