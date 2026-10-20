<?php

namespace Database\Factories;

use App\Models\Stat;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Stat> */
class StatFactory extends Factory
{
    public function definition(): array
    {
        return [
            'value' => (string) fake()->numberBetween(1, 99).'+',
            'label' => fake()->sentence(12),
            'sort' => fake()->numberBetween(1, 50),
            'is_published' => true,
        ];
    }

    public function hidden(): static
    {
        return $this->state(['is_published' => false]);
    }
}
