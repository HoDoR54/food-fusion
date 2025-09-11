<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user to create votes with
        $user = User::first();

        if (! $user) {
            $this->command->warn('No users found. Please run UserSeeder first.');

            return;
        }

        // Get blogs to vote on
        $blogs = Blog::take(6)->get();

        if ($blogs->isEmpty()) {
            $this->command->warn('No blogs found. Please run BlogSeeder first.');

            return;
        }

        // Clear existing votes to avoid duplicates
        Vote::truncate();

        // Create votes with different popularity scores
        $voteData = [
            // First blog gets 8 upvotes, 1 downvote = score of 7
            ['blog' => $blogs[0], 'upvotes' => 8, 'downvotes' => 1],
            // Second blog gets 5 upvotes, 0 downvotes = score of 5
            ['blog' => $blogs[1], 'upvotes' => 5, 'downvotes' => 0],
            // Third blog gets 3 upvotes, 1 downvote = score of 2
            ['blog' => $blogs[2], 'upvotes' => 3, 'downvotes' => 1],
            // Fourth blog gets 2 upvotes, 2 downvotes = score of 0
            ['blog' => $blogs[3], 'upvotes' => 2, 'downvotes' => 2],
            // Fifth blog gets 1 upvote, 3 downvotes = score of -2
            ['blog' => $blogs[4], 'upvotes' => 1, 'downvotes' => 3],
            // Sixth blog gets no votes = score of 0
            ['blog' => $blogs[5], 'upvotes' => 0, 'downvotes' => 0],
        ];

        foreach ($voteData as $data) {
            $blog = $data['blog'];
            $upvotes = $data['upvotes'];
            $downvotes = $data['downvotes'];

            // Create upvotes
            for ($i = 0; $i < $upvotes; $i++) {
                Vote::create([
                    'user_id' => $user->id,
                    'blog_id' => $blog->id,
                    'direction' => 'up',
                ]);
            }

            // Create downvotes
            for ($i = 0; $i < $downvotes; $i++) {
                Vote::create([
                    'user_id' => $user->id,
                    'blog_id' => $blog->id,
                    'direction' => 'down',
                ]);
            }
        }

        $this->command->info('Vote seeder completed successfully!');
        $this->command->info('Created votes for '.$blogs->count().' blogs.');
    }
}
