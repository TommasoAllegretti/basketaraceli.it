<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Game;
use App\Models\Player;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stat>
 */
class StatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'player_id' => Player::inRandomOrder()->first()?->id,
            'game_id' => Game::inRandomOrder()->first()?->id,
            'seconds_played' => $this->faker->numberBetween(0, 3000),
            'points' => $this->faker->numberBetween(0, 50),
            'field_goals_made' => $this->faker->numberBetween(0, 10),
            'field_goals_attempted' => $this->faker->numberBetween(0, 10),
            'field_goal_percentage' => $this->faker->numberBetween(0, 100),
            'three_point_field_goals_made' => $this->faker->numberBetween(0, 10),
            'three_point_field_goals_attempted' => $this->faker->numberBetween(0, 10),
            'three_point_field_goal_percentage' => $this->faker->numberBetween(0, 100),
            'two_point_field_goals_made' => $this->faker->numberBetween(0, 10),
            'two_point_field_goals_attempted' => $this->faker->numberBetween(0, 10),
            'two_point_field_goal_percentage' => $this->faker->numberBetween(0, 100),
            'free_throws_made' => $this->faker->numberBetween(0, int2: 10),
            'free_throws_attempted' => $this->faker->numberBetween(0, 10),
            'free_throw_percentage' => $this->faker->numberBetween(0, 100),
            'offensive_rebounds' => $this->faker->numberBetween(0, 10),
            'defensive_rebounds' => $this->faker->numberBetween(0, 10),
            'total_rebounds' => $this->faker->numberBetween(0, 20),
            'assists' => $this->faker->numberBetween(0, 10),
            'turnovers' => $this->faker->numberBetween(0, 5),
            'steals' => $this->faker->numberBetween(0, 5),
            'blocks' => $this->faker->numberBetween(0, 3),
            'personal_fouls' => $this->faker->numberBetween(0, 5),
            'performance_index_rating' => $this->faker->numberBetween(int1: -10, int2: 20),
            'efficiency' => $this->faker->numberBetween(0, 20),
            'plus_minus' => $this->faker->numberBetween(-10, 20)
        ];
    }
}
