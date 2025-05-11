<?php
namespace Database\Seeders;

use App\Models\GameStat;
use Illuminate\Database\Seeder;

class GameStatSeeder extends Seeder
{
    public function run(): void
    {
        GameStat::factory()->count(50)->create();
    }
}