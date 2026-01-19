<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'username' => $this->faker->unique()->userName,
            'no_telp' => $this->faker->unique()->phoneNumber,
            'team' => $this->faker->optional()->company,
            'address' => $this->faker->optional()->address,
            'role' => $this->faker->randomElement(['penyewa', 'admin']),
            'date_of_birth' => $this->faker->optional()->date,
            'profile_photo' => $this->faker->optional()->imageUrl,
            'password' => bcrypt('password'), // Default password
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
