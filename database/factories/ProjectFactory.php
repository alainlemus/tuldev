<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Project> */
class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1, 9999),
            'description' => fake()->sentence(16),
            'tags' => ['Sitio web', 'Catálogo'],
            'badge' => null,
            'scroll_image' => null,
            'scroll_duration' => fake()->numberBetween(14, 22),
            'scroll_delay' => 0,
            'sort' => fake()->numberBetween(1, 50),
            'is_published' => true,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(['is_published' => false]);
    }
}
