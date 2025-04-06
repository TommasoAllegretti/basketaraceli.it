<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('test'),
            'admin' => 1,
        ]);


        DB::table('users')->insert([
            'name' => 'Mario Rossi',
            'email' => 'dev@example.com',
            'password' => Hash::make('test'),
            'admin' => 0,
        ]);
    }
}
