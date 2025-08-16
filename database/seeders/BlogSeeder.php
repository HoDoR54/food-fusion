<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users to be blog authors
        $users = User::limit(6)->get();
        $tags = Tag::where('type', 'blog')->get();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        $blogs = [
            [
                'title' => '10 Essential Kitchen Tools for Beginners',
                'content' => 'Starting your culinary journey? Here are the must-have tools that will make cooking easier and more enjoyable. From sharp knives to quality cutting boards, these essentials will set you up for success in the kitchen.',
                'author_id' => $users->first()->id,
            ],
            [
                'title' => 'The Art of Meal Prep: Save Time and Eat Better',
                'content' => 'Meal prepping is a game-changer for busy lifestyles. Learn how to plan, prep, and store meals for the week ahead. This comprehensive guide covers everything from choosing the right containers to batch cooking techniques.',
                'author_id' => $users->skip(1)->first()->id,
            ],
            [
                'title' => 'Spice Up Your Life: A Guide to International Flavors',
                'content' => 'Explore the world through spices and seasonings. From warming Indian garam masala to fragrant Moroccan ras el hanout, discover how different cultures use spices to create extraordinary flavors.',
                'author_id' => $users->skip(2)->first()->id,
            ],
            [
                'title' => 'Farm to Table: The Benefits of Seasonal Cooking',
                'content' => 'Cooking with seasonal ingredients not only tastes better but also supports local farmers and reduces environmental impact. Learn how to shop seasonally and create delicious meals with fresh, local produce.',
                'author_id' => $users->skip(3)->first()->id,
            ],
            [
                'title' => 'Mastering the Basics: Perfect Pasta Every Time',
                'content' => 'Pasta seems simple, but there are many ways to elevate this humble dish. From choosing the right pasta shape to creating the perfect sauce, learn the secrets to restaurant-quality pasta at home.',
                'author_id' => $users->skip(4)->first()->id,
            ],
            [
                'title' => 'Healthy Comfort Foods: Guilt-Free Indulgence',
                'content' => 'Who says comfort food can\'t be healthy? Discover how to recreate your favorite comfort dishes with nutritious ingredients and cooking methods that don\'t compromise on flavor.',
                'author_id' => $users->skip(5)->first()->id ?? $users->first()->id,
            ],
        ];

        foreach ($blogs as $blogData) {
            $blog = Blog::firstOrCreate(
                ['title' => $blogData['title']],
                $blogData
            );

            // Attach random tags if available
            if ($tags->isNotEmpty() && $blog->wasRecentlyCreated) {
                $randomTags = $tags->random(min(3, $tags->count()));
                $blog->tags()->attach($randomTags);
            }
        }

        $this->command->info('Blogs seeded successfully!');
    }
}
