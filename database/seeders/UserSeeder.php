<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Player;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'john',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'admin' => 1,
            'player_id' => Player::inRandomOrder()->first()?->id
        ]);


        DB::table('users')->insert([
            'name' => 'Mario Rossi',
            'email' => 'dev@example.com',
            'password' => Hash::make('test'),
            'admin' => 0,
            'player_id' => Player::inRandomOrder()->first()?->id
        ]);


        DB::table('users')->insert([
            'name' => 'Francesco Bianchi',
            'email' => 'dev2@example.com',
            'password' => Hash::make('test'),
            'admin' => 0
        ]);
    }
}
