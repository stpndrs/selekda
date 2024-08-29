<?php

namespace Database\Seeders;

use App\Models\Leaderboard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaderboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leaderboards = [
            [
                'score' => 10,
                'remaining_time' => 10,
                'user_id' => 2
            ],
            [
                'score' => 15,
                'remaining_time' => 10,
                'user_id' => 3
            ],
            [
                'score' => 20,
                'remaining_time' => 10,
                'user_id' => 2
            ],
            [
                'score' => 18,
                'remaining_time' => 10,
                'user_id' => 2
            ],
        ];

        foreach ($leaderboards as $leaderboard) {
            Leaderboard::create($leaderboard);
        }
    }
}
