<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voucher>
 */
class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'expire_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'code' => strtoupper($this->faker->unique()->bothify('???###')),
            'quota' => $this->faker->numberBetween(1, 100),
            'discount_price' => $this->faker->optional()->numberBetween(1000, 10000),
            'discount_percentage' => $this->faker->optional()->numberBetween(1, 100),
            'max_discount' => $this->faker->optional()->numberBetween(1000, 5000),
            'min_price' => $this->faker->numberBetween(1000, 10000),
        ];
    }
}
