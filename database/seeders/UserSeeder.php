<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // Admin User
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => '1',
                'phone' => '1234567890',
                'address' => 'Admin Address',
                'created_at' => now(),
                'updated_at' => now(),

            ],

            // Instructor
            [
                'name' => 'Instructor',
                'email' => 'instructor@gmail.com',
                'username' => 'instructor',
                'password' => Hash::make('password'),
                'role' => 'instructor',
                'status' => '1',
                'phone' => '1234567890',
                'address' => 'Instructor Address',
                'created_at' => now(),
                'updated_at' => now(),

            ],

            //  User
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'username' => 'user',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => '1',
                'phone' => '0987654321',
                'address' => 'User Address',
                'created_at' => now(),
                'updated_at' => now(),

            ],
        ]);
    }
}
