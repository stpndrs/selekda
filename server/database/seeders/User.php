<?php

namespace Database\Seeders;

use App\Models\User as ModelsUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class User extends Seeder
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
                'profile_picture' => '',
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
                'profile_picture' => '',
                'level' => '2',
            ],
        ];

        foreach ($users as $value) {
            ModelsUser::create($value);
        }
    }
}
