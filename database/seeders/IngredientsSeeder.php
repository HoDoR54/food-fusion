<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            ['name' => 'Chicken Breast', 'description' => 'Boneless, skinless chicken breast'],
            ['name' => 'Tomatoes', 'description' => 'Fresh ripe tomatoes'],
            ['name' => 'Onions', 'description' => 'Yellow onions'],
            ['name' => 'Garlic', 'description' => 'Fresh garlic cloves'],
            ['name' => 'Olive Oil', 'description' => 'Extra virgin olive oil'],
            ['name' => 'Basil', 'description' => 'Fresh basil leaves'],
            ['name' => 'Mozzarella Cheese', 'description' => 'Fresh mozzarella cheese'],
            ['name' => 'Pasta', 'description' => 'Italian pasta - various shapes'],
            ['name' => 'Rice', 'description' => 'Long grain white rice'],
            ['name' => 'Beef', 'description' => 'Ground beef'],
            ['name' => 'Bell Peppers', 'description' => 'Mixed color bell peppers'],
            ['name' => 'Mushrooms', 'description' => 'Button mushrooms'],
            ['name' => 'Eggs', 'description' => 'Large eggs'],
            ['name' => 'Flour', 'description' => 'All-purpose flour'],
            ['name' => 'Butter', 'description' => 'Unsalted butter'],
            ['name' => 'Milk', 'description' => 'Whole milk'],
            ['name' => 'Salt', 'description' => 'Sea salt'],
            ['name' => 'Black Pepper', 'description' => 'Freshly ground black pepper'],
            ['name' => 'Paprika', 'description' => 'Sweet paprika'],
            ['name' => 'Cumin', 'description' => 'Ground cumin'],
            ['name' => 'Ginger', 'description' => 'Fresh ginger root'],
            ['name' => 'Lemon', 'description' => 'Fresh lemons'],
            ['name' => 'Parsley', 'description' => 'Fresh parsley'],
            ['name' => 'Carrots', 'description' => 'Fresh carrots'],
            ['name' => 'Potatoes', 'description' => 'Russet potatoes'],
            ['name' => 'Broccoli', 'description' => 'Fresh broccoli florets'],
            ['name' => 'Spinach', 'description' => 'Baby spinach leaves'],
            ['name' => 'Cheese', 'description' => 'Cheddar cheese'],
            ['name' => 'Coconut Milk', 'description' => 'Canned coconut milk'],
            ['name' => 'Soy Sauce', 'description' => 'Light soy sauce'],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}
