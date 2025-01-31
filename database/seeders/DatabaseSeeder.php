<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         //\App\Models\User::factory(100)->create();

         \App\Models\User::factory()->create([
             'name' => 'Test User',
             'role' => 'student',
             'email' => 'users@example.com',
             'password' => Hash::make('123456'),
         ]);

         \App\Models\User::factory()->create([
            'name' => 'Test Admin',
            'role' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
