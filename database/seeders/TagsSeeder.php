<?php

namespace Database\Seeders;

use App\Enums\TagType;
use App\Models\Tag;
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
            ['name' => 'French', 'type' => TagType::Origin],
            ['name' => 'Chinese', 'type' => TagType::Origin],
            ['name' => 'Japanese', 'type' => TagType::Origin],
            ['name' => 'Korean', 'type' => TagType::Origin],
            ['name' => 'Greek', 'type' => TagType::Origin],
            ['name' => 'Spanish', 'type' => TagType::Origin],
            ['name' => 'Middle Eastern', 'type' => TagType::Origin],
            ['name' => 'British', 'type' => TagType::Origin],

            // Dietary tags
            ['name' => 'Vegetarian', 'type' => TagType::Dietary],
            ['name' => 'Vegan', 'type' => TagType::Dietary],
            ['name' => 'Healthy', 'type' => TagType::Dietary],
            ['name' => 'Low Carb', 'type' => TagType::Dietary],
            ['name' => 'Gluten Free', 'type' => TagType::Dietary],
            ['name' => 'Dairy Free', 'type' => TagType::Dietary],
            ['name' => 'Keto', 'type' => TagType::Dietary],
            ['name' => 'Paleo', 'type' => TagType::Dietary],
            ['name' => 'High Protein', 'type' => TagType::Dietary],

            // Course tags
            ['name' => 'Breakfast', 'type' => TagType::Course],
            ['name' => 'Lunch', 'type' => TagType::Course],
            ['name' => 'Dinner', 'type' => TagType::Course],
            ['name' => 'Dessert', 'type' => TagType::Course],
            ['name' => 'Appetizer', 'type' => TagType::Course],
            ['name' => 'Snack', 'type' => TagType::Course],
            ['name' => 'Side Dish', 'type' => TagType::Course],
            ['name' => 'Soup', 'type' => TagType::Course],
            ['name' => 'Salad', 'type' => TagType::Course],

            // Cooking Method tags
            ['name' => 'Grilled', 'type' => TagType::CookingMethod],
            ['name' => 'Baked', 'type' => TagType::CookingMethod],
            ['name' => 'Sautéed', 'type' => TagType::CookingMethod],
            ['name' => 'No-Cook', 'type' => TagType::CookingMethod],
            ['name' => 'Roasted', 'type' => TagType::CookingMethod],
            ['name' => 'Fried', 'type' => TagType::CookingMethod],
            ['name' => 'Steamed', 'type' => TagType::CookingMethod],
            ['name' => 'Slow Cooked', 'type' => TagType::CookingMethod],
            ['name' => 'Pan Seared', 'type' => TagType::CookingMethod],

            // Occasion tags
            ['name' => 'Holiday', 'type' => TagType::Occasion],
            ['name' => 'Date Night', 'type' => TagType::Occasion],
            ['name' => 'Family Dinner', 'type' => TagType::Occasion],
            ['name' => 'Quick & Easy', 'type' => TagType::Occasion],
            ['name' => 'Weekend Special', 'type' => TagType::Occasion],
            ['name' => 'Comfort Food', 'type' => TagType::Occasion],
            ['name' => 'Summer', 'type' => TagType::Occasion],
            ['name' => 'Winter', 'type' => TagType::Occasion],
            ['name' => 'Party Food', 'type' => TagType::Occasion],
            ['name' => 'Kids Friendly', 'type' => TagType::Occasion],
            ['name' => 'Romantic', 'type' => TagType::Occasion],
            ['name' => 'Meal Prep', 'type' => TagType::Occasion],
            ['name' => 'One Pot', 'type' => TagType::Occasion],
            ['name' => 'Budget Friendly', 'type' => TagType::Occasion],
            ['name' => 'Spicy', 'type' => TagType::Occasion],
            ['name' => 'Sweet', 'type' => TagType::Occasion],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
