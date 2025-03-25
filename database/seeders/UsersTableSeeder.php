<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Usuario Uno',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Usuario Dos',
            'email' => 'user2@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Usuario Tres',
            'email' => 'user3@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Usuario Cuatro',
            'email' => 'user4@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Usuario Cinco',
            'email' => 'user5@example.com',
            'password' => Hash::make('password'),
        ]);

    }
}
