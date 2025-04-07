<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            ['name' => 'Los Angeles Lakers', 'abbreviation' => 'LAL'],
            ['name' => 'Golden State Warriors', 'abbreviation' => 'GSW'],
            ['name' => 'Boston Celtics', 'abbreviation' => 'BOS'],
            ['name' => 'Chicago Bulls', 'abbreviation' => 'CHI'],
            ['name' => 'Miami Heat', 'abbreviation' => 'MIA'],
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}
