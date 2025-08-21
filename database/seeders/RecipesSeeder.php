<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\User;
use App\Models\Ingredient;
use App\Models\Tag;
use App\Enums\DifficultyLevel;
use App\Enums\RecipeStepType;
use App\DTO\Requests\RecipeStep;
use Illuminate\Database\Seeder;

class RecipesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get various users to create recipes
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        // Create recipe data with different authors
        $recipes = [
            [
                'name' => 'Classic Chicken Pasta',
                'description' => 'A delicious and creamy chicken pasta dish perfect for dinner.',
                'difficulty' => DifficultyLevel::Medium,
                'servings' => 4,
                'image_url' => 'https://example.com/chicken-pasta.jpg',
                'steps' => [
                    new RecipeStep(1, 'Cook pasta according to package instructions until al dente.', RecipeStepType::COOKING, 10),
                    new RecipeStep(2, 'Season chicken breast with salt, pepper, and paprika.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(3, 'Heat olive oil in a large pan and cook chicken until golden brown.', RecipeStepType::COOKING, 15),
                    new RecipeStep(4, 'Add garlic and onions to the pan and sauté until fragrant.', RecipeStepType::COOKING, 5),
                    new RecipeStep(5, 'Add tomatoes and cook until softened.', RecipeStepType::COOKING, 8),
                    new RecipeStep(6, 'Combine cooked pasta with chicken and vegetables.', RecipeStepType::PLATING, 3),
                    new RecipeStep(7, 'Top with fresh basil and mozzarella cheese.', RecipeStepType::PLATING, 2),
                ],
                'ingredients' => [
                    ['name' => 'Chicken Breast', 'amount' => '1', 'unit' => 'lb'],
                    ['name' => 'Pasta', 'amount' => '1', 'unit' => 'lb'],
                    ['name' => 'Tomatoes', 'amount' => '2', 'unit' => 'large'],
                    ['name' => 'Yellow Onion', 'amount' => '1', 'unit' => 'medium'],
                    ['name' => 'Garlic', 'amount' => '3', 'unit' => 'cloves'],
                    ['name' => 'Extra Virgin Olive Oil', 'amount' => '2', 'unit' => 'tbsp'],
                    ['name' => 'Fresh Basil', 'amount' => '1/4', 'unit' => 'cup'],
                    ['name' => 'Fresh Mozzarella', 'amount' => '8', 'unit' => 'oz'],
                    ['name' => 'Sea Salt', 'amount' => '1', 'unit' => 'tsp'],
                    ['name' => 'Black Pepper', 'amount' => '1/2', 'unit' => 'tsp'],
                    ['name' => 'Paprika', 'amount' => '1', 'unit' => 'tsp'],
                ],
                'tags' => ['Italian', 'Dinner', 'Family Dinner'],
                'author_index' => 0,
            ],
            [
                'name' => 'Vegetarian Stir Fry',
                'description' => 'A healthy and colorful stir fry packed with vegetables and served over rice.',
                'difficulty' => DifficultyLevel::Easy,
                'servings' => 4,
                'image_url' => 'https://example.com/vegetarian-stir-fry.jpg',
                'steps' => [
                    new RecipeStep(1, 'Cook rice according to package instructions.', RecipeStepType::COOKING, 15),
                    new RecipeStep(2, 'Chop all vegetables into bite-sized pieces.', RecipeStepType::PREPARATION, 10),
                    new RecipeStep(3, 'Heat oil in a large wok or skillet over high heat.', RecipeStepType::COOKING, 2),
                    new RecipeStep(4, 'Add garlic and ginger, stir fry for 30 seconds.', RecipeStepType::COOKING, 1),
                    new RecipeStep(5, 'Add harder vegetables first (carrots, bell peppers), stir fry for 3-4 minutes.', RecipeStepType::COOKING, 4),
                    new RecipeStep(6, 'Add softer vegetables (broccoli, mushrooms) and cook for 2-3 minutes.', RecipeStepType::COOKING, 3),
                    new RecipeStep(7, 'Add soy sauce and seasonings, toss everything together.', RecipeStepType::COOKING, 2),
                    new RecipeStep(8, 'Serve immediately over steamed rice.', RecipeStepType::PLATING, 2),
                ],
                'ingredients' => [
                    ['name' => 'Bell Peppers', 'amount' => '2', 'unit' => 'large'],
                    ['name' => 'Carrots', 'amount' => '3', 'unit' => 'medium'],
                    ['name' => 'Broccoli', 'amount' => '1', 'unit' => 'head'],
                    ['name' => 'Button Mushrooms', 'amount' => '8', 'unit' => 'oz'],
                    ['name' => 'Garlic', 'amount' => '3', 'unit' => 'cloves'],
                    ['name' => 'Fresh Ginger', 'amount' => '2', 'unit' => 'inches'],
                    ['name' => 'Extra Virgin Olive Oil', 'amount' => '2', 'unit' => 'tbsp'],
                    ['name' => 'Soy Sauce', 'amount' => '3', 'unit' => 'tbsp'],
                    ['name' => 'White Rice', 'amount' => '2', 'unit' => 'cups'],
                    ['name' => 'Sea Salt', 'amount' => '1', 'unit' => 'tsp'],
                    ['name' => 'Black Pepper', 'amount' => '1/2', 'unit' => 'tsp'],
                ],
                'tags' => ['Vegetarian', 'Asian', 'Healthy', 'Quick'],
                'author_index' => 1,
            ],
            [
                'name' => 'Honey Glazed Salmon',
                'description' => 'Tender salmon fillets with a sweet honey glaze, served with asparagus and rice.',
                'difficulty' => DifficultyLevel::Medium,
                'servings' => 4,
                'image_url' => 'https://example.com/honey-salmon.jpg',
                'steps' => [
                    new RecipeStep(1, 'Preheat oven to 400°F (200°C).', RecipeStepType::PREPARATION, 2),
                    new RecipeStep(2, 'Mix honey, soy sauce, and garlic in a small bowl.', RecipeStepType::PREPARATION, 3),
                    new RecipeStep(3, 'Season salmon fillets with salt and pepper.', RecipeStepType::PREPARATION, 2),
                    new RecipeStep(4, 'Heat olive oil in an oven-safe skillet.', RecipeStepType::COOKING, 2),
                    new RecipeStep(5, 'Sear salmon skin-side up for 3-4 minutes.', RecipeStepType::COOKING, 4),
                    new RecipeStep(6, 'Flip salmon and brush with honey glaze.', RecipeStepType::COOKING, 1),
                    new RecipeStep(7, 'Transfer to oven and bake for 6-8 minutes.', RecipeStepType::COOKING, 8),
                    new RecipeStep(8, 'Steam asparagus and serve with rice.', RecipeStepType::PLATING, 3),
                ],
                'ingredients' => [
                    ['name' => 'Salmon Fillet', 'amount' => '4', 'unit' => 'pieces'],
                    ['name' => 'Honey', 'amount' => '3', 'unit' => 'tbsp'],
                    ['name' => 'Garlic', 'amount' => '3', 'unit' => 'cloves'],
                    ['name' => 'Soy Sauce', 'amount' => '3', 'unit' => 'tbsp'],
                    ['name' => 'Extra Virgin Olive Oil', 'amount' => '2', 'unit' => 'tbsp'],
                    ['name' => 'Asparagus', 'amount' => '1', 'unit' => 'lb'],
                    ['name' => 'White Rice', 'amount' => '2', 'unit' => 'cups'],
                    ['name' => 'Sea Salt', 'amount' => '1', 'unit' => 'tsp'],
                    ['name' => 'Black Pepper', 'amount' => '1/2', 'unit' => 'tsp'],
                ],
                'tags' => ['Seafood', 'Healthy', 'Dinner', 'Gluten-Free'],
                'author_index' => 2,
            ],
        ];

        foreach ($recipes as $index => $recipeData) {
            // Get user for this recipe (cycle through users)
            $user = $users->get($recipeData['author_index'] % $users->count());
            
            // Create the recipe
            $recipe = Recipe::firstOrCreate(
                ['name' => $recipeData['name']],
                [
                    'posted_by' => $user->id,
                    'name' => $recipeData['name'],
                    'description' => $recipeData['description'],
                    'difficulty' => $recipeData['difficulty'],
                    'servings' => $recipeData['servings'],
                    'image_url' => $recipeData['image_url'],
                    'steps' => $recipeData['steps'],
                ]
            );

            // Attach ingredients if recipe was just created
            if ($recipe->wasRecentlyCreated) {
                foreach ($recipeData['ingredients'] as $ingredientData) {
                    $ingredient = Ingredient::where('name', $ingredientData['name'])->first();
                    if ($ingredient) {
                        $recipe->ingredients()->attach($ingredient->id, [
                            'amount' => $ingredientData['amount'],
                            'unit' => $ingredientData['unit'],
                        ]);
                    }
                }

                // Attach tags
                foreach ($recipeData['tags'] as $tagName) {
                    $tag = Tag::where('name', $tagName)->first();
                    if ($tag) {
                        $recipe->tags()->attach($tag->id);
                    }
                }
            }
        }

        $this->command->info('Recipes seeded successfully with different authors!');
    }
}
