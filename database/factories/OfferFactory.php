<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->fake()->jobTitle(),
            'description' => $this->fake()->paragraphs(3, true),
            'company_name' => $this->fake()->company(),
            'location' => $this->fake()->city(),
            'salary' => $this->fake()->optional(0.7)->randomFloat(2, 20000, 150000),
            'employment_type' => $this->fake()->randomElement(['Full-time', 'Part-time', 'Contract', 'Freelance', 'Internship']),
            'experience_level' => $this->fake()->randomElement(['Entry-level', 'Mid-level', 'Senior', 'Manager', 'Executive']),
            'required_skills' => json_encode($this->fake()->randomElements(['PHP', 'JavaScript', 'React', 'Vue', 'Laravel', 'MySQL', 'Python', 'AWS'], $this->fake()->numberBetween(2, 5))),
            'deadline' => $this->fake()->dateTimeBetween('+1 week', '+3 months')->format('Y-m-d'),
            'is_active' => $this->fake()->boolean(80),
            'image' => $this->fake()->optional(0.5)->imageUrl(),
            'user_id' => \App\Models\User::factory(),
            'created_at' => $this->fake()->dateTimeBetween('-1 month', 'now'),
            'updated_at' => function (array $attributes) {
                return $attributes['created_at'];
            },
        ];
    }
}
