<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            // Proteins
            ['name' => 'Chicken Breast', 'description' => 'Boneless, skinless chicken breast'],
            ['name' => 'Ground Beef', 'description' => '80/20 lean ground beef'],
            ['name' => 'Ground Turkey', 'description' => '93/7 lean ground turkey'],
            ['name' => 'Salmon Fillet', 'description' => 'Fresh salmon fillet'],
            ['name' => 'White Fish Fillet', 'description' => 'Cod or halibut fillet'],
            ['name' => 'Large Shrimp', 'description' => 'Peeled and deveined shrimp'],
            ['name' => 'Chicken Thighs', 'description' => 'Bone-in chicken thighs'],
            ['name' => 'Pork Tenderloin', 'description' => 'Lean pork tenderloin'],
            ['name' => 'Anchovy Fillets', 'description' => 'Oil-packed anchovy fillets'],

            // Dairy & Eggs
            ['name' => 'Eggs', 'description' => 'Large fresh eggs'],
            ['name' => 'Whole Milk', 'description' => 'Fresh whole milk'],
            ['name' => 'Heavy Cream', 'description' => 'Heavy whipping cream'],
            ['name' => 'Unsalted Butter', 'description' => 'Fresh unsalted butter'],
            ['name' => 'Fresh Mozzarella', 'description' => 'Fresh mozzarella cheese'],
            ['name' => 'Cheddar Cheese', 'description' => 'Shredded cheddar cheese'],
            ['name' => 'Feta Cheese', 'description' => 'Crumbled feta cheese'],
            ['name' => 'Parmesan Cheese', 'description' => 'Grated Parmesan cheese'],
            ['name' => 'Ricotta Cheese', 'description' => 'Fresh ricotta cheese'],
            ['name' => 'Goat Cheese', 'description' => 'Soft goat cheese'],
            ['name' => 'Greek Yogurt', 'description' => 'Plain Greek yogurt'],
            ['name' => 'Sour Cream', 'description' => 'Fresh sour cream'],

            // Vegetables
            ['name' => 'Tomatoes', 'description' => 'Fresh ripe tomatoes'],
            ['name' => 'Yellow Onion', 'description' => 'Medium yellow onion'],
            ['name' => 'Red Onion', 'description' => 'Small red onion'],
            ['name' => 'Garlic', 'description' => 'Fresh garlic cloves'],
            ['name' => 'Bell Peppers', 'description' => 'Mixed colored bell peppers'],
            ['name' => 'Carrots', 'description' => 'Medium carrots'],
            ['name' => 'Broccoli', 'description' => 'Fresh broccoli head'],
            ['name' => 'Button Mushrooms', 'description' => 'Fresh button mushrooms'],
            ['name' => 'Baby Spinach', 'description' => 'Fresh baby spinach leaves'],
            ['name' => 'Russet Potatoes', 'description' => 'Large russet potatoes'],
            ['name' => 'Sweet Potatoes', 'description' => 'Orange sweet potatoes'],
            ['name' => 'Asparagus', 'description' => 'Fresh asparagus spears'],
            ['name' => 'Cabbage', 'description' => 'Fresh head cabbage'],
            ['name' => 'Cucumber', 'description' => 'English cucumber'],
            ['name' => 'Romaine Lettuce', 'description' => 'Fresh romaine lettuce head'],
            ['name' => 'Arugula', 'description' => 'Fresh arugula leaves'],
            ['name' => 'Zucchini', 'description' => 'Medium zucchini'],
            ['name' => 'Eggplant', 'description' => 'Large eggplant'],
            ['name' => 'Fennel Bulb', 'description' => 'Large fresh fennel bulb'],
            ['name' => 'Leeks', 'description' => 'Fresh leeks, white and light green parts'],
            ['name' => 'Green Onions', 'description' => 'Fresh green onions/scallions'],
            ['name' => 'Avocados', 'description' => 'Ripe avocados'],
            ['name' => 'Jalapeño Peppers', 'description' => 'Fresh jalapeño peppers'],
            ['name' => 'Thai Chilies', 'description' => 'Fresh Thai chilies'],

            // Herbs & Aromatics
            ['name' => 'Fresh Basil', 'description' => 'Fresh basil leaves'],
            ['name' => 'Fresh Parsley', 'description' => 'Fresh parsley'],
            ['name' => 'Fresh Cilantro', 'description' => 'Fresh cilantro'],
            ['name' => 'Fresh Ginger', 'description' => 'Fresh ginger root'],
            ['name' => 'Fresh Rosemary', 'description' => 'Fresh rosemary sprigs'],
            ['name' => 'Fresh Thyme', 'description' => 'Fresh thyme leaves'],

            // Grains & Starches
            ['name' => 'Pasta', 'description' => 'Penne, fusilli, or spaghetti'],
            ['name' => 'White Rice', 'description' => 'Long grain white rice'],
            ['name' => 'Quinoa', 'description' => 'Uncooked quinoa'],
            ['name' => 'All-Purpose Flour', 'description' => 'All-purpose flour'],
            ['name' => 'Rice Noodles', 'description' => 'Rice noodles or egg noodles'],
            ['name' => 'Rolled Oats', 'description' => 'Old-fashioned rolled oats'],
            ['name' => 'Tortillas', 'description' => 'Corn or flour tortillas'],

            // Pantry Staples
            ['name' => 'Extra Virgin Olive Oil', 'description' => 'Premium extra virgin olive oil'],
            ['name' => 'Sesame Oil', 'description' => 'Toasted sesame oil'],
            ['name' => 'Coconut Oil', 'description' => 'Virgin coconut oil'],
            ['name' => 'Sea Salt', 'description' => 'Fine sea salt'],
            ['name' => 'Black Pepper', 'description' => 'Freshly ground black pepper'],
            ['name' => 'Soy Sauce', 'description' => 'Light soy sauce'],
            ['name' => 'Baking Powder', 'description' => 'Double-acting baking powder'],
            ['name' => 'Baking Soda', 'description' => 'Pure baking soda'],
            ['name' => 'Granulated Sugar', 'description' => 'White granulated sugar'],
            ['name' => 'Brown Sugar', 'description' => 'Packed light brown sugar'],
            ['name' => 'Vanilla Extract', 'description' => 'Pure vanilla extract'],
            ['name' => 'Honey', 'description' => 'Raw honey'],
            ['name' => 'Maple Syrup', 'description' => 'Pure maple syrup'],

            // Spices
            ['name' => 'Paprika', 'description' => 'Sweet paprika'],
            ['name' => 'Ground Cumin', 'description' => 'Ground cumin'],
            ['name' => 'Ground Cinnamon', 'description' => 'Ground cinnamon'],
            ['name' => 'Dried Oregano', 'description' => 'Dried oregano'],
            ['name' => 'Ground Cardamom', 'description' => 'Ground cardamom'],
            ['name' => 'Ground Turmeric', 'description' => 'Ground turmeric'],
            ['name' => 'Garam Masala', 'description' => 'Garam masala spice blend'],
            ['name' => 'Bay Leaves', 'description' => 'Dried bay leaves'],

            // Citrus & Acids
            ['name' => 'Lemons', 'description' => 'Fresh lemons'],
            ['name' => 'Limes', 'description' => 'Fresh limes'],
            ['name' => 'Balsamic Vinegar', 'description' => 'Aged balsamic vinegar'],
            ['name' => 'Rice Wine Vinegar', 'description' => 'Rice wine vinegar'],

            // Canned/Packaged
            ['name' => 'Coconut Milk', 'description' => 'Canned coconut milk'],
            ['name' => 'Vegetable Broth', 'description' => 'Low-sodium vegetable broth'],
            ['name' => 'Black Beans', 'description' => 'Canned black beans, drained and rinsed'],
            ['name' => 'Dried Lentils', 'description' => 'Dried lentils'],
            ['name' => 'Sun-Dried Tomatoes', 'description' => 'Oil-packed sun-dried tomatoes'],

            // Nuts & Seeds
            ['name' => 'Pine Nuts', 'description' => 'Toasted pine nuts'],
            ['name' => 'Sliced Almonds', 'description' => 'Sliced almonds'],
            ['name' => 'Chopped Walnuts', 'description' => 'Chopped walnuts'],
            ['name' => 'Chopped Pecans', 'description' => 'Chopped pecans'],
            ['name' => 'Peanut Butter', 'description' => 'Natural peanut butter'],
            ['name' => 'Chia Seeds', 'description' => 'Chia seeds'],

            // Fruits
            ['name' => 'Bananas', 'description' => 'Ripe bananas'],
            ['name' => 'Fresh Blueberries', 'description' => 'Fresh blueberries'],
            ['name' => 'Fresh Strawberries', 'description' => 'Fresh strawberries'],
            ['name' => 'Granny Smith Apples', 'description' => 'Granny Smith apples'],

            // Other
            ['name' => 'Chocolate Chips', 'description' => 'Semi-sweet chocolate chips'],
            ['name' => 'Kalamata Olives', 'description' => 'Pitted kalamata olives'],
            ['name' => 'Capers', 'description' => 'Brined capers'],
            ['name' => 'Dijon Mustard', 'description' => 'Dijon mustard'],
            ['name' => 'Worcestershire Sauce', 'description' => 'Worcestershire sauce'],
            ['name' => 'Mayonnaise', 'description' => 'Mayonnaise'],
            ['name' => 'Croutons', 'description' => 'Seasoned croutons'],
            ['name' => 'Dried Cranberries', 'description' => 'Dried cranberries'],
            ['name' => 'Sweet Corn', 'description' => 'Fresh or frozen corn kernels'],
            ['name' => 'White Wine', 'description' => 'Dry white wine'],
            ['name' => 'Red Wine', 'description' => 'Dry red wine'],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}
