<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }

        $blogIds = [
            '0198cd86-81be-72d4-b1b1-3b9a0f007f7f',
            '0198cd86-81c4-714e-b0b0-354f9dd23dab',
            '0198cd86-81cb-716b-bc67-d0afc580ea5f',
            '0198cd86-81ce-713f-9718-f0117d4bb4f9',
            '0198cd86-81d3-711c-9054-6338ef803f95',
            '0198cd86-81d6-738d-816d-17d78961b70f',
        ];

        $sampleComments = [
            "This is such a great recipe! I tried it last weekend and it turned out amazing.",
            "Thanks for sharing this. My family loved it!",
            "I made a few modifications and it was perfect for our dinner party.",
            "Could you provide more details about the cooking time?",
            "This looks delicious! I can't wait to try it.",
            "I've been looking for a recipe like this for ages. Thank you!",
            "The instructions are very clear and easy to follow.",
            "This reminds me of my grandmother's cooking. Nostalgic!",
            "I substituted some ingredients and it still came out great.",
            "Perfect for beginners like me. Very well explained!",
            "The photos make it look so appetizing. Great work!",
            "This is now one of my go-to recipes.",
            "My kids even ate their vegetables with this recipe!",
            "The flavor combination is absolutely fantastic.",
            "I've made this three times already. It's that good!",
            "Thank you for including the nutritional information.",
            "This recipe saved my dinner party. Everyone asked for the recipe!",
            "Simple ingredients but amazing results. Love it!",
            "The preparation time mentioned is very accurate.",
            "I love how you explained each step in detail."
        ];

        foreach ($blogIds as $blogId) {
            $commentCount = rand(2, 5);
            
            for ($i = 0; $i < $commentCount; $i++) {
                Comment::create([
                    'blog_id' => $blogId,
                    'user_id' => $users->random()->id,
                    'content' => $sampleComments[array_rand($sampleComments)],
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }

        $this->command->info('Comments seeded successfully!');
    }
}
