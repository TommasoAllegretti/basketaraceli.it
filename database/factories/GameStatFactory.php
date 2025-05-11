<?php
namespace Database\Factories;

use App\Models\GameStat;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameStatFactory extends Factory
{
    protected $model = GameStat::class;

    public function definition(): array
    {
        return [
            'team_id' => Team::inRandomOrder()->first()?->id,
            'game_id' => Game::inRandomOrder()->first()?->id,
            'points' => $this->faker->numberBetween(0, 100),
            'field_goals_attempted' => $this->faker->numberBetween(0, 50),
            'field_goals_made' => $this->faker->numberBetween(0, 50),
            'field_goal_percentage' => $this->faker->randomFloat(2, 0, 1),
            'three_point_field_goals_made' => $this->faker->numberBetween(0, 20),
            'three_point_field_goals_attempted' => $this->faker->numberBetween(0, 20),
            'three_point_field_goal_percentage' => $this->faker->randomFloat(2, 0, 1),
            'two_point_field_goals_made' => $this->faker->numberBetween(0, 30),
            'two_point_field_goals_attempted' => $this->faker->numberBetween(0, 30),
            'two_point_field_goal_percentage' => $this->faker->randomFloat(2, 0, 1),
            'free_throws_made' => $this->faker->numberBetween(0, 20),
            'free_throws_attempted' => $this->faker->numberBetween(0, 20),
            'free_throw_percentage' => $this->faker->randomFloat(2, 0, 1),
            'offensive_rebounds' => $this->faker->numberBetween(0, 20),
            'defensive_rebounds' => $this->faker->numberBetween(0, 20),
            'total_rebounds' => $this->faker->numberBetween(0, 40),
            'assists' => $this->faker->numberBetween(0, 20),
            'turnovers' => $this->faker->numberBetween(0, 20),
            'steals' => $this->faker->numberBetween(0, 10),
            'blocks' => $this->faker->numberBetween(0, 10),
            'personal_fouls' => $this->faker->numberBetween(0, 10),
            'performance_index_rating' => $this->faker->numberBetween(0, 50),
            'efficiency' => $this->faker->numberBetween(0, 50),
        ];
    }
}