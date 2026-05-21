<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'buyer@gmail.com'],
            [
                'name' => 'Buyer Test',
                'password' => Hash::make('123456'),
                'role' => 'buyer',
                'points' => 120
            ]
        );

        User::updateOrCreate(
            ['email' => 'user1@gmail.com'],
            [
                'name' => 'Khách hàng 1',
                'password' => Hash::make('123456'),
                'role' => 'buyer',
                'points' => 50
            ]
        );

        User::updateOrCreate(
            ['email' => 'user2@gmail.com'],
            [
                'name' => 'Khách hàng 2',
                'password' => Hash::make('123456'),
                'role' => 'buyer',
                'points' => 75
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Test',
                'password' => Hash::make('123456'),
                'role' => 'manager',
                'points' => 0
            ]
        );

        User::updateOrCreate(
            ['email' => 'ngocmt363@gmail.com'],
            [
                'name' => 'Ngọc MT',
                'password' => Hash::make('10112005'),
                'role' => 'manager',
                'points' => 0
            ]
        );
    }
}