<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Team;
use App\Models\Player;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'home_team_id' => Team::inRandomOrder()->first()?->id,
            'away_team_id' => Team::inRandomOrder()->first()?->id,
            'date' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'home_team_total_score' => $this->faker->numberBetween(60, 130),
            'away_team_total_score' => $this->faker->numberBetween(60, 130),
            'home_team_first_quarter_score' => $this->faker->numberBetween(10, 35),
            'away_team_first_quarter_score' => $this->faker->numberBetween(10, 35),
            'home_team_second_quarter_score' => $this->faker->numberBetween(10, 35),
            'away_team_second_quarter_score' => $this->faker->numberBetween(10, 35),
            'home_team_third_quarter_score' => $this->faker->numberBetween(10, 35),
            'away_team_third_quarter_score' => $this->faker->numberBetween(10, 35),
            'home_team_fourth_quarter_score' => $this->faker->numberBetween(10, 35),
            'away_team_fourth_quarter_score' => $this->faker->numberBetween(10, 35),
            'top_scorer_id' => Player::inRandomOrder('id')->first()->id,
            'top_rebounder_id' => Player::inRandomOrder('id')->first()->id,
            'top_assister_id' => Player::inRandomOrder('id')->first()->id,
            'top_efficiency_id' => Player::inRandomOrder('id')->first()->id,
        ];
    }
}
