<?php

namespace Database\Factories;

use App\Models\League;
use App\Models\Club;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'abbreviation' => strtoupper($this->faker->lexify('???')),
            'league_id' => League::inRandomOrder()->first()?->id,
            'club_id' => Club::inRandomOrder()->first()?->id,
        ];
    }
} 