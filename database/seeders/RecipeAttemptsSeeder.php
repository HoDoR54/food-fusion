<?php

namespace Database\Seeders;

use App\Models\RecipeAttempt;
use App\Models\Recipe;
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
        $users = User::whereHas('role', function($query) {
            $query->where('name', 'User');
        })->get();

        if ($recipes->isEmpty() || $users->isEmpty()) {
            $this->command->warn('No recipes or users found. Please run RecipesSeeder and UserSeeder first.');
            return;
        }

        // Sample recipe attempts data
        $attempts = [
            [
                'image_url' => 'https://example.com/attempt1.jpg',
                'notes' => 'First time making this! Turned out pretty good but I think I overcooked the chicken a bit. Will try again soon.',
            ],
            [
                'image_url' => 'https://example.com/attempt2.jpg',
                'notes' => 'Amazing recipe! My family loved it. Added extra vegetables and it was perfect.',
            ],
            [
                'image_url' => 'https://example.com/attempt3.jpg',
                'notes' => 'The flavors were incredible. I substituted quinoa for rice and it worked great!',
            ],
            [
                'image_url' => 'https://example.com/attempt4.jpg',
                'notes' => 'Quick and easy weeknight dinner. Kids ate everything on their plates!',
            ],
            [
                'image_url' => 'https://example.com/attempt5.jpg',
                'notes' => 'This was my second attempt and it came out much better. Practice makes perfect!',
            ],
            [
                'image_url' => 'https://example.com/attempt6.jpg',
                'notes' => 'Made this for date night. Absolutely delicious! Will definitely make again.',
            ],
            [
                'image_url' => 'https://example.com/attempt7.jpg',
                'notes' => 'Healthy and tasty! I love how colorful this dish is. Great for meal prep too.',
            ],
            [
                'image_url' => 'https://example.com/attempt8.jpg',
                'notes' => 'The spice level was perfect for me, but next time I might add more vegetables.',
            ],
            [
                'image_url' => 'https://example.com/attempt9.jpg',
                'notes' => 'Comfort food at its finest! This reminded me of my grandmother\'s cooking.',
            ],
            [
                'image_url' => 'https://example.com/attempt10.jpg',
                'notes' => 'Light and refreshing summer meal. Perfect for hot days when you don\'t want heavy food.',
            ],
            [
                'image_url' => 'https://example.com/attempt11.jpg',
                'notes' => 'The curry was absolutely delicious! I made it less spicy for the kids and they loved it too.',
            ],
            [
                'image_url' => 'https://example.com/attempt12.jpg',
                'notes' => 'Great protein bowl! I meal prepped this for the week and it stayed fresh.',
            ],
            [
                'image_url' => 'https://example.com/attempt13.jpg',
                'notes' => 'The honey glaze was incredible. The salmon was perfectly cooked and flaky.',
            ],
            [
                'image_url' => 'https://example.com/attempt14.jpg',
                'notes' => 'Classic recipe done right. The dressing was creamy and flavorful.',
            ],
            [
                'image_url' => 'https://example.com/attempt15.jpg',
                'notes' => 'These tacos were so fresh and healthy. Great alternative to traditional beef tacos.',
            ],
            [
                'image_url' => 'https://example.com/attempt16.jpg',
                'notes' => 'Baking cookies with the kids was so much fun! They turned out crispy and chewy.',
            ],
            [
                'image_url' => 'https://example.com/attempt17.jpg',
                'notes' => 'Love these lettuce wraps! So light and flavorful, perfect for a healthy lunch.',
            ],
            [
                'image_url' => 'https://example.com/attempt18.jpg',
                'notes' => 'The risotto was creamy and rich. Took some patience but totally worth it!',
            ],
            [
                'image_url' => 'https://example.com/attempt19.jpg',
                'notes' => 'Mediterranean flavors are my favorite! This bowl was fresh and satisfying.',
            ],
            [
                'image_url' => 'https://example.com/attempt20.jpg',
                'notes' => 'Perfect weekend breakfast! The kids loved helping flip the pancakes.',
            ],
            [
                'image_url' => 'https://example.com/attempt21.jpg',
                'notes' => 'Quick stir fry for busy weeknight. Everything cooked perfectly in the wok.',
            ],
            [
                'image_url' => 'https://example.com/attempt22.jpg',
                'notes' => 'Simple but elegant. Perfect appetizer for dinner party guests.',
            ],
            [
                'image_url' => 'https://example.com/attempt23.jpg',
                'notes' => 'The whole house smelled amazing while this was roasting. Herb flavors were perfect.',
            ],
            [
                'image_url' => 'https://example.com/attempt24.jpg',
                'notes' => 'Restaurant quality at home! The garlic wine sauce was incredible.',
            ],
            [
                'image_url' => 'https://example.com/attempt25.jpg',
                'notes' => 'Warming and comforting curry. The spices made the kitchen smell like heaven.',
            ],
            [
                'image_url' => 'https://example.com/attempt26.jpg',
                'notes' => 'BBQ pulled pork was tender and flavorful. Great for feeding a crowd!',
            ],
            [
                'image_url' => 'https://example.com/attempt27.jpg',
                'notes' => 'Perfect make-ahead breakfast! Love having this ready in the morning.',
            ],
            [
                'image_url' => 'https://example.com/attempt28.jpg',
                'notes' => 'Fish tacos with a healthy twist! The slaw added perfect crunch.',
            ],
            [
                'image_url' => 'https://example.com/attempt29.jpg',
                'notes' => 'Stuffed peppers were colorful and nutritious. Kids thought they were fun to eat!',
            ],
            [
                'image_url' => 'https://example.com/attempt30.jpg',
                'notes' => 'Nothing beats homemade chicken soup when you\'re feeling under the weather.',
            ],
            [
                'image_url' => 'https://example.com/attempt31.jpg',
                'notes' => 'Decadent dessert for special occasion. The molten center was perfect!',
            ],
            [
                'image_url' => 'https://example.com/attempt32.jpg',
                'notes' => 'Made this for my vegetarian friends and they absolutely loved it!',
            ],
            [
                'image_url' => 'https://example.com/attempt33.jpg',
                'notes' => 'Second time making this curry - getting better each time! Added extra coconut milk.',
            ],
            [
                'image_url' => 'https://example.com/attempt34.jpg',
                'notes' => 'Perfect summer salad! Light, fresh, and exactly what I needed on a hot day.',
            ],
            [
                'image_url' => 'https://example.com/attempt35.jpg',
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
