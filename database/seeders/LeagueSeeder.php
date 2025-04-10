<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\League;

class LeagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leagues = [
            ['name' => 'U15'],
            ['name' => 'U17'],
            ['name' => 'U19'],
            ['name' => 'Serie D'],
            ['name' => 'UISP'],
        ];

        foreach ($leagues as $league) {
            League::create($league);
        }
    }
}
