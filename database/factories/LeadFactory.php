<?php

namespace Database\Factories;

use App\Enums\LeadStatus;
use App\Enums\LeadType;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Lead> */
class LeadFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'business' => fake()->company(),
            'whatsapp' => fake()->numerify('77########'),
            'email' => fake()->safeEmail(),
            'type' => fake()->randomElement(LeadType::cases()),
            'message' => fake()->sentence(12),
            'status' => LeadStatus::Nuevo,
            'ip' => fake()->ipv4(),
        ];
    }
}
