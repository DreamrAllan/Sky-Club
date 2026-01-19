<?php

namespace Database\Factories;

use App\Models\FieldDescription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FieldDescription>
 */
class FieldDescriptionFactory extends Factory
{
    protected $model = FieldDescription::class;

    public function definition()
    {
        return [
            'description' => $this->faker->paragraphs(3, true), // Generate a long text description
        ];
    }
}
