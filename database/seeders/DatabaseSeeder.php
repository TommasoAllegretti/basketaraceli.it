<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LeagueSeeder::class);
        $this->call(ClubSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(PlayerSeeder::class);
        $this->call(PlayerTeamSeeder::class);
        $this->call(GameSeeder::class);
        $this->call(GameStatSeeder::class);
        $this->call(StatSeeder::class);
        $this->call(UserSeeder::class);
    }
}
