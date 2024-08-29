<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Banner 1',
                'image' => 'storage/banners/images (6).webp',
                'description' => 'This is the banner 1',
                'status' => true
            ],
            [
                'title' => 'Banner 2',
                'image' => 'storage/banners/images (6).jpg',
                'description' => 'This is the banner 2',
                'status' => true
            ],
            [
                'title' => 'Banner 3',
                'image' => 'storage/banners/images (7).jpg',
                'description' => 'This is the banner 3',
                'status' => true
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }
    }
}
