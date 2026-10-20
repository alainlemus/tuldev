<?php

namespace Database\Factories;

use App\Models\ProcessStep;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<ProcessStep> */
class ProcessStepFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(3),
            'description' => fake()->sentence(12),
            'sort' => fake()->numberBetween(1, 50),
            'is_active' => true,
        ];
    }

    public function hidden(): static
    {
        return $this->state(['is_active' => false]);
    }
}
