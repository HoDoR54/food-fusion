<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\RecipeAttempt;
use App\Models\User;
use Illuminate\Database\Seeder;

class RecipeAttemptsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all recipes and users (except admin and moderators for more realistic data)
        $recipes = Recipe::all();
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'User');
        })->get();

        if ($recipes->isEmpty() || $users->isEmpty()) {
            $this->command->warn('No recipes or users found. Please run RecipesSeeder and UserSeeder first.');

            return;
        }

        $defaultImageUrl = 'https://res.cloudinary.com/dybgsw0ej/image/upload/v1758901063/4_qzt2ni.jpg';

        // Sample recipe attempts data
        $attempts = [
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'First time making this! Turned out pretty good but I think I overcooked the chicken a bit. Will try again soon.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Amazing recipe! My family loved it. Added extra vegetables and it was perfect.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'The flavors were incredible. I substituted quinoa for rice and it worked great!',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Quick and easy weeknight dinner. Kids ate everything on their plates!',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'This was my second attempt and it came out much better. Practice makes perfect!',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Made this for date night. Absolutely delicious! Will definitely make again.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Healthy and tasty! I love how colorful this dish is. Great for meal prep too.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'The spice level was perfect for me, but next time I might add more vegetables.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Comfort food at its finest! This reminded me of my grandmother\'s cooking.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Light and refreshing summer meal. Perfect for hot days when you don\'t want heavy food.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'The curry was absolutely delicious! I made it less spicy for the kids and they loved it too.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Great protein bowl! I meal prepped this for the week and it stayed fresh.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'The honey glaze was incredible. The salmon was perfectly cooked and flaky.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Classic recipe done right. The dressing was creamy and flavorful.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'These tacos were so fresh and healthy. Great alternative to traditional beef tacos.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Baking cookies with the kids was so much fun! They turned out crispy and chewy.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Love these lettuce wraps! So light and flavorful, perfect for a healthy lunch.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'The risotto was creamy and rich. Took some patience but totally worth it!',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Mediterranean flavors are my favorite! This bowl was fresh and satisfying.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Perfect weekend breakfast! The kids loved helping flip the pancakes.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Quick stir fry for busy weeknight. Everything cooked perfectly in the wok.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Simple but elegant. Perfect appetizer for dinner party guests.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'The whole house smelled amazing while this was roasting. Herb flavors were perfect.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Restaurant quality at home! The garlic wine sauce was incredible.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Warming and comforting curry. The spices made the kitchen smell like heaven.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'BBQ pulled pork was tender and flavorful. Great for feeding a crowd!',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Perfect make-ahead breakfast! Love having this ready in the morning.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Fish tacos with a healthy twist! The slaw added perfect crunch.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Stuffed peppers were colorful and nutritious. Kids thought they were fun to eat!',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Nothing beats homemade chicken soup when you\'re feeling under the weather.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Decadent dessert for special occasion. The molten center was perfect!',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Made this for my vegetarian friends and they absolutely loved it!',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Second time making this curry - getting better each time! Added extra coconut milk.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'Perfect summer salad! Light, fresh, and exactly what I needed on a hot day.',
            ],
            [
                'image_url' => $defaultImageUrl,
                'notes' => 'The pasta was cooked perfectly al dente. Great recipe for pasta lovers!',
            ],
        ];

        // Create recipe attempts by randomly assigning them to users and recipes
        foreach ($attempts as $index => $attemptData) {
            $user = $users->random();
            $recipe = $recipes->random();

            RecipeAttempt::create([
                'recipe_id' => $recipe->id,
                'user_id' => $user->id,
                'image_url' => $attemptData['image_url'],
                'notes' => $attemptData['notes'],
            ]);
        }

        $this->command->info('Recipe attempts seeded successfully!');
    }
}
