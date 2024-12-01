<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
           ]);
        User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => bcrypt('password'),
            'role' => 'student',
           ]);
    }
}
