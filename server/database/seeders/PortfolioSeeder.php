<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $portfolios = [
            [
                'title' => 'Portfolio 1',
                'image' => 'storage/portfolios/image (7).webp',
                'description' => 'This portfolio was created by user1',
                'author_id' => 2
            ],
            [
                'title' => 'Portfolio 2',
                'image' => 'storage/portfolios/image (17).jpg',
                'description' => 'This portfolio was created by user2',
                'author_id' => 3
            ],
        ];

        foreach ($portfolios as $portfolio) {
            Portfolio::create($portfolio);
        }
    }
}
