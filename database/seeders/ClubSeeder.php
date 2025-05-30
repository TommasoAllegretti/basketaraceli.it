<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Team;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 clubs
        Club::factory(5)->create()->each(function ($club) {
            // Assign random existing teams to this club
            $randomTeams = Team::inRandomOrder()->limit(rand(1, 3))->get();
            foreach ($randomTeams as $team) {
                $team->update(['club_id' => $club->id]);
            }
        });
    }
} 