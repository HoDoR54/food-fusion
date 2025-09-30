<?php

namespace Database\Seeders;

use App\Enums\MasteryLevel;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles
        $adminRole = Role::where('name', 'Admin')->first();
        $moderatorRole = Role::where('name', 'Moderator')->first();
        $userRole = Role::where('name', 'User')->first();

        // Create the specific admin user
        User::firstOrCreate(
            ['email' => 'admin@foodfusion.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'username' => 'FoodFusionAdmin',
                'email' => 'admin@foodfusion.com',
                'phone' => '+1234567890',
                'mastery_level' => MasteryLevel::BEGINNER,
                'password' => Hash::make(env('ADMIN_PASSWORD')),
                'role_id' => $adminRole->id,
                'email_verified_at' => now(),
            ]
        );

        // Create two moderators
        User::firstOrCreate(
            ['email' => 'moderator1@foodfusion.com'],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'username' => 'SarahMod',
                'email' => 'moderator1@foodfusion.com',
                'phone' => '+1234567891',
                'mastery_level' => MasteryLevel::INTERMEDIATE,
                'password' => Hash::make('password123'),
                'role_id' => $moderatorRole->id,
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'moderator2@foodfusion.com'],
            [
                'first_name' => 'Michael',
                'last_name' => 'Chen',
                'username' => 'MikeMod',
                'email' => 'moderator2@foodfusion.com',
                'phone' => '+1234567892',
                'mastery_level' => MasteryLevel::ADVANCED,
                'password' => Hash::make('password123'),
                'role_id' => $moderatorRole->id,
                'email_verified_at' => now(),
            ]
        );

        // Create test users with varying mastery levels
        $testUsers = [
            [
                'first_name' => 'Emma',
                'last_name' => 'Davis',
                'username' => 'EmmaCooks',
                'email' => 'emma@example.com',
                'phone' => '+1234567893',
                'mastery_level' => MasteryLevel::BEGINNER,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
            [
                'first_name' => 'James',
                'last_name' => 'Wilson',
                'username' => 'ChefJames',
                'email' => 'james@example.com',
                'phone' => '+1234567894',
                'mastery_level' => MasteryLevel::ADVANCED,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
            [
                'first_name' => 'Lisa',
                'last_name' => 'Martinez',
                'username' => 'LisaKitchen',
                'email' => 'lisa@example.com',
                'phone' => '+1234567895',
                'mastery_level' => MasteryLevel::INTERMEDIATE,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Brown',
                'username' => 'DavidBakes',
                'email' => 'david@example.com',
                'phone' => '+1234567896',
                'mastery_level' => MasteryLevel::BEGINNER,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
            [
                'first_name' => 'Sophia',
                'last_name' => 'Garcia',
                'username' => 'SophiaSpices',
                'email' => 'sophia@example.com',
                'phone' => '+1234567897',
                'mastery_level' => MasteryLevel::ADVANCED,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
            [
                'first_name' => 'Ryan',
                'last_name' => 'Taylor',
                'username' => 'RyanGrills',
                'email' => 'ryan@example.com',
                'phone' => '+1234567898',
                'mastery_level' => MasteryLevel::INTERMEDIATE,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
            [
                'first_name' => 'Isabella',
                'last_name' => 'Rodriguez',
                'username' => 'IsabellaEats',
                'email' => 'isabella@example.com',
                'phone' => '+1234567899',
                'mastery_level' => MasteryLevel::BEGINNER,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
            [
                'first_name' => 'Alexander',
                'last_name' => 'Kim',
                'username' => 'AlexCooks',
                'email' => 'alex@example.com',
                'phone' => '+1234567900',
                'mastery_level' => MasteryLevel::ADVANCED,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
            [
                'first_name' => 'Mia',
                'last_name' => 'Thompson',
                'username' => 'MiaFlavors',
                'email' => 'mia@example.com',
                'phone' => '+1234567901',
                'mastery_level' => MasteryLevel::INTERMEDIATE,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
            [
                'first_name' => 'Oliver',
                'last_name' => 'Anderson',
                'username' => 'OliverChef',
                'email' => 'oliver@example.com',
                'phone' => '+1234567902',
                'mastery_level' => MasteryLevel::ADVANCED,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
            [
                'first_name' => 'Charlotte',
                'last_name' => 'Lee',
                'username' => 'CharBakes',
                'email' => 'charlotte@example.com',
                'phone' => '+1234567903',
                'mastery_level' => MasteryLevel::INTERMEDIATE,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
            [
                'first_name' => 'Ethan',
                'last_name' => 'White',
                'username' => 'EthanGourmet',
                'email' => 'ethan@example.com',
                'phone' => '+1234567904',
                'mastery_level' => MasteryLevel::BEGINNER,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
            [
                'first_name' => 'Amelia',
                'last_name' => 'Miller',
                'username' => 'AmeliaCuisine',
                'email' => 'amelia@example.com',
                'phone' => '+1234567905',
                'mastery_level' => MasteryLevel::ADVANCED,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
            [
                'first_name' => 'Lucas',
                'last_name' => 'Davis',
                'username' => 'LucasKitchen',
                'email' => 'lucas@example.com',
                'phone' => '+1234567906',
                'mastery_level' => MasteryLevel::INTERMEDIATE,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
            [
                'first_name' => 'Harper',
                'last_name' => 'Clark',
                'username' => 'HarperCooks',
                'email' => 'harper@example.com',
                'phone' => '+1234567907',
                'mastery_level' => MasteryLevel::BEGINNER,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
            [
                'first_name' => 'Benjamin',
                'last_name' => 'Moore',
                'username' => 'BenChef',
                'email' => 'benjamin@example.com',
                'phone' => '+1234567908',
                'mastery_level' => MasteryLevel::ADVANCED,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
            [
                'first_name' => 'Evelyn',
                'last_name' => 'Jackson',
                'username' => 'EvelynTastes',
                'email' => 'evelyn@example.com',
                'phone' => '+1234567909',
                'mastery_level' => MasteryLevel::INTERMEDIATE,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
            [
                'first_name' => 'Mason',
                'last_name' => 'Martin',
                'username' => 'MasonMeals',
                'email' => 'mason@example.com',
                'phone' => '+1234567910',
                'mastery_level' => MasteryLevel::BEGINNER,
                'password' => Hash::make('password123'),
                'role_id' => $userRole->id,
            ],
        ];

        foreach ($testUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                array_merge($userData, ['email_verified_at' => now()])
            );
        }

        $this->command->info('Users seeded successfully!');
    }
}
