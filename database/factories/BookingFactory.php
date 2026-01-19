<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Voucher;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_date' => $this->faker->dateTimeBetween('-90 days', 'now'),
            'status' => $this->faker->randomElement(['accept', 'pending', 'failed', 'canceled']),
            'rented_by' => User::factory(),
            'approved_by' => $this->faker->optional()->randomElement([User::factory(), null]),
            'id_voucher' => $this->faker->optional()->randomElement([Voucher::factory(), null]),
            'user_info' => $this->faker->optional()->randomElement([UserInfo::factory(), null]),
        ];
    }
}
