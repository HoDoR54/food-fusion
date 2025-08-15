<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user first
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);

        // Create additional sample users
        User::factory(5)->create();

        // Seed the application data
        $this->call([
            IngredientsSeeder::class,
            TagsSeeder::class,
            RecipesSeeder::class,
        ]);
    }
}
