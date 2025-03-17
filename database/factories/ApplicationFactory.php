<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'offer_id' => $this->fake()->numberBetween(1, 10),
            'user_id' => $this->fake()->numberBetween(1, 10),
            'resume_path' => $this->fake()->word() . '.pdf',
        ];
    }
}
