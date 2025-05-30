<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\League;
use App\Models\Club;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            ['abbreviation' => 'LAL', 'league_id' => League::inRandomOrder()->first()?->id, 'club_id' => Club::inRandomOrder()->first()?->id],
            ['abbreviation' => 'GSW', 'league_id' => League::inRandomOrder()->first()?->id, 'club_id' => Club::inRandomOrder()->first()?->id],
            ['abbreviation' => 'BOS', 'league_id' => League::inRandomOrder()->first()?->id, 'club_id' => Club::inRandomOrder()->first()?->id],
            ['abbreviation' => 'CHI', 'league_id' => League::inRandomOrder()->first()?->id, 'club_id' => Club::inRandomOrder()->first()?->id],
            ['abbreviation' => 'MIA', 'league_id' => League::inRandomOrder()->first()?->id, 'club_id' => Club::inRandomOrder()->first()?->id],
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}
