<?php

namespace Database\Factories;

use App\Enums\ServiceIcon;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Service> */
class ServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->words(3, true),
            'description' => fake()->sentence(14),
            'tag' => fake()->word().'/'.fake()->word(),
            'icon' => fake()->randomElement(ServiceIcon::cases()),
            'sort' => fake()->numberBetween(1, 50),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
