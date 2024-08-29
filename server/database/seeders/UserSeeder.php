<?php

namespace Database\Seeders;

use App\Models\User as ModelsUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make('admin'),
                'date_of_birth' => date('Y-m-d'),
                'phone_number' => '08123456789',
                'date' => date('Y-m-d'),
                'profile_picture' => 'storage/profile_pictures/images (13).jpg',
                'level' => '1',
            ],
            [
                'name' => 'user1',
                'username' => 'user1',
                'email' => 'user1@mail.com',
                'password' => Hash::make('user1'),
                'date_of_birth' => date('Y-m-d'),
                'phone_number' => '08123456789',
                'date' => date('Y-m-d'),
                'profile_picture' => 'storage/profile_pictures/images (13).jpg',
                'level' => '2',
            ],
            [
                'name' => 'user2',
                'username' => 'user2',
                'email' => 'user2@mail.com',
                'password' => Hash::make('user2'),
                'date_of_birth' => date('Y-m-d'),
                'phone_number' => '08223456789',
                'date' => date('Y-m-d'),
                'profile_picture' => 'storage/profile_pictures/images (13).jpg',
                'level' => '2',
            ],
            [
                'name' => 'user3',
                'username' => 'user3',
                'email' => 'user3@mail.com',
                'password' => Hash::make('user3'),
                'date_of_birth' => date('Y-m-d'),
                'phone_number' => '08323456789',
                'date' => date('Y-m-d'),
                'profile_picture' => 'storage/profile_pictures/images (13).jpg',
                'level' => '2',
            ],
            [
                'name' => 'user4',
                'username' => 'user4',
                'email' => 'user4@mail.com',
                'password' => Hash::make('user4'),
                'date_of_birth' => date('Y-m-d'),
                'phone_number' => '08423456789',
                'date' => date('Y-m-d'),
                'profile_picture' => 'storage/profile_pictures/images (13).jpg',
                'level' => '2',
            ],
            [
                'name' => 'user5',
                'username' => 'user5',
                'email' => 'user5@mail.com',
                'password' => Hash::make('user5'),
                'date_of_birth' => date('Y-m-d'),
                'phone_number' => '08523456789',
                'date' => date('Y-m-d'),
                'profile_picture' => 'storage/profile_pictures/images (13).jpg',
                'level' => '2',
            ],
        ];

        foreach ($users as $value) {
            ModelsUser::create($value);
        }
    }
}
