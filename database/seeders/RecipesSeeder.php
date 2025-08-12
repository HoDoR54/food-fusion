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
            [
                'name' => 'Homemade Pizza Margherita',
                'description' => 'Classic Italian pizza with fresh tomatoes, mozzarella, and basil.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/pizza-margherita.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Prepare pizza dough and let it rise for 1 hour.', 70),
                    new RecipeStep(2, 'Preheat oven to 475°F (245°C).', 15),
                    new RecipeStep(3, 'Roll out dough on a floured surface.', 5),
                    new RecipeStep(4, 'Spread tomato sauce evenly over dough.', 3),
                    new RecipeStep(5, 'Add sliced mozzarella and fresh basil leaves.', 4),
                    new RecipeStep(6, 'Drizzle with olive oil and season with salt.', 2),
                    new RecipeStep(7, 'Bake for 12-15 minutes until crust is golden.', 15),
                ],
                'ingredients' => ['Flour', 'Tomatoes', 'Mozzarella Cheese', 'Basil', 'Olive Oil', 'Salt', 'Garlic'],
                'tags' => ['Italian', 'Dinner', 'Baked', 'Weekend Special'],
            ],
            [
                'name' => 'Pancakes with Berries',
                'description' => 'Fluffy breakfast pancakes topped with fresh berries and syrup.',
                'difficulty' => DifficultyLevel::Easy,
                'image_urls' => ['https://example.com/berry-pancakes.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Mix flour, sugar, and baking powder in a bowl.', 3),
                    new RecipeStep(2, 'In another bowl, whisk eggs, milk, and melted butter.', 4),
                    new RecipeStep(3, 'Combine wet and dry ingredients until just mixed.', 2),
                    new RecipeStep(4, 'Heat butter in a pan over medium heat.', 2),
                    new RecipeStep(5, 'Pour batter to form pancakes and cook until bubbles form.', 4),
                    new RecipeStep(6, 'Flip and cook until golden brown.', 3),
                    new RecipeStep(7, 'Serve with fresh berries and syrup.', 2),
                ],
                'ingredients' => ['Flour', 'Eggs', 'Milk', 'Butter', 'Salt', 'Baking Powder', 'White Sugar'],
                'tags' => ['American', 'Breakfast', 'Quick & Easy', 'Family Dinner'],
            ],
            [
                'name' => 'Mediterranean Quinoa Bowl',
                'description' => 'Healthy grain bowl with quinoa, vegetables, and feta cheese.',
                'difficulty' => DifficultyLevel::Easy,
                'image_urls' => ['https://example.com/quinoa-bowl.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Rinse quinoa and cook according to package instructions.', 15),
                    new RecipeStep(2, 'Dice tomatoes, onions, and bell peppers.', 8),
                    new RecipeStep(3, 'Prepare lemon vinaigrette with olive oil and lemon juice.', 5),
                    new RecipeStep(4, 'Combine cooked quinoa with diced vegetables.', 3),
                    new RecipeStep(5, 'Drizzle with vinaigrette and toss gently.', 2),
                    new RecipeStep(6, 'Top with crumbled feta cheese and fresh herbs.', 3),
                ],
                'ingredients' => ['Quinoa', 'Tomatoes', 'Onions', 'Bell Peppers', 'Feta Cheese', 'Olive Oil', 'Lemon', 'Parsley'],
                'tags' => ['Mediterranean', 'Vegetarian', 'Healthy', 'Lunch', 'No-Cook'],
            ],
            [
                'name' => 'Grilled Salmon with Asparagus',
                'description' => 'Perfectly grilled salmon served with tender asparagus spears.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/grilled-salmon.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Preheat grill to medium-high heat.', 10),
                    new RecipeStep(2, 'Season salmon fillets with salt, pepper, and lemon.', 5),
                    new RecipeStep(3, 'Trim asparagus ends and toss with olive oil.', 5),
                    new RecipeStep(4, 'Grill salmon for 4-5 minutes per side.', 10),
                    new RecipeStep(5, 'Grill asparagus for 6-8 minutes, turning occasionally.', 8),
                    new RecipeStep(6, 'Serve immediately with lemon wedges.', 2),
                ],
                'ingredients' => ['Salmon', 'Asparagus', 'Olive Oil', 'Lemon', 'Salt', 'Black Pepper', 'Garlic'],
                'tags' => ['Healthy', 'Grilled', 'Dinner', 'Date Night', 'Summer'],
            ],
            [
                'name' => 'Chocolate Chip Cookies',
                'description' => 'Classic chewy chocolate chip cookies perfect for any occasion.',
                'difficulty' => DifficultyLevel::Easy,
                'image_urls' => ['https://example.com/chocolate-cookies.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Preheat oven to 375°F (190°C).', 10),
                    new RecipeStep(2, 'Cream butter with brown and white sugars.', 5),
                    new RecipeStep(3, 'Beat in eggs and vanilla extract.', 3),
                    new RecipeStep(4, 'Mix in flour, baking soda, and salt.', 4),
                    new RecipeStep(5, 'Fold in chocolate chips.', 2),
                    new RecipeStep(6, 'Drop spoonfuls of dough onto baking sheets.', 5),
                    new RecipeStep(7, 'Bake for 9-11 minutes until edges are golden.', 11),
                ],
                'ingredients' => ['Flour', 'Butter', 'Eggs', 'Salt', 'Chocolate Chips', 'Brown Sugar', 'White Sugar', 'Vanilla Extract', 'Baking Soda'],
                'tags' => ['American', 'Dessert', 'Baked', 'Family Dinner', 'Weekend Special'],
            ],
            [
                'name' => 'Mushroom Risotto',
                'description' => 'Creamy Italian risotto with mixed mushrooms and parmesan.',
                'difficulty' => DifficultyLevel::Hard,
                'image_urls' => ['https://example.com/mushroom-risotto.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Heat broth in a saucepan and keep warm.', 5),
                    new RecipeStep(2, 'Sauté mushrooms in butter until golden.', 8),
                    new RecipeStep(3, 'In another pan, cook onions until translucent.', 5),
                    new RecipeStep(4, 'Add rice and stir for 2 minutes.', 2),
                    new RecipeStep(5, 'Add warm broth one ladle at a time, stirring constantly.', 25),
                    new RecipeStep(6, 'Fold in cooked mushrooms and parmesan cheese.', 3),
                    new RecipeStep(7, 'Season and garnish with fresh herbs.', 2),
                ],
                'ingredients' => ['Rice', 'Mushrooms', 'Onions', 'Garlic', 'Butter', 'Cheese', 'Parsley'],
                'tags' => ['Italian', 'Vegetarian', 'Dinner', 'Sautéed', 'Date Night'],
            ],
            [
                'name' => 'Fish Tacos with Lime Crema',
                'description' => 'Fresh fish tacos with crispy cabbage and zesty lime crema.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/fish-tacos.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Season fish with cumin, paprika, salt, and pepper.', 5),
                    new RecipeStep(2, 'Prepare lime crema by mixing sour cream with lime juice.', 3),
                    new RecipeStep(3, 'Shred cabbage and dice tomatoes.', 8),
                    new RecipeStep(4, 'Heat oil in a pan and cook fish until flaky.', 8),
                    new RecipeStep(5, 'Warm tortillas in a dry pan or microwave.', 2),
                    new RecipeStep(6, 'Assemble tacos with fish, cabbage, and tomatoes.', 5),
                    new RecipeStep(7, 'Top with lime crema and fresh cilantro.', 2),
                ],
                'ingredients' => ['Fish', 'Tomatoes', 'Onions', 'Lime', 'Cumin', 'Paprika', 'Olive Oil', 'Salt', 'Black Pepper', 'Cabbage', 'Sour Cream', 'Tortillas', 'Cilantro'],
                'tags' => ['Mexican', 'Lunch', 'Dinner', 'Sautéed', 'Summer'],
            ],
            [
                'name' => 'Beef Stir Fry with Noodles',
                'description' => 'Quick and flavorful beef stir fry served over rice noodles.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/beef-stir-fry.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Cook noodles according to package instructions.', 8),
                    new RecipeStep(2, 'Slice beef thinly against the grain.', 5),
                    new RecipeStep(3, 'Heat oil in a wok over high heat.', 2),
                    new RecipeStep(4, 'Stir fry beef until browned, about 3 minutes.', 3),
                    new RecipeStep(5, 'Add garlic, ginger, and vegetables.', 4),
                    new RecipeStep(6, 'Add soy sauce and toss with cooked noodles.', 3),
                    new RecipeStep(7, 'Garnish with green onions and serve hot.', 2),
                ],
                'ingredients' => ['Beef', 'Garlic', 'Ginger', 'Bell Peppers', 'Carrots', 'Soy Sauce', 'Olive Oil', 'Noodles', 'Green Onions'],
                'tags' => ['Asian', 'Dinner', 'Sautéed', 'Quick & Easy'],
            ],
            [
                'name' => 'Greek Salad',
                'description' => 'Traditional Greek salad with tomatoes, olives, and feta cheese.',
                'difficulty' => DifficultyLevel::Easy,
                'image_urls' => ['https://example.com/greek-salad.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Chop tomatoes, onions, and bell peppers into chunks.', 8),
                    new RecipeStep(2, 'Slice cucumber into thick rounds.', 3),
                    new RecipeStep(3, 'Combine vegetables in a large bowl.', 2),
                    new RecipeStep(4, 'Add olives and crumbled feta cheese.', 3),
                    new RecipeStep(5, 'Drizzle with olive oil and lemon juice.', 2),
                    new RecipeStep(6, 'Season with salt, pepper, and oregano.', 2),
                ],
                'ingredients' => ['Tomatoes', 'Onions', 'Bell Peppers', 'Cucumber', 'Feta Cheese', 'Olives', 'Olive Oil', 'Lemon', 'Salt', 'Black Pepper', 'Oregano'],
                'tags' => ['Mediterranean', 'Vegetarian', 'Healthy', 'No-Cook', 'Lunch', 'Summer'],
            ],
            [
                'name' => 'Banana Bread',
                'description' => 'Moist and delicious banana bread perfect for breakfast or snack.',
                'difficulty' => DifficultyLevel::Easy,
                'image_urls' => ['https://example.com/banana-bread.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Preheat oven to 350°F (175°C).', 10),
                    new RecipeStep(2, 'Mash ripe bananas in a large bowl.', 5),
                    new RecipeStep(3, 'Mix in melted butter, sugar, egg, and vanilla.', 5),
                    new RecipeStep(4, 'Add flour, baking soda, and salt.', 3),
                    new RecipeStep(5, 'Pour batter into greased loaf pan.', 3),
                    new RecipeStep(6, 'Bake for 60-65 minutes until golden brown.', 65),
                    new RecipeStep(7, 'Cool before slicing and serving.', 30),
                ],
                'ingredients' => ['Flour', 'Butter', 'Eggs', 'Salt', 'Bananas', 'Baking Soda', 'White Sugar', 'Vanilla Extract'],
                'tags' => ['American', 'Breakfast', 'Dessert', 'Baked', 'Weekend Special'],
            ],
            [
                'name' => 'Lentil Soup',
                'description' => 'Hearty and nutritious lentil soup with vegetables and herbs.',
                'difficulty' => DifficultyLevel::Easy,
                'image_urls' => ['https://example.com/lentil-soup.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Rinse and sort lentils, removing any debris.', 5),
                    new RecipeStep(2, 'Dice onions, carrots, and garlic.', 8),
                    new RecipeStep(3, 'Heat olive oil in a large pot and sauté vegetables.', 8),
                    new RecipeStep(4, 'Add lentils and cover with water or broth.', 3),
                    new RecipeStep(5, 'Bring to a boil, then simmer for 25-30 minutes.', 30),
                    new RecipeStep(6, 'Season with salt, pepper, and fresh herbs.', 3),
                    new RecipeStep(7, 'Serve hot with crusty bread.', 2),
                ],
                'ingredients' => ['Lentils', 'Onions', 'Carrots', 'Garlic', 'Olive Oil', 'Salt', 'Black Pepper', 'Parsley', 'Vegetable Broth'],
                'tags' => ['Vegetarian', 'Vegan', 'Healthy', 'Lunch', 'Dinner', 'Comfort Food'],
            ],
            [
                'name' => 'Chicken Caesar Salad',
                'description' => 'Classic Caesar salad topped with grilled chicken breast.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/chicken-caesar.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Season chicken breast and grill until cooked through.', 15),
                    new RecipeStep(2, 'Prepare Caesar dressing with mayonnaise and lemon.', 5),
                    new RecipeStep(3, 'Wash and chop romaine lettuce.', 5),
                    new RecipeStep(4, 'Slice grilled chicken into strips.', 3),
                    new RecipeStep(5, 'Toss lettuce with Caesar dressing.', 2),
                    new RecipeStep(6, 'Top with chicken strips and parmesan cheese.', 3),
                    new RecipeStep(7, 'Garnish with croutons and serve immediately.', 2),
                ],
                'ingredients' => ['Chicken Breast', 'Romaine Lettuce', 'Parmesan Cheese', 'Olive Oil', 'Lemon', 'Garlic', 'Salt', 'Black Pepper', 'Mayonnaise', 'Croutons'],
                'tags' => ['American', 'Lunch', 'Dinner', 'Grilled', 'Healthy'],
            ],
            [
                'name' => 'Vegetable Curry',
                'description' => 'Spicy and aromatic vegetable curry with coconut milk.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/vegetable-curry.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Chop all vegetables into bite-sized pieces.', 10),
                    new RecipeStep(2, 'Heat oil in a large pot and sauté onions.', 5),
                    new RecipeStep(3, 'Add garlic, ginger, and curry spices.', 3),
                    new RecipeStep(4, 'Add harder vegetables first and cook for 5 minutes.', 5),
                    new RecipeStep(5, 'Pour in coconut milk and bring to a simmer.', 5),
                    new RecipeStep(6, 'Add remaining vegetables and cook until tender.', 15),
                    new RecipeStep(7, 'Season and serve over rice with fresh herbs.', 3),
                ],
                'ingredients' => ['Onions', 'Garlic', 'Ginger', 'Bell Peppers', 'Carrots', 'Potatoes', 'Coconut Milk', 'Cumin', 'Rice', 'Olive Oil', 'Salt'],
                'tags' => ['Indian', 'Vegetarian', 'Vegan', 'Dinner', 'Sautéed', 'Healthy'],
            ],
            [
                'name' => 'Apple Pie',
                'description' => 'Classic homemade apple pie with cinnamon and flaky crust.',
                'difficulty' => DifficultyLevel::Hard,
                'image_urls' => ['https://example.com/apple-pie.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Prepare pie crust dough and chill for 1 hour.', 70),
                    new RecipeStep(2, 'Peel and slice apples thinly.', 15),
                    new RecipeStep(3, 'Mix apples with sugar and cinnamon.', 5),
                    new RecipeStep(4, 'Roll out bottom crust and place in pie pan.', 8),
                    new RecipeStep(5, 'Fill with apple mixture and dot with butter.', 5),
                    new RecipeStep(6, 'Cover with top crust and seal edges.', 8),
                    new RecipeStep(7, 'Bake at 425°F for 45-50 minutes until golden.', 50),
                ],
                'ingredients' => ['Flour', 'Butter', 'Salt', 'Apples', 'White Sugar', 'Cinnamon'],
                'tags' => ['American', 'Dessert', 'Baked', 'Holiday', 'Weekend Special'],
            ],
            [
                'name' => 'Shrimp Scampi',
                'description' => 'Garlicky shrimp scampi with white wine and fresh herbs.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/shrimp-scampi.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Cook pasta according to package directions.', 10),
                    new RecipeStep(2, 'Clean and devein shrimp, pat dry.', 8),
                    new RecipeStep(3, 'Heat olive oil and butter in a large skillet.', 3),
                    new RecipeStep(4, 'Sauté garlic until fragrant, about 1 minute.', 1),
                    new RecipeStep(5, 'Add shrimp and cook until pink, 2-3 minutes per side.', 6),
                    new RecipeStep(6, 'Add white wine and lemon juice, simmer briefly.', 3),
                    new RecipeStep(7, 'Toss with cooked pasta and fresh parsley.', 3),
                ],
                'ingredients' => ['Pasta', 'Shrimp', 'Garlic', 'Olive Oil', 'Butter', 'Lemon', 'Parsley', 'Salt', 'Black Pepper', 'White Wine'],
                'tags' => ['Italian', 'Dinner', 'Sautéed', 'Date Night', 'Quick & Easy'],
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
