<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = ['Guard', 'Forward', 'Center'];
        $teams = ['Lakers', 'Warriors', 'Celtics', 'Nets', 'Bulls', 'Heat'];

        return [
            'name' => $this->faker->name,
            'position' => $this->faker->randomElement($positions),
            'height_cm' => $this->faker->numberBetween(175, 220),
            'birth_date' => $this->faker->date('Y-m-d', '-18 years'),
            'team' => $this->faker->randomElement($teams),
            'jersey_number' => $this->faker->numberBetween(0, 99),
            'points_per_game' => $this->faker->randomFloat(1, 5, 35),
            'rebounds_per_game' => $this->faker->randomFloat(1, 1, 15),
            'assists_per_game' => $this->faker->randomFloat(1, 1, 10),
        ];
    }
}
