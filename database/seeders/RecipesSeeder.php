<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\User;
use App\Models\Ingredient;
use App\Models\Tag;
use App\Enums\DifficultyLevel;
use App\DTO\Requests\RecipeStep;
use Illuminate\Database\Seeder;

class RecipesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the test user
        $user = User::where('email', 'test@example.com')->first();
        
        if (!$user) {
            $user = User::factory()->create([
                'first_name' => 'Test',
                'last_name' => 'User',
                'email' => 'test@example.com',
            ]);
        }

        // Create recipe data
        $recipes = [
            [
                'name' => 'Classic Chicken Pasta',
                'description' => 'A delicious and creamy chicken pasta dish perfect for dinner.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/chicken-pasta.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Cook pasta according to package instructions until al dente.', 10),
                    new RecipeStep(2, 'Season chicken breast with salt, pepper, and paprika.', 5),
                    new RecipeStep(3, 'Heat olive oil in a large pan and cook chicken until golden brown.', 15),
                    new RecipeStep(4, 'Add garlic and onions to the pan and sauté until fragrant.', 5),
                    new RecipeStep(5, 'Add tomatoes and cook until softened.', 8),
                    new RecipeStep(6, 'Combine cooked pasta with chicken and vegetables.', 3),
                    new RecipeStep(7, 'Top with fresh basil and mozzarella cheese.', 2),
                ],
                'ingredients' => ['Chicken Breast', 'Pasta', 'Tomatoes', 'Onions', 'Garlic', 'Olive Oil', 'Basil', 'Mozzarella Cheese', 'Salt', 'Black Pepper', 'Paprika'],
                'tags' => ['Italian', 'Dinner', 'Sautéed', 'Family Dinner'],
            ],
            [
                'name' => 'Vegetarian Stir Fry',
                'description' => 'A colorful and healthy vegetarian stir fry with fresh vegetables.',
                'difficulty' => DifficultyLevel::Easy,
                'image_urls' => ['https://example.com/veggie-stir-fry.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Prepare all vegetables by washing and cutting into bite-sized pieces.', 10),
                    new RecipeStep(2, 'Heat oil in a wok or large pan over high heat.', 2),
                    new RecipeStep(3, 'Add garlic and ginger, stir fry for 30 seconds.', 1),
                    new RecipeStep(4, 'Add bell peppers and carrots, stir fry for 3 minutes.', 3),
                    new RecipeStep(5, 'Add broccoli and mushrooms, continue stir frying.', 4),
                    new RecipeStep(6, 'Add soy sauce and season with salt and pepper.', 2),
                    new RecipeStep(7, 'Serve hot over rice.', 1),
                ],
                'ingredients' => ['Bell Peppers', 'Carrots', 'Broccoli', 'Mushrooms', 'Garlic', 'Ginger', 'Olive Oil', 'Soy Sauce', 'Rice', 'Salt', 'Black Pepper'],
                'tags' => ['Vegetarian', 'Asian', 'Healthy', 'Quick & Easy', 'Dinner', 'Sautéed'],
            ],
            [
                'name' => 'Beef and Potato Casserole',
                'description' => 'A hearty and comforting casserole perfect for cold evenings.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/beef-casserole.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Preheat oven to 375°F (190°C).', 5),
                    new RecipeStep(2, 'Brown ground beef in a large oven-safe pan.', 10),
                    new RecipeStep(3, 'Add onions and garlic, cook until softened.', 5),
                    new RecipeStep(4, 'Layer sliced potatoes over the beef mixture.', 8),
                    new RecipeStep(5, 'Pour milk over the potatoes and season well.', 3),
                    new RecipeStep(6, 'Top with cheese and cover with foil.', 3),
                    new RecipeStep(7, 'Bake for 45 minutes, then remove foil and bake 15 more minutes.', 60),
                ],
                'ingredients' => ['Beef', 'Potatoes', 'Onions', 'Garlic', 'Milk', 'Cheese', 'Salt', 'Black Pepper', 'Butter'],
                'tags' => ['American', 'Dinner', 'Baked', 'Comfort Food', 'Family Dinner'],
            ],
            [
                'name' => 'Fresh Garden Salad',
                'description' => 'A light and refreshing salad with seasonal vegetables.',
                'difficulty' => DifficultyLevel::Easy,
                'image_urls' => ['https://example.com/garden-salad.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Wash and dry all vegetables thoroughly.', 5),
                    new RecipeStep(2, 'Chop tomatoes, carrots, and bell peppers.', 8),
                    new RecipeStep(3, 'Arrange spinach leaves on serving plates.', 2),
                    new RecipeStep(4, 'Top with chopped vegetables.', 3),
                    new RecipeStep(5, 'Drizzle with olive oil and lemon juice.', 2),
                    new RecipeStep(6, 'Season with salt and pepper to taste.', 1),
                ],
                'ingredients' => ['Spinach', 'Tomatoes', 'Carrots', 'Bell Peppers', 'Olive Oil', 'Lemon', 'Salt', 'Black Pepper'],
                'tags' => ['Vegetarian', 'Vegan', 'Healthy', 'No-Cook', 'Lunch', 'Summer'],
            ],
            [
                'name' => 'Coconut Curry Chicken',
                'description' => 'A flavorful Thai-inspired coconut curry with tender chicken.',
                'difficulty' => DifficultyLevel::Hard,
                'image_urls' => ['https://example.com/coconut-curry.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Cut chicken into bite-sized pieces and season.', 8),
                    new RecipeStep(2, 'Heat oil in a large pot and brown chicken pieces.', 10),
                    new RecipeStep(3, 'Add onions, garlic, and ginger, cook until fragrant.', 5),
                    new RecipeStep(4, 'Add curry spices and cook for 1 minute.', 1),
                    new RecipeStep(5, 'Pour in coconut milk and bring to a simmer.', 5),
                    new RecipeStep(6, 'Add vegetables and simmer for 20 minutes.', 20),
                    new RecipeStep(7, 'Adjust seasoning and garnish with fresh herbs.', 3),
                    new RecipeStep(8, 'Serve over rice.', 2),
                ],
                'ingredients' => ['Chicken Breast', 'Coconut Milk', 'Onions', 'Garlic', 'Ginger', 'Bell Peppers', 'Carrots', 'Cumin', 'Rice', 'Olive Oil', 'Salt', 'Parsley'],
                'tags' => ['Thai', 'Asian', 'Dinner', 'Sautéed', 'Date Night'],
            ],
        ];

        foreach ($recipes as $recipeData) {
            // Create the recipe
            $recipe = Recipe::create([
                'posted_by' => $user->id,
                'name' => $recipeData['name'],
                'description' => $recipeData['description'],
                'difficulty' => $recipeData['difficulty'],
                'image_urls' => $recipeData['image_urls'],
                'steps' => $recipeData['steps'],
            ]);

            // Attach ingredients
            $ingredientIds = [];
            foreach ($recipeData['ingredients'] as $ingredientName) {
                $ingredient = Ingredient::where('name', $ingredientName)->first();
                if ($ingredient) {
                    $ingredientIds[] = $ingredient->id;
                }
            }
            $recipe->ingredients()->attach($ingredientIds);

            // Attach tags
            $tagIds = [];
            foreach ($recipeData['tags'] as $tagName) {
                $tag = Tag::where('name', $tagName)->first();
                if ($tag) {
                    $tagIds[] = $tag->id;
                }
            }
            $recipe->tags()->attach($tagIds);
        }
    }
}
