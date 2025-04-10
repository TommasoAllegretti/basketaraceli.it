<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\League;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            ['name' => 'Los Angeles Lakers', 'abbreviation' => 'LAL', 'league_id' => League::inRandomOrder()->first()?->id],
            ['name' => 'Golden State Warriors', 'abbreviation' => 'GSW', 'league_id' => League::inRandomOrder()->first()?->id],
            ['name' => 'Boston Celtics', 'abbreviation' => 'BOS', 'league_id' => League::inRandomOrder()->first()?->id],
            ['name' => 'Chicago Bulls', 'abbreviation' => 'CHI', 'league_id' => League::inRandomOrder()->first()?->id],
            ['name' => 'Miami Heat', 'abbreviation' => 'MIA', 'league_id' => League::inRandomOrder()->first()?->id],
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}
