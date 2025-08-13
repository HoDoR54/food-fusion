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
            ['name' => 'Pasta', 'description' => 'Italian pasta - various shapes'],
            ['name' => 'Tomatoes', 'description' => 'Fresh ripe tomatoes'],
            ['name' => 'Onions', 'description' => 'Yellow onions'],
            ['name' => 'Garlic', 'description' => 'Fresh garlic cloves'],
            ['name' => 'Olive Oil', 'description' => 'Extra virgin olive oil'],
            ['name' => 'Basil', 'description' => 'Fresh basil leaves'],
            ['name' => 'Mozzarella Cheese', 'description' => 'Fresh mozzarella cheese'],
            ['name' => 'Salt', 'description' => 'Sea salt'],
            ['name' => 'Black Pepper', 'description' => 'Freshly ground black pepper'],
            ['name' => 'Paprika', 'description' => 'Sweet paprika'],
            ['name' => 'Bell Peppers', 'description' => 'Mixed color bell peppers'],
            ['name' => 'Carrots', 'description' => 'Fresh carrots'],
            ['name' => 'Broccoli', 'description' => 'Fresh broccoli florets'],
            ['name' => 'Mushrooms', 'description' => 'Button mushrooms'],
            ['name' => 'Ginger', 'description' => 'Fresh ginger root'],
            ['name' => 'Soy Sauce', 'description' => 'Light soy sauce'],
            ['name' => 'Rice', 'description' => 'Long grain white rice'],
            ['name' => 'Beef', 'description' => 'Ground beef'],
            ['name' => 'Potatoes', 'description' => 'Russet potatoes'],
            ['name' => 'Milk', 'description' => 'Whole milk'],
            ['name' => 'Cheese', 'description' => 'Cheddar cheese'],
            ['name' => 'Butter', 'description' => 'Unsalted butter'],
            ['name' => 'Spinach', 'description' => 'Baby spinach leaves'],
            ['name' => 'Lemon', 'description' => 'Fresh lemons'],
            ['name' => 'Coconut Milk', 'description' => 'Canned coconut milk'],
            ['name' => 'Cumin', 'description' => 'Ground cumin'],
            ['name' => 'Parsley', 'description' => 'Fresh parsley'],
            ['name' => 'Flour', 'description' => 'All-purpose flour'],
            ['name' => 'Eggs', 'description' => 'Large eggs'],
            ['name' => 'Baking Powder', 'description' => 'Baking powder'],
            ['name' => 'White Sugar', 'description' => 'Granulated white sugar'],
            ['name' => 'Quinoa', 'description' => 'Quinoa grain'],
            ['name' => 'Feta Cheese', 'description' => 'Crumbled feta cheese'],
            ['name' => 'Salmon', 'description' => 'Fresh salmon fillets'],
            ['name' => 'Asparagus', 'description' => 'Fresh asparagus spears'],
            ['name' => 'Chocolate Chips', 'description' => 'Semi-sweet chocolate chips'],
            ['name' => 'Brown Sugar', 'description' => 'Light brown sugar'],
            ['name' => 'Vanilla Extract', 'description' => 'Pure vanilla extract'],
            ['name' => 'Baking Soda', 'description' => 'Baking soda'],
            ['name' => 'Fish', 'description' => 'White fish fillets'],
            ['name' => 'Lime', 'description' => 'Fresh limes'],
            ['name' => 'Cabbage', 'description' => 'Fresh cabbage'],
            ['name' => 'Sour Cream', 'description' => 'Sour cream'],
            ['name' => 'Tortillas', 'description' => 'Corn or flour tortillas'],
            ['name' => 'Cilantro', 'description' => 'Fresh cilantro'],
            ['name' => 'Noodles', 'description' => 'Rice noodles or egg noodles'],
            ['name' => 'Green Onions', 'description' => 'Fresh green onions'],
            ['name' => 'Cucumber', 'description' => 'Fresh cucumber'],
            ['name' => 'Olives', 'description' => 'Kalamata or mixed olives'],
            ['name' => 'Oregano', 'description' => 'Dried oregano'],
            ['name' => 'Bananas', 'description' => 'Ripe bananas'],
            ['name' => 'Lentils', 'description' => 'Dried lentils'],
            ['name' => 'Vegetable Broth', 'description' => 'Vegetable broth'],
            ['name' => 'Romaine Lettuce', 'description' => 'Fresh romaine lettuce'],
            ['name' => 'Parmesan Cheese', 'description' => 'Grated parmesan cheese'],
            ['name' => 'Mayonnaise', 'description' => 'Mayonnaise'],
            ['name' => 'Croutons', 'description' => 'Seasoned croutons'],
            ['name' => 'Apples', 'description' => 'Fresh apples'],
            ['name' => 'Cinnamon', 'description' => 'Ground cinnamon'],
            ['name' => 'Shrimp', 'description' => 'Fresh or frozen shrimp'],
            ['name' => 'White Wine', 'description' => 'Dry white wine'],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}
