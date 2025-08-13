<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Enums\TagType;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            // Origin tags
            ['name' => 'Italian', 'type' => TagType::Origin],
            ['name' => 'Mexican', 'type' => TagType::Origin],
            ['name' => 'Asian', 'type' => TagType::Origin],
            ['name' => 'American', 'type' => TagType::Origin],
            ['name' => 'Indian', 'type' => TagType::Origin],
            ['name' => 'Mediterranean', 'type' => TagType::Origin],
            ['name' => 'Thai', 'type' => TagType::Origin],
            
            // Dietary tags
            ['name' => 'Vegetarian', 'type' => TagType::Dietary],
            ['name' => 'Vegan', 'type' => TagType::Dietary],
            ['name' => 'Healthy', 'type' => TagType::Dietary],
            
            // Course tags
            ['name' => 'Breakfast', 'type' => TagType::Course],
            ['name' => 'Lunch', 'type' => TagType::Course],
            ['name' => 'Dinner', 'type' => TagType::Course],
            ['name' => 'Dessert', 'type' => TagType::Course],
            
            // Cooking Method tags
            ['name' => 'Grilled', 'type' => TagType::CookingMethod],
            ['name' => 'Baked', 'type' => TagType::CookingMethod],
            ['name' => 'Sautéed', 'type' => TagType::CookingMethod],
            ['name' => 'No-Cook', 'type' => TagType::CookingMethod],
            
            // Occasion tags
            ['name' => 'Holiday', 'type' => TagType::Occasion],
            ['name' => 'Date Night', 'type' => TagType::Occasion],
            ['name' => 'Family Dinner', 'type' => TagType::Occasion],
            ['name' => 'Quick & Easy', 'type' => TagType::Occasion],
            ['name' => 'Weekend Special', 'type' => TagType::Occasion],
            ['name' => 'Comfort Food', 'type' => TagType::Occasion],
            ['name' => 'Summer', 'type' => TagType::Occasion],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
