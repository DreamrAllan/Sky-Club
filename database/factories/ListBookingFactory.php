<?php

namespace Database\Factories;

use App\Models\Field;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ListBooking>
 */
class ListBookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date,
            'session' => $this->faker->numberBetween(1, 24),
            'id_field' => Field::factory(),
            'id_booking' => Booking::factory(),
        ];
    }
}
