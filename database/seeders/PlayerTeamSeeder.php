<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Player;
use App\Models\Team;

class PlayerTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all players
        $players = Player::all();

        // Get all teams
        $teams = Team::all();

        // Attach players to random teams
        foreach ($players as $player) {
            // Each player joins 1 to 3 random teams
            $teamIds = $teams->random(rand(1, 2))->pluck('id')->toArray();
            $player->teams()->attach($teamIds);
        }
    }
}
