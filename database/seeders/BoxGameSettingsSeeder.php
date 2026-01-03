<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoxGameSettingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('box_game_settings')->truncate();

        DB::table('box_game_settings')->insert([
            [
                'rank' => 1,
                'probability' => 5,   // 1等 5%
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rank' => 2,
                'probability' => 10,  // 2等 10%
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rank' => 3,
                'probability' => 20,  // 3等 20%
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rank' => 4,
                'probability' => 30,  // 4等 30%
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rank' => 5,
                'probability' => 35,  // 5等 35%
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
