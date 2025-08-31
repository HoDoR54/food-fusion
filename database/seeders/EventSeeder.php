<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Enums\EventStatus;
use App\Enums\EventType;
use App\Enums\VenueType;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizer = User::first() ?? User::factory()->create();
        $now = Carbon::now();
        $defaultImg = 'https://res.cloudinary.com/dybgsw0ej/image/upload/v1756623487/5_s618dl.jpg';

        $events = [
            // Past events
            [
                'name'       => 'Urban Gardening 101',
                'description'=> 'Learn how to grow your own vegetables in small urban spaces.',
                'start_time' => $now->copy()->subDays(12)->setHour(17),
                'end_time'   => $now->copy()->subDays(12)->setHour(19),
                'status'     => EventStatus::COMPLETED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::ONLINE,
                'platform'   => 'Zoom',
                'location'   => null,
            ],
            [
                'name'       => 'Sustainable Cooking Workshop',
                'description'=> 'Hands-on session using locally-sourced, eco-friendly ingredients.',
                'start_time' => $now->copy()->subDays(10)->setHour(15),
                'end_time'   => $now->copy()->subDays(10)->setHour(18),
                'status'     => EventStatus::COMPLETED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::OFFLINE,
                'platform'   => null,
                'location'   => 'Green Kitchen Studio, Yangon',
            ],
            [
                'name'       => 'Food Waste Reduction Talk',
                'description'=> 'Learn practical ways to reduce food waste at home.',
                'start_time' => $now->copy()->subDays(8)->setHour(18),
                'end_time'   => $now->copy()->subDays(8)->setHour(20),
                'status'     => EventStatus::COMPLETED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::ONLINE,
                'platform'   => 'Google Meet',
                'location'   => null,
            ],
            [
                'name'       => 'Farm-to-Table Cooking Class',
                'description'=> 'Cook meals directly from fresh farm ingredients.',
                'start_time' => $now->copy()->subDays(6)->setHour(14),
                'end_time'   => $now->copy()->subDays(6)->setHour(17),
                'status'     => EventStatus::COMPLETED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::OFFLINE,
                'platform'   => null,
                'location'   => 'Yangon Culinary Center',
            ],
            [
                'name'       => 'Zero-Waste Meal Prep',
                'description'=> 'Learn to plan meals without generating waste.',
                'start_time' => $now->copy()->subDays(4)->setHour(16),
                'end_time'   => $now->copy()->subDays(4)->setHour(18),
                'status'     => EventStatus::COMPLETED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::ONLINE,
                'platform'   => 'Discord',
                'location'   => null,
            ],
            [
                'name'       => 'Local Farmers Meetup',
                'description'=> 'Connect with local farmers and food artisans.',
                'start_time' => $now->copy()->subDays(3)->setHour(17),
                'end_time'   => $now->copy()->subDays(3)->setHour(20),
                'status'     => EventStatus::COMPLETED,
                'type'       => EventType::GATHERING,
                'venue_type' => VenueType::OFFLINE,
                'platform'   => null,
                'location'   => 'Yangon Community Garden',
            ],
            [
                'name'       => 'Sustainable Food Expo',
                'description'=> 'Explore eco-friendly food products and practices.',
                'start_time' => $now->copy()->subDays(2)->setHour(10),
                'end_time'   => $now->copy()->subDays(2)->setHour(18),
                'status'     => EventStatus::COMPLETED,
                'type'       => EventType::GATHERING,
                'venue_type' => VenueType::OFFLINE,
                'platform'   => null,
                'location'   => 'Yangon Exhibition Center',
            ],
            [
                'name'       => 'Cooking with Foraged Ingredients',
                'description'=> 'Learn to identify and cook with edible local plants.',
                'start_time' => $now->copy()->subDays(1)->setHour(13),
                'end_time'   => $now->copy()->subDays(1)->setHour(16),
                'status'     => EventStatus::COMPLETED,
                'type'       => EventType::GATHERING,
                'venue_type' => VenueType::OFFLINE,
                'platform'   => null,
                'location'   => 'Yangon Botanical Garden',
            ],

            // Upcoming events
            [
                'name'       => 'Eco-Friendly Catering Meetup',
                'description'=> 'Networking for chefs and caterers using sustainable methods.',
                'start_time' => $now->copy()->addDays(2)->setHour(15),
                'end_time'   => $now->copy()->addDays(2)->setHour(18),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::GATHERING,
                'venue_type' => VenueType::OFFLINE,
                'platform'   => null,
                'location'   => 'Yangon Culinary Hub',
            ],
            [
                'name'       => 'Community Clean-Up Drive',
                'description'=> 'Volunteer to clean local parks and promote sustainability.',
                'start_time' => $now->copy()->addDays(4)->setHour(8),
                'end_time'   => $now->copy()->addDays(4)->setHour(12),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::GATHERING,
                'venue_type' => VenueType::OFFLINE,
                'platform'   => null,
                'location'   => 'Inya Lake Park, Yangon',
            ],
            [
                'name'       => 'Farmers Market Social',
                'description'=> 'Casual gathering at a local farmers market to promote sustainable products.',
                'start_time' => $now->copy()->addDays(6)->setHour(9),
                'end_time'   => $now->copy()->addDays(6)->setHour(12),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::GATHERING,
                'venue_type' => VenueType::OFFLINE,
                'platform'   => null,
                'location'   => 'Downtown Yangon Market',
            ],
            [
                'name'       => 'Eco-Chef Challenge',
                'description'=> 'Compete using sustainable cooking methods and ingredients.',
                'start_time' => $now->copy()->addDays(8)->setHour(13),
                'end_time'   => $now->copy()->addDays(8)->setHour(17),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::GATHERING,
                'venue_type' => VenueType::OFFLINE,
                'platform'   => null,
                'location'   => 'Yangon Culinary Arena',
            ],
            [
                'name'       => 'Food Sustainability Panel',
                'description'=> 'Experts discuss sustainable food practices for homes and restaurants.',
                'start_time' => $now->copy()->addDays(10)->setHour(16),
                'end_time'   => $now->copy()->addDays(10)->setHour(18),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::ONLINE,
                'platform'   => 'Zoom',
                'location'   => null,
            ],
            [
                'name'       => 'Community Compost Workshop',
                'description'=> 'Learn how to compost kitchen waste to enrich community gardens.',
                'start_time' => $now->copy()->addDays(12)->setHour(10),
                'end_time'   => $now->copy()->addDays(12)->setHour(13),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::OFFLINE,
                'platform'   => null,
                'location'   => 'Yangon Community Garden',
            ],
            [
                'name'       => 'Herbal Cooking Workshop',
                'description'=> 'Discover how to use herbs from your garden in everyday cooking.',
                'start_time' => $now->copy()->addDays(14)->setHour(15),
                'end_time'   => $now->copy()->addDays(14)->setHour(17),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::ONLINE,
                'platform'   => 'Zoom',
                'location'   => null,
            ],
            [
                'name'       => 'Composting for Beginners',
                'description'=> 'Learn the basics of composting and reducing household waste.',
                'start_time' => $now->copy()->addDays(15)->setHour(16),
                'end_time'   => $now->copy()->addDays(15)->setHour(18),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::ONLINE,
                'platform'   => 'Google Meet',
                'location'   => null,
            ],
            [
                'name'       => 'Fermentation Basics',
                'description'=> 'Hands-on session making fermented foods like kimchi and yogurt.',
                'start_time' => $now->copy()->addDays(16)->setHour(14),
                'end_time'   => $now->copy()->addDays(16)->setHour(17),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::OFFLINE,
                'platform'   => null,
                'location'   => 'Yangon Culinary Lab',
            ],
            [
                'name'       => 'Seasonal Cooking Techniques',
                'description'=> 'Learn to cook using seasonal ingredients to reduce waste.',
                'start_time' => $now->copy()->addDays(17)->setHour(15),
                'end_time'   => $now->copy()->addDays(17)->setHour(18),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::ONLINE,
                'platform'   => 'Discord',
                'location'   => null,
            ],
            [
                'name'       => 'Eco-Friendly Baking',
                'description'=> 'Techniques for baking with minimal environmental impact.',
                'start_time' => $now->copy()->addDays(18)->setHour(14),
                'end_time'   => $now->copy()->addDays(18)->setHour(17),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::OFFLINE,
                'platform'   => null,
                'location'   => 'Yangon Bakery Studio',
            ],
            [
                'name'       => 'Plant-Based Meal Prep',
                'description'=> 'Learn to plan nutritious plant-based meals efficiently.',
                'start_time' => $now->copy()->addDays(19)->setHour(16),
                'end_time'   => $now->copy()->addDays(19)->setHour(19),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::ONLINE,
                'platform'   => 'Zoom',
                'location'   => null,
            ]
        ];

        foreach ($events as $event) {
            Event::create(array_merge(
                $event,
                [
                    'id' => (string) Str::uuid(),
                    'organizer_id' => $organizer->id,
                    'image_url' => $defaultImg
                ]
            ));
        }
    }
}
