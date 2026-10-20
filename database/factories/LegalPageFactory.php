<?php

namespace Database\Factories;

use App\Models\LegalPage;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<LegalPage> */
class LegalPageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(2),
            'title' => fake()->sentence(3),
            'content' => '<p>'.fake()->paragraph().'</p>',
            'sort' => fake()->numberBetween(1, 20),
            'is_published' => true,
        ];
    }

    public function hidden(): static
    {
        return $this->state(['is_published' => false]);
    }
}
