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
                'image_urls' => ['https://example.com/chicken-pasta.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Cook pasta according to package instructions until al dente.', RecipeStepType::COOKING, 10),
                    new RecipeStep(2, 'Season chicken breast with salt, pepper, and paprika.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(3, 'Heat olive oil in a large pan and cook chicken until golden brown.', RecipeStepType::COOKING, 15),
                    new RecipeStep(4, 'Add garlic and onions to the pan and sauté until fragrant.', RecipeStepType::COOKING, 5),
                    new RecipeStep(5, 'Add tomatoes and cook until softened.', RecipeStepType::COOKING, 8),
                    new RecipeStep(6, 'Combine cooked pasta with chicken and vegetables.', RecipeStepType::PLATING, 3),
                    new RecipeStep(7, 'Top with fresh basil and mozzarella cheese.', RecipeStepType::PLATING, 2),
                ],
                'ingredients' => ['1 lb boneless, skinless chicken breast', '1 lb pasta (penne, fusilli, or spaghetti)', '2 large fresh ripe tomatoes, diced', '1 medium yellow onion, diced', '3 cloves fresh garlic, minced', '2 tbsp extra virgin olive oil', '1/4 cup fresh basil leaves', '8 oz fresh mozzarella cheese, cubed', '1 tsp sea salt', '1/2 tsp freshly ground black pepper', '1 tsp sweet paprika'],
                'tags' => ['Italian', 'Dinner', 'Family Dinner'],
                'author_index' => 0,
            ],
            [
                'name' => 'Vegetarian Stir Fry',
                'description' => 'A colorful and healthy vegetarian stir fry with fresh vegetables.',
                'difficulty' => DifficultyLevel::Easy,
                'image_urls' => ['https://example.com/veggie-stir-fry.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Prepare all vegetables by washing and cutting into bite-sized pieces.', RecipeStepType::PREPARATION, 10),
                    new RecipeStep(2, 'Heat oil in a wok or large pan over high heat.', RecipeStepType::COOKING, 2),
                    new RecipeStep(3, 'Add garlic and ginger, stir fry for 30 seconds.', RecipeStepType::COOKING, 1),
                    new RecipeStep(4, 'Add bell peppers and carrots, stir fry for 3 minutes.', RecipeStepType::COOKING, 3),
                    new RecipeStep(5, 'Add broccoli and mushrooms, continue stir frying.', RecipeStepType::COOKING, 4),
                    new RecipeStep(6, 'Add soy sauce and season with salt and pepper.', RecipeStepType::COOKING, 2),
                    new RecipeStep(7, 'Serve hot over rice.', RecipeStepType::PLATING, 1),
                ],
                'ingredients' => ['2 large bell peppers, mixed colors, sliced', '3 medium carrots, sliced', '1 head fresh broccoli, cut into florets', '8 oz button mushrooms, sliced', '3 cloves fresh garlic, minced', '2 inch piece fresh ginger root, minced', '2 tbsp extra virgin olive oil', '3 tbsp light soy sauce', '2 cups long grain white rice', '1 tsp sea salt', '1/2 tsp freshly ground black pepper'],
                'tags' => ['Vegetarian', 'Asian', 'Healthy', 'Quick & Easy', 'Dinner'],
                'author_index' => 1,
            ],
            [
                'name' => 'Beef and Potato Casserole',
                'description' => 'A hearty and comforting casserole perfect for cold evenings.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/beef-casserole.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Preheat oven to 375°F (190°C).', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(2, 'Brown ground beef in a large oven-safe pan.', RecipeStepType::COOKING, 10),
                    new RecipeStep(3, 'Add onions and garlic, cook until softened.', RecipeStepType::COOKING, 5),
                    new RecipeStep(4, 'Layer sliced potatoes over the beef mixture.', RecipeStepType::PREPARATION, 8),
                    new RecipeStep(5, 'Pour milk over the potatoes and season well.', RecipeStepType::PREPARATION, 3),
                    new RecipeStep(6, 'Top with cheese and cover with foil.', RecipeStepType::PREPARATION, 3),
                    new RecipeStep(7, 'Bake for 45 minutes, then remove foil and bake 15 more minutes.', RecipeStepType::COOKING, 60),
                ],
                'ingredients' => ['1 lb ground beef (80/20)', '4 large russet potatoes, sliced', '1 medium yellow onion, diced', '3 cloves fresh garlic, minced', '2 cups whole milk', '2 cups shredded cheddar cheese', '1 tsp sea salt', '1/2 tsp freshly ground black pepper', '4 tbsp unsalted butter'],
                'tags' => ['American', 'Dinner', 'Comfort Food', 'Family Dinner'],
                'author_index' => 2,
            ],
            [
                'name' => 'Fresh Garden Salad',
                'description' => 'A light and refreshing salad with seasonal vegetables.',
                'difficulty' => DifficultyLevel::Easy,
                'image_urls' => ['https://example.com/garden-salad.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Wash and dry all vegetables thoroughly.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(2, 'Chop tomatoes, carrots, and bell peppers.', RecipeStepType::PREPARATION, 8),
                    new RecipeStep(3, 'Arrange spinach leaves on serving plates.', RecipeStepType::PLATING, 2),
                    new RecipeStep(4, 'Top with chopped vegetables.', RecipeStepType::PLATING, 3),
                    new RecipeStep(5, 'Drizzle with olive oil and lemon juice.', RecipeStepType::PLATING, 2),
                    new RecipeStep(6, 'Season with salt and pepper to taste.', RecipeStepType::PLATING, 1),
                ],
                'ingredients' => ['4 cups baby spinach leaves', '2 large fresh ripe tomatoes, diced', '3 medium carrots, sliced', '2 large bell peppers, mixed colors, sliced', '2 tbsp extra virgin olive oil', '2 fresh lemons, juiced', '1 tsp sea salt', '1/2 tsp freshly ground black pepper'],
                'tags' => ['Vegetarian', 'Vegan', 'Healthy', 'Lunch', 'Summer'],
                'author_index' => 3,
            ],
            [
                'name' => 'Spicy Thai Curry',
                'description' => 'A fragrant and spicy Thai curry with coconut milk and fresh herbs.',
                'difficulty' => DifficultyLevel::Hard,
                'image_urls' => ['https://example.com/thai-curry.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Prepare curry paste by grinding chilies, garlic, and ginger.', RecipeStepType::PREPARATION, 15),
                    new RecipeStep(2, 'Heat coconut oil in a large pot over medium heat.', RecipeStepType::COOKING, 2),
                    new RecipeStep(3, 'Add curry paste and cook until fragrant.', RecipeStepType::COOKING, 3),
                    new RecipeStep(4, 'Add chicken pieces and brown on all sides.', RecipeStepType::COOKING, 8),
                    new RecipeStep(5, 'Pour in coconut milk and bring to a simmer.', RecipeStepType::COOKING, 5),
                    new RecipeStep(6, 'Add vegetables and simmer until tender.', RecipeStepType::COOKING, 15),
                    new RecipeStep(7, 'Garnish with fresh herbs and serve with rice.', RecipeStepType::PLATING, 3),
                ],
                'ingredients' => ['1 lb boneless, skinless chicken breast', '1 can (14 oz) coconut milk', '2-3 fresh Thai chilies, minced', '3 cloves fresh garlic, minced', '2 inch piece fresh ginger root, minced', '2 large bell peppers, mixed colors, sliced', '1 medium yellow onion, diced', '1/4 cup fresh basil leaves', '1/4 cup fresh cilantro, chopped', '2 cups long grain white rice'],
                'tags' => ['Thai', 'Spicy', 'Dinner', 'Exotic'],
                'author_index' => 4,
            ],
            [
                'name' => 'Mediterranean Quinoa Bowl',
                'description' => 'A nutritious and colorful bowl with quinoa, vegetables, and feta cheese.',
                'difficulty' => DifficultyLevel::Easy,
                'image_urls' => ['https://example.com/quinoa-bowl.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Cook quinoa according to package instructions.', RecipeStepType::COOKING, 15),
                    new RecipeStep(2, 'Dice cucumber, tomatoes, and red onion.', RecipeStepType::PREPARATION, 10),
                    new RecipeStep(3, 'Mix olive oil, lemon juice, and oregano for dressing.', RecipeStepType::PREPARATION, 3),
                    new RecipeStep(4, 'Arrange quinoa in bowls and top with vegetables.', RecipeStepType::PLATING, 5),
                    new RecipeStep(5, 'Add olives and crumbled feta cheese.', RecipeStepType::PLATING, 2),
                    new RecipeStep(6, 'Drizzle with dressing and garnish with parsley.', RecipeStepType::PLATING, 2),
                ],
                'ingredients' => ['1 cup quinoa, uncooked', '1 English cucumber, diced', '2 large fresh ripe tomatoes, diced', '1 small red onion, finely diced', '1/2 cup crumbled feta cheese', '1/2 cup kalamata olives, pitted', '2 tbsp extra virgin olive oil', '2 fresh lemons, juiced', '1 tbsp dried oregano', '1/4 cup fresh parsley, chopped'],
                'tags' => ['Mediterranean', 'Vegetarian', 'Healthy', 'Lunch', 'High Protein'],
                'author_index' => 5,
            ],
            [
                'name' => 'Honey Garlic Salmon',
                'description' => 'Pan-seared salmon with a sweet and savory honey garlic glaze.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/honey-garlic-salmon.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Season salmon fillets with salt and pepper.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(2, 'Heat olive oil in a large skillet over medium-high heat.', RecipeStepType::COOKING, 2),
                    new RecipeStep(3, 'Cook salmon skin-side down for 4-5 minutes.', RecipeStepType::COOKING, 5),
                    new RecipeStep(4, 'Flip salmon and cook for another 3-4 minutes.', RecipeStepType::COOKING, 4),
                    new RecipeStep(5, 'Mix honey, garlic, and soy sauce in a small bowl.', RecipeStepType::PREPARATION, 3),
                    new RecipeStep(6, 'Pour glaze over salmon and cook for 1 minute.', RecipeStepType::COOKING, 1),
                    new RecipeStep(7, 'Serve with steamed asparagus and rice.', RecipeStepType::PLATING, 2),
                ],
                'ingredients' => ['4 salmon fillets (6 oz each)', '3 tbsp raw honey', '3 cloves fresh garlic, minced', '3 tbsp light soy sauce', '2 tbsp extra virgin olive oil', '1 lb fresh asparagus spears', '2 cups long grain white rice', '1 tsp sea salt', '1/2 tsp freshly ground black pepper'],
                'tags' => ['Healthy', 'High Protein', 'Dinner', 'Pan Seared', 'Quick & Easy'],
                'author_index' => 6,
            ],
            [
                'name' => 'Classic Caesar Salad',
                'description' => 'Traditional Caesar salad with homemade dressing and croutons.',
                'difficulty' => DifficultyLevel::Easy,
                'image_urls' => ['https://example.com/caesar-salad.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Wash and chop romaine lettuce into bite-sized pieces.', RecipeStepType::PREPARATION, 8),
                    new RecipeStep(2, 'Make dressing by whisking mayonnaise, garlic, and lemon juice.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(3, 'Add Worcestershire sauce and anchovies to dressing.', RecipeStepType::PREPARATION, 2),
                    new RecipeStep(4, 'Toss lettuce with dressing until well coated.', RecipeStepType::PLATING, 3),
                    new RecipeStep(5, 'Top with grated Parmesan cheese and croutons.', RecipeStepType::PLATING, 2),
                    new RecipeStep(6, 'Season with black pepper and serve immediately.', RecipeStepType::PLATING, 1),
                ],
                'ingredients' => ['1 head romaine lettuce, chopped', '1/4 cup mayonnaise', '3 cloves fresh garlic, minced', '2 fresh lemons, juiced', '1 tbsp Worcestershire sauce', '4 oil-packed anchovy fillets', '1/2 cup grated Parmesan cheese', '1 cup seasoned croutons', '1/2 tsp freshly ground black pepper'],
                'tags' => ['Salad', 'Lunch', 'American', 'No-Cook'],
                'author_index' => 7,
            ],
            [
                'name' => 'Mexican Black Bean Tacos',
                'description' => 'Flavorful vegetarian tacos with seasoned black beans and fresh toppings.',
                'difficulty' => DifficultyLevel::Easy,
                'image_urls' => ['https://example.com/black-bean-tacos.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Heat black beans with cumin, garlic, and lime juice.', RecipeStepType::COOKING, 8),
                    new RecipeStep(2, 'Warm tortillas in a dry pan or microwave.', RecipeStepType::COOKING, 3),
                    new RecipeStep(3, 'Dice tomatoes, onions, and avocado.', RecipeStepType::PREPARATION, 10),
                    new RecipeStep(4, 'Fill tortillas with seasoned black beans.', RecipeStepType::PLATING, 3),
                    new RecipeStep(5, 'Top with diced vegetables and cilantro.', RecipeStepType::PLATING, 2),
                    new RecipeStep(6, 'Serve with lime wedges and sour cream.', RecipeStepType::PLATING, 1),
                ],
                'ingredients' => ['1 can (15 oz) black beans, drained and rinsed', '8 corn or flour tortillas', '2 large fresh ripe tomatoes, diced', '1 small red onion, finely diced', '2 ripe avocados, diced', '1/4 cup fresh cilantro, chopped', '2 fresh limes, juiced', '1 tsp ground cumin', '3 cloves fresh garlic, minced', '1/2 cup sour cream'],
                'tags' => ['Mexican', 'Vegetarian', 'Quick & Easy', 'Dinner', 'Budget Friendly'],
                'author_index' => 8,
            ],
            [
                'name' => 'Chocolate Chip Cookies',
                'description' => 'Classic homemade chocolate chip cookies that are crispy on the outside and chewy inside.',
                'difficulty' => DifficultyLevel::Easy,
                'image_urls' => ['https://example.com/chocolate-chip-cookies.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Preheat oven to 350°F (175°C).', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(2, 'Cream butter with white and brown sugar.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(3, 'Beat in eggs and vanilla extract.', RecipeStepType::PREPARATION, 3),
                    new RecipeStep(4, 'Mix flour, baking soda, and salt in separate bowl.', RecipeStepType::PREPARATION, 3),
                    new RecipeStep(5, 'Combine wet and dry ingredients, fold in chocolate chips.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(6, 'Drop spoonfuls of dough onto baking sheet.', RecipeStepType::PREPARATION, 8),
                    new RecipeStep(7, 'Bake for 10-12 minutes until golden brown.', RecipeStepType::COOKING, 12),
                ],
                'ingredients' => ['Butter', 'White Sugar', 'Brown Sugar', 'Eggs', 'Vanilla Extract', 'Flour', 'Baking Soda', 'Salt', 'Chocolate Chips'],
                'tags' => ['Dessert', 'Baked', 'American', 'Sweet', 'Kids Friendly'],
                'author_index' => 9,
            ],
            [
                'name' => 'Asian Lettuce Wraps',
                'description' => 'Light and flavorful chicken lettuce wraps with Asian-inspired seasonings.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/lettuce-wraps.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Heat sesame oil in a large skillet over medium-high heat.', RecipeStepType::COOKING, 2),
                    new RecipeStep(2, 'Add ground chicken and cook until browned.', RecipeStepType::COOKING, 8),
                    new RecipeStep(3, 'Add garlic, ginger, and green onions, cook for 2 minutes.', RecipeStepType::COOKING, 2),
                    new RecipeStep(4, 'Mix soy sauce, rice vinegar, and sesame oil for sauce.', RecipeStepType::PREPARATION, 3),
                    new RecipeStep(5, 'Add sauce to chicken mixture and simmer.', RecipeStepType::COOKING, 3),
                    new RecipeStep(6, 'Separate lettuce leaves and wash thoroughly.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(7, 'Serve chicken mixture in lettuce cups with cilantro.', RecipeStepType::PLATING, 3),
                ],
                'ingredients' => ['Chicken Breast', 'Romaine Lettuce', 'Sesame Oil', 'Garlic', 'Ginger', 'Green Onions', 'Soy Sauce', 'Rice Vinegar', 'Cilantro'],
                'tags' => ['Asian', 'Healthy', 'Low Carb', 'Dinner', 'High Protein'],
                'author_index' => 10,
            ],
            [
                'name' => 'Mushroom Risotto',
                'description' => 'Creamy Italian risotto with mixed mushrooms and Parmesan cheese.',
                'difficulty' => DifficultyLevel::Hard,
                'image_urls' => ['https://example.com/mushroom-risotto.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Heat vegetable broth in a saucepan and keep warm.', RecipeStepType::COOKING, 5),
                    new RecipeStep(2, 'Sauté sliced mushrooms in olive oil until golden.', RecipeStepType::COOKING, 8),
                    new RecipeStep(3, 'In another pan, sauté onions and garlic until translucent.', RecipeStepType::COOKING, 5),
                    new RecipeStep(4, 'Add rice and stir for 2 minutes until coated.', RecipeStepType::COOKING, 2),
                    new RecipeStep(5, 'Add white wine and stir until absorbed.', RecipeStepType::COOKING, 3),
                    new RecipeStep(6, 'Add warm broth one ladle at a time, stirring constantly.', RecipeStepType::COOKING, 25),
                    new RecipeStep(7, 'Fold in mushrooms, butter, and Parmesan cheese.', RecipeStepType::PLATING, 3),
                ],
                'ingredients' => ['Rice', 'Mushrooms', 'Vegetable Broth', 'Onions', 'Garlic', 'White Wine', 'Parmesan Cheese', 'Butter', 'Olive Oil'],
                'tags' => ['Italian', 'Vegetarian', 'Dinner', 'Comfort Food'],
                'author_index' => 11,
            ],
            [
                'name' => 'Greek Chicken Bowls',
                'description' => 'Mediterranean-inspired chicken bowls with tzatziki and fresh vegetables.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/greek-chicken-bowls.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Marinate chicken thighs in olive oil, lemon, and oregano.', RecipeStepType::PREPARATION, 30),
                    new RecipeStep(2, 'Grill chicken until cooked through and golden.', RecipeStepType::COOKING, 15),
                    new RecipeStep(3, 'Prepare tzatziki by mixing yogurt, cucumber, and garlic.', RecipeStepType::PREPARATION, 10),
                    new RecipeStep(4, 'Cook rice and let cool slightly.', RecipeStepType::COOKING, 15),
                    new RecipeStep(5, 'Dice tomatoes, cucumber, and red onion.', RecipeStepType::PREPARATION, 8),
                    new RecipeStep(6, 'Arrange rice in bowls and top with sliced chicken.', RecipeStepType::PLATING, 5),
                    new RecipeStep(7, 'Add vegetables, olives, feta, and tzatziki.', RecipeStepType::PLATING, 3),
                ],
                'ingredients' => ['Chicken Thighs', 'Rice', 'Greek Yogurt', 'Cucumber', 'Tomatoes', 'Red Onion', 'Feta Cheese', 'Olives', 'Olive Oil', 'Lemon', 'Oregano', 'Garlic'],
                'tags' => ['Greek', 'Mediterranean', 'Healthy', 'High Protein', 'Grilled'],
                'author_index' => 12,
            ],
            [
                'name' => 'Banana Pancakes',
                'description' => 'Fluffy pancakes with mashed bananas and a hint of cinnamon.',
                'difficulty' => DifficultyLevel::Easy,
                'image_urls' => ['https://example.com/banana-pancakes.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Mash ripe bananas in a large bowl.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(2, 'Whisk in eggs, milk, and vanilla extract.', RecipeStepType::PREPARATION, 3),
                    new RecipeStep(3, 'In separate bowl, mix flour, baking powder, salt, and cinnamon.', RecipeStepType::PREPARATION, 3),
                    new RecipeStep(4, 'Combine wet and dry ingredients until just mixed.', RecipeStepType::PREPARATION, 2),
                    new RecipeStep(5, 'Heat griddle or pan over medium heat with butter.', RecipeStepType::COOKING, 3),
                    new RecipeStep(6, 'Pour batter to form pancakes and cook until bubbles form.', RecipeStepType::COOKING, 8),
                    new RecipeStep(7, 'Flip and cook until golden brown, serve with maple syrup.', RecipeStepType::PLATING, 5),
                ],
                'ingredients' => ['Bananas', 'Eggs', 'Milk', 'Vanilla Extract', 'Flour', 'Baking Powder', 'Salt', 'Cinnamon', 'Butter', 'Maple Syrup'],
                'tags' => ['Breakfast', 'American', 'Sweet', 'Kids Friendly'],
                'author_index' => 13,
            ],
            [
                'name' => 'Beef Stir Fry',
                'description' => 'Quick and easy beef stir fry with colorful vegetables and savory sauce.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/beef-stir-fry.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Slice beef into thin strips against the grain.', RecipeStepType::PREPARATION, 10),
                    new RecipeStep(2, 'Heat oil in wok or large skillet over high heat.', RecipeStepType::COOKING, 2),
                    new RecipeStep(3, 'Stir fry beef until browned, remove from pan.', RecipeStepType::COOKING, 5),
                    new RecipeStep(4, 'Add vegetables to pan and stir fry until crisp-tender.', RecipeStepType::COOKING, 6),
                    new RecipeStep(5, 'Mix soy sauce, garlic, and ginger for sauce.', RecipeStepType::PREPARATION, 2),
                    new RecipeStep(6, 'Return beef to pan, add sauce and toss.', RecipeStepType::COOKING, 2),
                    new RecipeStep(7, 'Serve immediately over steamed rice.', RecipeStepType::PLATING, 2),
                ],
                'ingredients' => ['Beef', 'Bell Peppers', 'Broccoli', 'Carrots', 'Soy Sauce', 'Garlic', 'Ginger', 'Olive Oil', 'Rice'],
                'tags' => ['Asian', 'Quick & Easy', 'Dinner', 'High Protein'],
                'author_index' => 14,
            ],
            [
                'name' => 'Caprese Salad',
                'description' => 'Simple Italian salad with fresh mozzarella, tomatoes, and basil.',
                'difficulty' => DifficultyLevel::Easy,
                'image_urls' => ['https://example.com/caprese-salad.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Slice fresh mozzarella into 1/4 inch thick rounds.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(2, 'Slice ripe tomatoes into similar thickness.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(3, 'Arrange mozzarella and tomato slices alternately on plate.', RecipeStepType::PLATING, 3),
                    new RecipeStep(4, 'Tuck fresh basil leaves between slices.', RecipeStepType::PLATING, 2),
                    new RecipeStep(5, 'Drizzle with extra virgin olive oil.', RecipeStepType::PLATING, 1),
                    new RecipeStep(6, 'Finish with balsamic vinegar and season with salt and pepper.', RecipeStepType::PLATING, 1),
                ],
                'ingredients' => ['Mozzarella Cheese', 'Tomatoes', 'Basil', 'Olive Oil', 'Balsamic Vinegar', 'Salt', 'Black Pepper'],
                'tags' => ['Italian', 'Vegetarian', 'No-Cook', 'Appetizer', 'Summer'],
                'author_index' => 15,
            ],
            [
                'name' => 'Lemon Herb Roasted Chicken',
                'description' => 'Whole roasted chicken with aromatic herbs and bright lemon flavor.',
                'difficulty' => DifficultyLevel::Hard,
                'image_urls' => ['https://example.com/roasted-chicken.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Preheat oven to 425°F (220°C).', RecipeStepType::PREPARATION, 10),
                    new RecipeStep(2, 'Pat chicken dry and season inside and out with salt and pepper.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(3, 'Stuff cavity with lemon halves and herb sprigs.', RecipeStepType::PREPARATION, 3),
                    new RecipeStep(4, 'Rub skin with olive oil and season with herbs.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(5, 'Place on roasting pan with vegetables around it.', RecipeStepType::PREPARATION, 8),
                    new RecipeStep(6, 'Roast for 60-75 minutes until internal temp reaches 165°F.', RecipeStepType::COOKING, 75),
                    new RecipeStep(7, 'Let rest for 10 minutes before carving.', RecipeStepType::PLATING, 10),
                ],
                'ingredients' => ['Chicken', 'Lemon', 'Rosemary', 'Thyme', 'Olive Oil', 'Potatoes', 'Carrots', 'Onions', 'Salt', 'Black Pepper'],
                'tags' => ['American', 'Roasted', 'Family Dinner', 'Sunday Dinner'],
                'author_index' => 16,
            ],
            [
                'name' => 'Shrimp Scampi',
                'description' => 'Classic Italian-American dish with shrimp in garlic white wine sauce.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/shrimp-scampi.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Cook pasta according to package directions.', RecipeStepType::COOKING, 10),
                    new RecipeStep(2, 'Heat olive oil and butter in large skillet.', RecipeStepType::COOKING, 2),
                    new RecipeStep(3, 'Add garlic and cook until fragrant, about 1 minute.', RecipeStepType::COOKING, 1),
                    new RecipeStep(4, 'Add shrimp and cook until pink, about 3 minutes per side.', RecipeStepType::COOKING, 6),
                    new RecipeStep(5, 'Add white wine and lemon juice, simmer for 2 minutes.', RecipeStepType::COOKING, 2),
                    new RecipeStep(6, 'Toss with cooked pasta and fresh parsley.', RecipeStepType::PLATING, 2),
                    new RecipeStep(7, 'Serve immediately with lemon wedges.', RecipeStepType::PLATING, 1),
                ],
                'ingredients' => ['Shrimp', 'Pasta', 'Garlic', 'White Wine', 'Lemon', 'Olive Oil', 'Butter', 'Parsley'],
                'tags' => ['Italian', 'Seafood', 'Dinner', 'Date Night'],
                'author_index' => 17,
            ],
            [
                'name' => 'Vegetable Curry',
                'description' => 'Aromatic Indian-style curry with mixed vegetables and coconut milk.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/vegetable-curry.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Heat coconut oil in large pot over medium heat.', RecipeStepType::COOKING, 2),
                    new RecipeStep(2, 'Add onions and cook until softened, about 5 minutes.', RecipeStepType::COOKING, 5),
                    new RecipeStep(3, 'Add garlic, ginger, and spices, cook for 1 minute.', RecipeStepType::COOKING, 1),
                    new RecipeStep(4, 'Add vegetables and stir to coat with spices.', RecipeStepType::COOKING, 3),
                    new RecipeStep(5, 'Pour in coconut milk and bring to simmer.', RecipeStepType::COOKING, 5),
                    new RecipeStep(6, 'Simmer for 15-20 minutes until vegetables are tender.', RecipeStepType::COOKING, 20),
                    new RecipeStep(7, 'Garnish with cilantro and serve with rice.', RecipeStepType::PLATING, 2),
                ],
                'ingredients' => ['Coconut Oil', 'Onions', 'Garlic', 'Ginger', 'Coconut Milk', 'Sweet Potatoes', 'Bell Peppers', 'Carrots', 'Turmeric', 'Cumin', 'Garam Masala', 'Cilantro', 'Rice'],
                'tags' => ['Indian', 'Vegetarian', 'Vegan', 'Spicy', 'Dinner'],
                'author_index' => 18,
            ],
            [
                'name' => 'BBQ Pulled Pork',
                'description' => 'Slow-cooked pulled pork with tangy BBQ sauce, perfect for sandwiches.',
                'difficulty' => DifficultyLevel::Hard,
                'image_urls' => ['https://example.com/pulled-pork.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Season pork with salt, pepper, and paprika.', RecipeStepType::PREPARATION, 10),
                    new RecipeStep(2, 'Sear pork in Dutch oven until browned on all sides.', RecipeStepType::COOKING, 15),
                    new RecipeStep(3, 'Add onions, garlic, and cook until softened.', RecipeStepType::COOKING, 5),
                    new RecipeStep(4, 'Add tomatoes, vinegar, and brown sugar.', RecipeStepType::COOKING, 3),
                    new RecipeStep(5, 'Cover and cook in 325°F oven for 3-4 hours.', RecipeStepType::COOKING, 240),
                    new RecipeStep(6, 'Shred meat and mix with cooking juices.', RecipeStepType::PREPARATION, 10),
                    new RecipeStep(7, 'Serve on buns with coleslaw.', RecipeStepType::PLATING, 5),
                ],
                'ingredients' => ['Pork', 'Onions', 'Garlic', 'Tomatoes', 'Brown Sugar', 'Paprika', 'Salt', 'Black Pepper', 'Cabbage'],
                'tags' => ['American', 'BBQ', 'Slow Cooked', 'Comfort Food'],
                'author_index' => 19,
            ],
            [
                'name' => 'Overnight Oats',
                'description' => 'No-cook breakfast with oats, yogurt, and fresh berries.',
                'difficulty' => DifficultyLevel::Easy,
                'image_urls' => ['https://example.com/overnight-oats.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Combine oats, chia seeds, and cinnamon in jar.', RecipeStepType::PREPARATION, 2),
                    new RecipeStep(2, 'Add milk and Greek yogurt, stir well.', RecipeStepType::PREPARATION, 2),
                    new RecipeStep(3, 'Stir in maple syrup and vanilla extract.', RecipeStepType::PREPARATION, 1),
                    new RecipeStep(4, 'Refrigerate overnight or at least 4 hours.', RecipeStepType::PREPARATION, 480),
                    new RecipeStep(5, 'In morning, add fresh berries and nuts.', RecipeStepType::PLATING, 2),
                    new RecipeStep(6, 'Enjoy cold or warm slightly in microwave.', RecipeStepType::PLATING, 1),
                ],
                'ingredients' => ['Oats', 'Chia Seeds', 'Milk', 'Greek Yogurt', 'Maple Syrup', 'Vanilla Extract', 'Cinnamon', 'Blueberries', 'Strawberries', 'Almonds'],
                'tags' => ['Breakfast', 'No-Cook', 'Healthy', 'Meal Prep'],
                'author_index' => 20,
            ],
            [
                'name' => 'Fish Tacos',
                'description' => 'Light and fresh fish tacos with creamy coleslaw and lime.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/fish-tacos.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Season fish fillets with cumin, paprika, and lime juice.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(2, 'Heat oil in skillet and cook fish until flaky.', RecipeStepType::COOKING, 8),
                    new RecipeStep(3, 'Mix cabbage, mayonnaise, and lime juice for slaw.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(4, 'Warm tortillas in dry pan or microwave.', RecipeStepType::COOKING, 2),
                    new RecipeStep(5, 'Flake fish into bite-sized pieces.', RecipeStepType::PREPARATION, 3),
                    new RecipeStep(6, 'Fill tortillas with fish and top with slaw.', RecipeStepType::PLATING, 3),
                    new RecipeStep(7, 'Garnish with cilantro and serve with lime wedges.', RecipeStepType::PLATING, 2),
                ],
                'ingredients' => ['Fish', 'Tortillas', 'Cabbage', 'Mayonnaise', 'Lime', 'Cumin', 'Paprika', 'Cilantro', 'Olive Oil'],
                'tags' => ['Mexican', 'Healthy', 'Seafood', 'Quick & Easy'],
                'author_index' => 21,
            ],
            [
                'name' => 'Stuffed Bell Peppers',
                'description' => 'Colorful bell peppers stuffed with rice, ground turkey, and vegetables.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/stuffed-peppers.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Cut tops off bell peppers and remove seeds and membranes.', RecipeStepType::PREPARATION, 10),
                    new RecipeStep(2, 'Cook rice according to package directions.', RecipeStepType::COOKING, 15),
                    new RecipeStep(3, 'Brown ground turkey with onions and garlic.', RecipeStepType::COOKING, 8),
                    new RecipeStep(4, 'Mix turkey with cooked rice, diced tomatoes, and seasonings.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(5, 'Stuff peppers with rice mixture and top with cheese.', RecipeStepType::PREPARATION, 8),
                    new RecipeStep(6, 'Bake at 375°F for 25-30 minutes until peppers are tender.', RecipeStepType::COOKING, 30),
                    new RecipeStep(7, 'Let cool for 5 minutes before serving.', RecipeStepType::PLATING, 5),
                ],
                'ingredients' => ['Bell Peppers', 'Rice', 'Turkey', 'Onions', 'Garlic', 'Tomatoes', 'Cheese', 'Salt', 'Black Pepper'],
                'tags' => ['American', 'Baked', 'Family Dinner', 'High Protein'],
                'author_index' => 22,
            ],
            [
                'name' => 'Chicken Noodle Soup',
                'description' => 'Classic comfort soup with tender chicken, vegetables, and egg noodles.',
                'difficulty' => DifficultyLevel::Medium,
                'image_urls' => ['https://example.com/chicken-soup.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Heat olive oil in large pot over medium heat.', RecipeStepType::COOKING, 2),
                    new RecipeStep(2, 'Add onions, carrots, and celery, cook until softened.', RecipeStepType::COOKING, 8),
                    new RecipeStep(3, 'Add garlic and cook for 1 minute.', RecipeStepType::COOKING, 1),
                    new RecipeStep(4, 'Add chicken, broth, and herbs, bring to boil.', RecipeStepType::COOKING, 10),
                    new RecipeStep(5, 'Simmer for 20 minutes until chicken is cooked through.', RecipeStepType::COOKING, 20),
                    new RecipeStep(6, 'Remove chicken, shred, and return to pot.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(7, 'Add noodles and cook until tender, about 8 minutes.', RecipeStepType::COOKING, 8),
                ],
                'ingredients' => ['Chicken Breast', 'Noodles', 'Onions', 'Carrots', 'Garlic', 'Vegetable Broth', 'Thyme', 'Bay Leaves', 'Olive Oil', 'Salt', 'Black Pepper'],
                'tags' => ['American', 'Soup', 'Comfort Food', 'Winter'],
                'author_index' => 23,
            ],
            [
                'name' => 'Chocolate Lava Cake',
                'description' => 'Decadent individual chocolate cakes with molten chocolate centers.',
                'difficulty' => DifficultyLevel::Hard,
                'image_urls' => ['https://example.com/lava-cake.jpg'],
                'steps' => [
                    new RecipeStep(1, 'Preheat oven to 425°F and butter ramekins.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(2, 'Melt chocolate and butter in double boiler.', RecipeStepType::COOKING, 5),
                    new RecipeStep(3, 'Whisk eggs and sugar until thick and pale.', RecipeStepType::PREPARATION, 5),
                    new RecipeStep(4, 'Fold melted chocolate into egg mixture.', RecipeStepType::PREPARATION, 2),
                    new RecipeStep(5, 'Gently fold in flour and salt.', RecipeStepType::PREPARATION, 2),
                    new RecipeStep(6, 'Divide between ramekins and bake 12-14 minutes.', RecipeStepType::COOKING, 14),
                    new RecipeStep(7, 'Invert onto plates and dust with powdered sugar.', RecipeStepType::PLATING, 3),
                ],
                'ingredients' => ['Chocolate Chips', 'Butter', 'Eggs', 'White Sugar', 'Flour', 'Salt'],
                'tags' => ['Dessert', 'French', 'Romantic', 'Date Night', 'Baked'],
                'author_index' => 24,
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
                    'image_urls' => $recipeData['image_urls'],
                    'steps' => $recipeData['steps'],
                ]
            );

            // Attach ingredients if recipe was just created
            if ($recipe->wasRecentlyCreated) {
                foreach ($recipeData['ingredients'] as $ingredientDescription) {
                    $ingredient = Ingredient::where('description', $ingredientDescription)->first();
                    if ($ingredient) {
                        $recipe->ingredients()->attach($ingredient->id);
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
