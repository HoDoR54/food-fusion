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
            ['name' => 'Shrimp', 'description' => 'Fresh or frozen shrimp'],
            ['name' => 'Salmon', 'description' => 'Fresh salmon fillets'],
            ['name' => 'Fish', 'description' => 'White fish fillets'],
            ['name' => 'Asparagus', 'description' => 'Fresh asparagus spears'],
            ['name' => 'Quinoa', 'description' => 'Quinoa grain'],
            ['name' => 'Olives', 'description' => 'Kalamata or mixed olives'],
            ['name' => 'Cucumber', 'description' => 'Fresh cucumber'],
            ['name' => 'Bananas', 'description' => 'Ripe bananas'],
            ['name' => 'Lentils', 'description' => 'Dried lentils'],
            ['name' => 'Apples', 'description' => 'Fresh apples'],
            ['name' => 'White Wine', 'description' => 'Dry white wine'],
            ['name' => 'Chocolate Chips', 'description' => 'Semi-sweet chocolate chips'],
            ['name' => 'Vanilla Extract', 'description' => 'Pure vanilla extract'],
            ['name' => 'Baking Soda', 'description' => 'Baking soda'],
            ['name' => 'Baking Powder', 'description' => 'Baking powder'],
            ['name' => 'Brown Sugar', 'description' => 'Light brown sugar'],
            ['name' => 'White Sugar', 'description' => 'Granulated white sugar'],
            ['name' => 'Cinnamon', 'description' => 'Ground cinnamon'],
            ['name' => 'Oregano', 'description' => 'Dried oregano'],
            ['name' => 'Cilantro', 'description' => 'Fresh cilantro'],
            ['name' => 'Lime', 'description' => 'Fresh limes'],
            ['name' => 'Sour Cream', 'description' => 'Sour cream'],
            ['name' => 'Cabbage', 'description' => 'Fresh cabbage'],
            ['name' => 'Tortillas', 'description' => 'Corn or flour tortillas'],
            ['name' => 'Noodles', 'description' => 'Rice noodles or egg noodles'],
            ['name' => 'Green Onions', 'description' => 'Fresh green onions'],
            ['name' => 'Feta Cheese', 'description' => 'Crumbled feta cheese'],
            ['name' => 'Parmesan Cheese', 'description' => 'Grated parmesan cheese'],
            ['name' => 'Romaine Lettuce', 'description' => 'Fresh romaine lettuce'],
            ['name' => 'Mayonnaise', 'description' => 'Mayonnaise'],
            ['name' => 'Croutons', 'description' => 'Seasoned croutons'],
            ['name' => 'Yeast', 'description' => 'Active dry yeast'],
            ['name' => 'Vegetable Broth', 'description' => 'Vegetable broth'],
            ['name' => 'Chicken Broth', 'description' => 'Chicken broth'],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}
