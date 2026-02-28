<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Store;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a single user with custom data
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),  // Use a hashed password
        ]);

        // Create a test store for store login
        Store::create([
            'store_name' => 'Test Store',
            'email' => 'wafaastore@test.com',
            'password' => bcrypt('123456'),
            'phone' => '1234567890',
            'address' => '123 Test Street',
            'status' => 'pending',
        ]);
    }
}
