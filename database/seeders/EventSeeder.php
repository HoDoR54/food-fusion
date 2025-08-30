<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Enums\EventStatus;
use App\Enums\EventType;
use App\Enums\VenueType;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizer = User::first() ?? User::factory()->create();
        $now = Carbon::now();

        $events = [
            [
                'name'       => 'Laravel Skill Sharing',
                'description'=> 'An event where developers share Laravel tips and tricks.',
                'start_time' => $now->copy()->addDays(3)->setHour(18),
                'end_time'   => $now->copy()->addDays(3)->setHour(20),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::ONLINE,
                'platform'   => 'Zoom',
                'location'   => null,
                'organizer'  => $organizer->id,
            ],
            [
                'name'       => 'Community Gathering',
                'description'=> 'A casual offline meetup for the local dev community.',
                'start_time' => $now->copy()->addWeeks(1)->setHour(17),
                'end_time'   => $now->copy()->addWeeks(1)->setHour(20),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::GATHERING,
                'venue_type' => VenueType::OFFLINE,
                'platform'   => null,
                'location'   => 'Yangon Tech Hub',
                'organizer'  => $organizer->id,
            ],
            [
                'name'       => 'Vue.js Workshop',
                'description'=> 'Hands-on session building apps with Vue 3.',
                'start_time' => $now->copy()->addDays(10)->setHour(14),
                'end_time'   => $now->copy()->addDays(10)->setHour(17),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::ONLINE,
                'platform'   => 'Google Meet',
                'location'   => null,
                'organizer'  => $organizer->id,
            ],
            [
                'name'       => 'Hackathon 2025',
                'description'=> 'A 24-hour coding hackathon with prizes.',
                'start_time' => $now->copy()->addDays(15)->setHour(9),
                'end_time'   => $now->copy()->addDays(16)->setHour(9),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::GATHERING,
                'venue_type' => VenueType::OFFLINE,
                'platform'   => null,
                'location'   => 'Innovation Hub Yangon',
                'organizer'  => $organizer->id,
            ],
            [
                'name'       => 'AI & Machine Learning Talk',
                'description'=> 'Experts discuss AI trends and ML use cases.',
                'start_time' => $now->copy()->addDays(20)->setHour(19),
                'end_time'   => $now->copy()->addDays(20)->setHour(21),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::ONLINE,
                'platform'   => 'Microsoft Teams',
                'location'   => null,
                'organizer'  => $organizer->id,
            ],
            [
                'name'       => 'Networking Night',
                'description'=> 'Meet and connect with tech professionals in the city.',
                'start_time' => $now->copy()->addDays(25)->setHour(18),
                'end_time'   => $now->copy()->addDays(25)->setHour(21),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::GATHERING,
                'venue_type' => VenueType::OFFLINE,
                'platform'   => null,
                'location'   => 'Sky Lounge Yangon',
                'organizer'  => $organizer->id,
            ],
            [
                'name'       => 'Frontend Dev Meetup',
                'description'=> 'Monthly meetup for frontend developers.',
                'start_time' => $now->copy()->addDays(30)->setHour(16),
                'end_time'   => $now->copy()->addDays(30)->setHour(19),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::GATHERING,
                'venue_type' => VenueType::OFFLINE,
                'platform'   => null,
                'location'   => 'Yangon Co-working Space',
                'organizer'  => $organizer->id,
            ],
            [
                'name'       => 'React Native Bootcamp',
                'description'=> 'Intensive mobile app development training with React Native.',
                'start_time' => $now->copy()->addDays(35)->setHour(10),
                'end_time'   => $now->copy()->addDays(35)->setHour(16),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::ONLINE,
                'platform'   => 'Zoom',
                'location'   => null,
                'organizer'  => $organizer->id,
            ],
            [
                'name'       => 'Open Source Contribution Day',
                'description'=> 'Collaborate on OSS projects and learn how to contribute.',
                'start_time' => $now->copy()->addDays(40)->setHour(11),
                'end_time'   => $now->copy()->addDays(40)->setHour(15),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::SKILL_SHARING,
                'venue_type' => VenueType::ONLINE,
                'platform'   => 'Discord',
                'location'   => null,
                'organizer'  => $organizer->id,
            ],
            [
                'name'       => 'Tech Year-End Party',
                'description'=> 'Celebrate the year with food, fun, and networking.',
                'start_time' => $now->copy()->addMonths(2)->setHour(19),
                'end_time'   => $now->copy()->addMonths(2)->setHour(23),
                'status'     => EventStatus::SCHEDULED,
                'type'       => EventType::GATHERING,
                'venue_type' => VenueType::OFFLINE,
                'platform'   => null,
                'location'   => 'Grand Ballroom Yangon',
                'organizer'  => $organizer->id,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
