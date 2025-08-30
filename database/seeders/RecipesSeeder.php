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

        $defaultImageUrl = 'https://res.cloudinary.com/dybgsw0ej/image/upload/v1756524637/example-recipe_oio2rn.jpg';

        // Create recipe data with different authors
        $recipes = [
            [
                'name' => 'Classic Chicken Pasta',
                'description' => 'A delicious and creamy chicken pasta dish perfect for dinner.',
                'difficulty' => DifficultyLevel::Medium,
                'servings' => 4,
                'image_url' => $defaultImageUrl,
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
                'image_url' => $defaultImageUrl,
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
                'image_url' => $defaultImageUrl,
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
            [
                'name' => 'Beef Tacos',
                'description' => 'Crispy tacos filled with seasoned beef, fresh veggies, and cheese.',
                'difficulty' => DifficultyLevel::Easy,
                'servings' => 4,
                'image_url' => $defaultImageUrl,
                'steps' => [
                    new RecipeStep(1, 'Cook beef with taco seasoning in a skillet.', RecipeStepType::COOKING, 10),
                    new RecipeStep(2, 'Warm taco shells in the oven.', RecipeStepType::COOKING, 5),
                    new RecipeStep(3, 'Assemble tacos with beef, lettuce, tomato, cheese, and sour cream.', RecipeStepType::PLATING, 5),
                ],
                'ingredients' => [
                    ['name' => 'Ground Beef', 'amount' => '1', 'unit' => 'lb'],
                    ['name' => 'Taco Shells', 'amount' => '8', 'unit' => 'pieces'],
                    ['name' => 'Lettuce', 'amount' => '1', 'unit' => 'cup'],
                    ['name' => 'Tomato', 'amount' => '1', 'unit' => 'large'],
                    ['name' => 'Cheddar Cheese', 'amount' => '1', 'unit' => 'cup'],
                    ['name' => 'Sour Cream', 'amount' => '1/2', 'unit' => 'cup'],
                    ['name' => 'Taco Seasoning', 'amount' => '2', 'unit' => 'tbsp'],
                ],
                'tags' => ['Mexican', 'Dinner', 'Quick'],
                'author_index' => 0,
            ],
            [
                'name' => 'Margherita Pizza',
                'description' => 'Classic Italian pizza with tomato, mozzarella, and fresh basil.',
                'difficulty' => DifficultyLevel::Medium,
                'servings' => 2,
                'image_url' => $defaultImageUrl,
                'steps' => [
                    new RecipeStep(1, 'Preheat oven to 475°F (245°C).', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(2, 'Roll out pizza dough and spread tomato sauce.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(3, 'Add mozzarella and fresh basil.', RecipeStepType::PLATING, 2),
                    new RecipeStep(4, 'Bake for 12-15 minutes until crust is golden.', RecipeStepType::COOKING, 15),
                ],
                'ingredients' => [
                    ['name' => 'Pizza Dough', 'amount' => '1', 'unit' => 'lb'],
                    ['name' => 'Tomato Sauce', 'amount' => '1/2', 'unit' => 'cup'],
                    ['name' => 'Mozzarella', 'amount' => '8', 'unit' => 'oz'],
                    ['name' => 'Fresh Basil', 'amount' => '1/4', 'unit' => 'cup'],
                    ['name' => 'Olive Oil', 'amount' => '1', 'unit' => 'tbsp'],
                    ['name' => 'Sea Salt', 'amount' => '1/2', 'unit' => 'tsp'],
                ],
                'tags' => ['Italian', 'Vegetarian', 'Dinner'],
                'author_index' => 1,
            ],
            [
                'name' => 'Chocolate Chip Cookies',
                'description' => 'Soft and chewy cookies with melted chocolate chips.',
                'difficulty' => DifficultyLevel::Easy,
                'servings' => 12,
                'image_url' => $defaultImageUrl,
                'steps' => [
                    new RecipeStep(1, 'Preheat oven to 350°F (175°C).', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(2, 'Cream butter and sugar, then add eggs and vanilla.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(3, 'Mix in flour, baking soda, and salt.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(4, 'Fold in chocolate chips.', RecipeStepType::PREPARATION, 2),
                    new RecipeStep(5, 'Scoop dough onto baking sheet and bake for 10-12 minutes.', RecipeStepType::COOKING, 12),
                ],
                'ingredients' => [
                    ['name' => 'Butter', 'amount' => '1', 'unit' => 'cup'],
                    ['name' => 'Granulated Sugar', 'amount' => '3/4', 'unit' => 'cup'],
                    ['name' => 'Brown Sugar', 'amount' => '3/4', 'unit' => 'cup'],
                    ['name' => 'Eggs', 'amount' => '2', 'unit' => 'pieces'],
                    ['name' => 'Vanilla Extract', 'amount' => '1', 'unit' => 'tsp'],
                    ['name' => 'Flour', 'amount' => '2 1/4', 'unit' => 'cups'],
                    ['name' => 'Baking Soda', 'amount' => '1', 'unit' => 'tsp'],
                    ['name' => 'Salt', 'amount' => '1/2', 'unit' => 'tsp'],
                    ['name' => 'Chocolate Chips', 'amount' => '2', 'unit' => 'cups'],
                ],
                'tags' => ['Dessert', 'Snack', 'Baking'],
                'author_index' => 2,
            ],
            [
                'name' => 'Greek Salad',
                'description' => 'Refreshing salad with tomatoes, cucumbers, olives, and feta cheese.',
                'difficulty' => DifficultyLevel::Easy,
                'servings' => 2,
                'image_url' => $defaultImageUrl,
                'steps' => [
                    new RecipeStep(1, 'Chop vegetables and place in a bowl.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(2, 'Add olives and feta cheese.', RecipeStepType::PREPARATION, 2),
                    new RecipeStep(3, 'Drizzle with olive oil and lemon juice, toss well.', RecipeStepType::PLATING, 2),
                ],
                'ingredients' => [
                    ['name' => 'Tomato', 'amount' => '2', 'unit' => 'medium'],
                    ['name' => 'Cucumber', 'amount' => '1', 'unit' => 'large'],
                    ['name' => 'Red Onion', 'amount' => '1/2', 'unit' => 'medium'],
                    ['name' => 'Feta Cheese', 'amount' => '1/2', 'unit' => 'cup'],
                    ['name' => 'Kalamata Olives', 'amount' => '1/4', 'unit' => 'cup'],
                    ['name' => 'Olive Oil', 'amount' => '2', 'unit' => 'tbsp'],
                    ['name' => 'Lemon Juice', 'amount' => '1', 'unit' => 'tbsp'],
                    ['name' => 'Sea Salt', 'amount' => '1/2', 'unit' => 'tsp'],
                    ['name' => 'Black Pepper', 'amount' => '1/4', 'unit' => 'tsp'],
                ],
                'tags' => ['Salad', 'Vegetarian', 'Healthy'],
                'author_index' => 0,
            ],
            [
                'name' => 'Spaghetti Carbonara',
                'description' => 'Creamy pasta with eggs, cheese, pancetta, and black pepper.',
                'difficulty' => DifficultyLevel::Medium,
                'servings' => 4,
                'image_url' => $defaultImageUrl,
                'steps' => [
                    new RecipeStep(1, 'Cook spaghetti until al dente.', RecipeStepType::COOKING, 10),
                    new RecipeStep(2, 'Cook pancetta until crispy.', RecipeStepType::COOKING, 5),
                    new RecipeStep(3, 'Mix eggs and Parmesan cheese in a bowl.', RecipeStepType::PREPARATION, 3),
                    new RecipeStep(4, 'Combine pasta with pancetta and egg mixture quickly.', RecipeStepType::COOKING, 3),
                    new RecipeStep(5, 'Season with black pepper and serve.', RecipeStepType::PLATING, 2),
                ],
                'ingredients' => [
                    ['name' => 'Spaghetti', 'amount' => '1', 'unit' => 'lb'],
                    ['name' => 'Pancetta', 'amount' => '6', 'unit' => 'oz'],
                    ['name' => 'Eggs', 'amount' => '3', 'unit' => 'pieces'],
                    ['name' => 'Parmesan Cheese', 'amount' => '1', 'unit' => 'cup'],
                    ['name' => 'Black Pepper', 'amount' => '1', 'unit' => 'tsp'],
                    ['name' => 'Sea Salt', 'amount' => '1/2', 'unit' => 'tsp'],
                ],
                'tags' => ['Italian', 'Dinner', 'Pasta'],
                'author_index' => 1,
            ],
            [
                'name' => 'Chicken Curry',
                'description' => 'Spicy and flavorful chicken curry served with steamed rice.',
                'difficulty' => DifficultyLevel::Medium,
                'servings' => 4,
                'image_url' => $defaultImageUrl,
                'steps' => [
                    new RecipeStep(1, 'Heat oil and sauté onions, garlic, and ginger.', RecipeStepType::COOKING, 5),
                    new RecipeStep(2, 'Add chicken pieces and cook until lightly browned.', RecipeStepType::COOKING, 8),
                    new RecipeStep(3, 'Add curry powder, tomatoes, and coconut milk.', RecipeStepType::COOKING, 5),
                    new RecipeStep(4, 'Simmer until chicken is fully cooked.', RecipeStepType::COOKING, 15),
                    new RecipeStep(5, 'Serve hot with steamed rice.', RecipeStepType::PLATING, 2),
                ],
                'ingredients' => [
                    ['name' => 'Chicken', 'amount' => '1', 'unit' => 'lb'],
                    ['name' => 'Onion', 'amount' => '1', 'unit' => 'medium'],
                    ['name' => 'Garlic', 'amount' => '3', 'unit' => 'cloves'],
                    ['name' => 'Ginger', 'amount' => '2', 'unit' => 'inches'],
                    ['name' => 'Curry Powder', 'amount' => '2', 'unit' => 'tbsp'],
                    ['name' => 'Tomatoes', 'amount' => '2', 'unit' => 'large'],
                    ['name' => 'Coconut Milk', 'amount' => '1', 'unit' => 'cup'],
                    ['name' => 'Oil', 'amount' => '2', 'unit' => 'tbsp'],
                    ['name' => 'Sea Salt', 'amount' => '1', 'unit' => 'tsp'],
                ],
                'tags' => ['Asian', 'Dinner', 'Spicy'],
                'author_index' => 2,
            ],
            [
                'name' => 'Minestrone Soup',
                'description' => 'Hearty Italian vegetable soup with beans and pasta.',
                'difficulty' => DifficultyLevel::Medium,
                'servings' => 4,
                'image_url' => $defaultImageUrl,
                'steps' => [
                    new RecipeStep(1, 'Heat olive oil and sauté onions, carrots, and celery.', RecipeStepType::COOKING, 5),
                    new RecipeStep(2, 'Add garlic and cook until fragrant.', RecipeStepType::COOKING, 2),
                    new RecipeStep(3, 'Add tomatoes, broth, and beans. Simmer for 15 minutes.', RecipeStepType::COOKING, 15),
                    new RecipeStep(4, 'Add pasta and cook until tender.', RecipeStepType::COOKING, 10),
                    new RecipeStep(5, 'Season with salt, pepper, and herbs. Serve hot.', RecipeStepType::PLATING, 2),
                ],
                'ingredients' => [
                    ['name' => 'Carrots', 'amount' => '2', 'unit' => 'medium'],
                    ['name' => 'Celery', 'amount' => '2', 'unit' => 'stalks'],
                    ['name' => 'Onion', 'amount' => '1', 'unit' => 'medium'],
                    ['name' => 'Garlic', 'amount' => '3', 'unit' => 'cloves'],
                    ['name' => 'Canned Tomatoes', 'amount' => '1', 'unit' => 'cup'],
                    ['name' => 'Vegetable Broth', 'amount' => '4', 'unit' => 'cups'],
                    ['name' => 'Kidney Beans', 'amount' => '1', 'unit' => 'cup'],
                    ['name' => 'Pasta', 'amount' => '1/2', 'unit' => 'cup'],
                    ['name' => 'Olive Oil', 'amount' => '2', 'unit' => 'tbsp'],
                    ['name' => 'Sea Salt', 'amount' => '1', 'unit' => 'tsp'],
                    ['name' => 'Black Pepper', 'amount' => '1/2', 'unit' => 'tsp'],
                ],
                'tags' => ['Soup', 'Vegetarian', 'Italian', 'Healthy'],
                'author_index' => 0,
            ],
            [
                'name' => 'Fluffy Pancakes',
                'description' => 'Light and fluffy pancakes perfect for breakfast.',
                'difficulty' => DifficultyLevel::Easy,
                'servings' => 4,
                'image_url' => $defaultImageUrl,
                'steps' => [
                    new RecipeStep(1, 'Mix flour, sugar, baking powder, and salt.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(2, 'Whisk in milk, eggs, and melted butter until smooth.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(3, 'Heat a skillet and pour batter, cooking until bubbles form.', RecipeStepType::COOKING, 10),
                    new RecipeStep(4, 'Flip pancakes and cook until golden brown.', RecipeStepType::COOKING, 5),
                    new RecipeStep(5, 'Serve with syrup or fruits.', RecipeStepType::PLATING, 2),
                ],
                'ingredients' => [
                    ['name' => 'All-purpose Flour', 'amount' => '1 1/2', 'unit' => 'cups'],
                    ['name' => 'Sugar', 'amount' => '2', 'unit' => 'tbsp'],
                    ['name' => 'Baking Powder', 'amount' => '2', 'unit' => 'tsp'],
                    ['name' => 'Salt', 'amount' => '1/2', 'unit' => 'tsp'],
                    ['name' => 'Milk', 'amount' => '1 1/4', 'unit' => 'cups'],
                    ['name' => 'Egg', 'amount' => '1', 'unit' => 'piece'],
                    ['name' => 'Melted Butter', 'amount' => '3', 'unit' => 'tbsp'],
                ],
                'tags' => ['Breakfast', 'Quick', 'Sweet'],
                'author_index' => 1,
            ],
            [
                'name' => 'Beef Stroganoff',
                'description' => 'Tender strips of beef in a creamy mushroom sauce served over noodles.',
                'difficulty' => DifficultyLevel::Medium,
                'servings' => 4,
                'image_url' => $defaultImageUrl,
                'steps' => [
                    new RecipeStep(1, 'Sauté onions and mushrooms in butter.', RecipeStepType::COOKING, 5),
                    new RecipeStep(2, 'Add beef strips and cook until browned.', RecipeStepType::COOKING, 7),
                    new RecipeStep(3, 'Stir in sour cream and beef broth, simmer for 10 minutes.', RecipeStepType::COOKING, 10),
                    new RecipeStep(4, 'Serve over cooked egg noodles.', RecipeStepType::PLATING, 2),
                ],
                'ingredients' => [
                    ['name' => 'Beef', 'amount' => '1', 'unit' => 'lb'],
                    ['name' => 'Onion', 'amount' => '1', 'unit' => 'medium'],
                    ['name' => 'Mushrooms', 'amount' => '8', 'unit' => 'oz'],
                    ['name' => 'Butter', 'amount' => '2', 'unit' => 'tbsp'],
                    ['name' => 'Sour Cream', 'amount' => '1/2', 'unit' => 'cup'],
                    ['name' => 'Beef Broth', 'amount' => '1', 'unit' => 'cup'],
                    ['name' => 'Egg Noodles', 'amount' => '8', 'unit' => 'oz'],
                    ['name' => 'Sea Salt', 'amount' => '1', 'unit' => 'tsp'],
                    ['name' => 'Black Pepper', 'amount' => '1/2', 'unit' => 'tsp'],
                ],
                'tags' => ['Dinner', 'Beef', 'Comfort Food'],
                'author_index' => 2,
            ],
            [
                'name' => 'Pad Thai',
                'description' => 'Classic Thai stir-fried noodles with shrimp, tofu, and peanuts.',
                'difficulty' => DifficultyLevel::Medium,
                'servings' => 4,
                'image_url' => $defaultImageUrl,
                'steps' => [
                    new RecipeStep(1, 'Soak rice noodles until softened.', RecipeStepType::PREPARATION, 10),
                    new RecipeStep(2, 'Sauté garlic, tofu, and shrimp in oil.', RecipeStepType::COOKING, 5),
                    new RecipeStep(3, 'Add noodles and Pad Thai sauce, stir-fry for 5 minutes.', RecipeStepType::COOKING, 5),
                    new RecipeStep(4, 'Top with crushed peanuts, lime, and green onions.', RecipeStepType::PLATING, 2),
                ],
                'ingredients' => [
                    ['name' => 'Rice Noodles', 'amount' => '8', 'unit' => 'oz'],
                    ['name' => 'Shrimp', 'amount' => '1', 'unit' => 'lb'],
                    ['name' => 'Tofu', 'amount' => '8', 'unit' => 'oz'],
                    ['name' => 'Garlic', 'amount' => '3', 'unit' => 'cloves'],
                    ['name' => 'Pad Thai Sauce', 'amount' => '1/3', 'unit' => 'cup'],
                    ['name' => 'Crushed Peanuts', 'amount' => '1/4', 'unit' => 'cup'],
                    ['name' => 'Green Onions', 'amount' => '2', 'unit' => 'pieces'],
                    ['name' => 'Lime', 'amount' => '1', 'unit' => 'piece'],
                    ['name' => 'Oil', 'amount' => '2', 'unit' => 'tbsp'],
                ],
                'tags' => ['Asian', 'Noodles', 'Seafood'],
                'author_index' => 0,
            ],
            [
                'name' => 'Vegetable Quiche',
                'description' => 'Savory pie filled with eggs, cheese, and assorted vegetables.',
                'difficulty' => DifficultyLevel::Medium,
                'servings' => 6,
                'image_url' => $defaultImageUrl,
                'steps' => [
                    new RecipeStep(1, 'Preheat oven to 375°F (190°C).', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(2, 'Sauté vegetables until tender.', RecipeStepType::COOKING, 5),
                    new RecipeStep(3, 'Whisk eggs and cream, mix with vegetables and cheese.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(4, 'Pour into pie crust and bake for 30-35 minutes.', RecipeStepType::COOKING, 35),
                    new RecipeStep(5, 'Let cool slightly before slicing and serving.', RecipeStepType::PLATING, 5),
                ],
                'ingredients' => [
                    ['name' => 'Pie Crust', 'amount' => '1', 'unit' => 'piece'],
                    ['name' => 'Eggs', 'amount' => '4', 'unit' => 'pieces'],
                    ['name' => 'Heavy Cream', 'amount' => '1', 'unit' => 'cup'],
                    ['name' => 'Spinach', 'amount' => '1', 'unit' => 'cup'],
                    ['name' => 'Bell Pepper', 'amount' => '1', 'unit' => 'medium'],
                    ['name' => 'Onion', 'amount' => '1/2', 'unit' => 'medium'],
                    ['name' => 'Cheddar Cheese', 'amount' => '1', 'unit' => 'cup'],
                    ['name' => 'Sea Salt', 'amount' => '1/2', 'unit' => 'tsp'],
                    ['name' => 'Black Pepper', 'amount' => '1/4', 'unit' => 'tsp'],
                ],
                'tags' => ['Vegetarian', 'Breakfast', 'Brunch', 'Baked'],
                'author_index' => 1,
            ],
            [
                'name' => 'Lemon Drizzle Cake',
                'description' => 'Moist cake with a tangy lemon syrup glaze.',
                'difficulty' => DifficultyLevel::Medium,
                'servings' => 8,
                'image_url' => $defaultImageUrl,
                'steps' => [
                    new RecipeStep(1, 'Preheat oven to 350°F (175°C).', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(2, 'Cream butter and sugar, then add eggs and lemon zest.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(3, 'Fold in flour and baking powder.', RecipeStepType::PREPARATION, 3),
                    new RecipeStep(4, 'Bake in a loaf tin for 40-45 minutes.', RecipeStepType::COOKING, 45),
                    new RecipeStep(5, 'Pour lemon syrup over hot cake and let it soak.', RecipeStepType::PLATING, 5),
                ],
                'ingredients' => [
                    ['name' => 'Butter', 'amount' => '1/2', 'unit' => 'cup'],
                    ['name' => 'Sugar', 'amount' => '1', 'unit' => 'cup'],
                    ['name' => 'Eggs', 'amount' => '2', 'unit' => 'pieces'],
                    ['name' => 'Flour', 'amount' => '1 1/2', 'unit' => 'cups'],
                    ['name' => 'Baking Powder', 'amount' => '1', 'unit' => 'tsp'],
                    ['name' => 'Lemon Zest', 'amount' => '1', 'unit' => 'tbsp'],
                    ['name' => 'Lemon Juice', 'amount' => '1/4', 'unit' => 'cup'],
                    ['name' => 'Powdered Sugar', 'amount' => '1/2', 'unit' => 'cup'],
                ],
                'tags' => ['Dessert', 'Baking', 'Sweet', 'Citrus'],
                'author_index' => 2,
            ],
        ];

        foreach ($recipes as $index => $recipeData) {
            $user = $users->get($recipeData['author_index'] % $users->count());
            
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
