<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = [
            [
                'image' => 'storage/blog/images (1).jpg',
                'title' => 'Blog 1',
                'description' => 'Description of blog 1',
                'author_id' => 2,
                'total_view' => 100,
            ],
            [
                'image' => 'storage/blog/images (2).jpg',
                'title' => 'Blog 2',
                'description' => 'Description of blog 2',
                'author_id' => 2,
                'total_view' => 100,
            ],
            [
                'image' => 'storage/blog/images (3).jpg',
                'title' => 'Blog 3',
                'description' => 'Description of blog 3',
                'author_id' => 2,
                'total_view' => 100,
            ],
            [
                'image' => 'storage/blog/images (4).jpg',
                'title' => 'Blog 4',
                'description' => 'Description of blog 4',
                'author_id' => 2,
                'total_view' => 100,
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }
    }
}
