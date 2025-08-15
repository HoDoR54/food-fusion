@php
    use Illuminate\Support\Facades\Auth;
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;

    $user = Auth::user();
    $sessionValue = session('isPopUpConsent', true);
    
    if ($sessionValue === 'false' || $sessionValue === false || $sessionValue === 0) {
        $isPopUpConsent = false;
    } elseif ($sessionValue === 'true' || $sessionValue === true || $sessionValue === 1) {
        $isPopUpConsent = true;
    } else {
        $isPopUpConsent = (bool) $sessionValue;
    }
@endphp

@extends('layout.index')

@section('title', 'Food Fusion')

@if (!$user && $isPopUpConsent)
    @section('pop-up')
        <livewire:register-form :isPopUp="true"/>
    @endsection
@endif

@section('content')
    <section class="w-full flex flex-col gap-5 relative">
        {{-- Landing Page First Section --}}
        <section class="flex flex-col items-center justify-center gap-8 min-h-[90vh] bg-secondary/5 p-5">
            <h1 class="text-5xl font-bold text-center flex flex-col gap-3">
                <span class="text-text">We are building something</span>
                <span class="text-primary">Together</span>
            </h1>
            <p class="text-text/50 text-lg text-center max-w-2xl">
                Neighbours aren’t just next door — they’re the people stirring, chopping, and sharing recipes around the world.            </p>
            {{-- TO-DO: fetch a real event from the database --}}
            <div class="flex items-center w-[80vw] min-h-[40vh] justify-center bg-secondary/10 rounded-xl border-primary/30 border-3 border-dashed">
                <div class="flex flex-col gap-2 p-4 items-center justify-center">
                    <h2 class="text-2xl font-bold text-primary">Next Gathering</h2>
                    <h3 class="text-lg">
                        <span class="font-semibold">Monthly Kitchen Time</span>
                        <span class="text-text font-extrabold text-2xl">.</span> 
                        <span class="text-text">Since January 2023</span>
                    </h3>
                    <p class="text-gray-500">
                        <span>West Yangon General Hospital</span>
                        <span class="font-extrabold text-2xl text-primary/30">.</span>
                        <span>April 5th, 8:30 AM</span>
                    </p>
                    <p class="text-gray-500 text-sm">
                        There'll be fun activities and discussions around food, cooking, and community building.
                    </p>
                    <x-button :variant="ButtonVariant::Primary" :size="ButtonSize::Small" :text="'I\'ll be there'" class="mt-4 px-5" :icon="'<i data-lucide=\'calendar-plus\'></i>'" />
                </div>
            </div>
        </section>

        {{-- What You Can Do With Us Section --}}
        <section class="w-full flex flex-col items-center justify-center min-h-screen p-5">
            <h2 class="text-3xl font-bold text-center mb-6">What You Can Do With Us</h2>
            <p class="text-text/50 text-center max-w-2xl mb-12">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Officia similique fugiat incidunt nihil?
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-between w-full max-w-6xl px-6 gap-8">
                <!-- Step 1 -->
                <div class="flex flex-col items-center text-center gap-2 flex-1">
                    <i data-lucide="book-open" class="w-10 h-10 text-primary mb-2"></i>
                    <span class="font-semibold">Learn Recipes</span>
                    <p class="text-gray-600 text-sm">Discover new dishes and cooking techniques from around the world.</p>
                </div>

                <div class="hidden sm:block w-12 border-t-2 border-primary/30 rotate-0"></div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center text-center gap-2 flex-1">
                    <i data-lucide="users" class="w-10 h-10 text-primary mb-2"></i>
                    <span class="font-semibold">Share Skills</span>
                    <p class="text-gray-600 text-sm">Host a session or post your recipes to inspire fellow cooks.</p>
                </div>

                <div class="hidden sm:block w-12 border-t-2 border-primary/30 rotate-0"></div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center text-center gap-2 flex-1">
                    <i data-lucide="heart-handshake" class="w-10 h-10 text-primary mb-2"></i>
                    <span class="font-semibold">Connect</span>
                    <p class="text-gray-600 text-sm">Meet fellow hobbyists, exchange tips, and share your kitchen adventures.</p>
                </div>

                <div class="hidden sm:block w-12 border-t-2 border-primary/30 rotate-0"></div>

                <!-- Step 4 -->
                <div class="flex flex-col items-center text-center gap-2 flex-1">
                    <i data-lucide="calendar" class="w-10 h-10 text-primary mb-2"></i>
                    <span class="font-semibold">Join Events</span>
                    <p class="text-gray-600 text-sm">Participate in skill-sharing sessions, challenges, and monthly gatherings.</p>
                </div>
            </div>

            <div class="mt-12">
                <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Large" :text="'Join Our Discord'" :icon="'<i class=\'fa-brands fa-discord\'></i>'" />
            </div>
        </section>

        {{-- Previous Events Monumentals --}}
        <section class="flex items-center justify-center w-full min-h-screen bg-secondary/5 p-5">
            <x-carousel 
                :title="'Events Organized by FoodFusion This Year'"
                :description="'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Beatae cupiditate esse odio? Reiciendis.'"
                :items="[
                    ['image' => 'for-show/1.jpg', 'title' => 'Event 1', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus est culpa, amet praesentium ea temporibus!'],
                    ['image' => 'for-show/2.jpg', 'title' => 'Event 2', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus est culpa, amet praesentium ea temporibus!'],
                    ['image' => 'for-show/3.jpg', 'title' => 'Event 3', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus est culpa, amet praesentium ea temporibus!'],
                    ['image' => 'for-show/4.jpg', 'title' => 'Event 4', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus est culpa, amet praesentium ea temporibus!'],
                    ['image' => 'for-show/5.jpg', 'title' => 'Event 5', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus est culpa, amet praesentium ea temporibus!'],
                    ['image' => 'for-show/6.jpg', 'title' => 'Event 6', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus est culpa, amet praesentium ea temporibus!'],
                    ['image' => 'for-show/7.jpg', 'title' => 'Event 7', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus est culpa, amet praesentium ea temporibus!'],
                    ['image' => 'for-show/8.jpg', 'title' => 'Event 8', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus est culpa, amet praesentium ea temporibus!'],
                ]"
                :showSeeAll="true"
                :seeAllUrl="route('events.index')"
                :slidesVisible="5"
                :autoPlay="true"
                :autoPlayInterval="3000"
            />
        </section>
        

        {{-- Upcoming Skill-sharing Sessions Later This Month
        TO-DO: fetch real events from the database --}}
        <section class="flex flex-col items-center justify-center min-h-screen p-5">
            <h2 class="text-3xl font-bold text-center mb-4">Upcoming Skill-Sharing Sessions</h2>
            <p class="text-text/50 text-lg text-center max-w-2xl mb-6">
                Learn from your neighbours
            </p>
            <div class="flex items-center justify-center h-[40vh]">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full px-4">
                    {{-- TO-DO: show a maximum of six and add see more at the sixth block --}}
                    @for ($i = 1; $i <= 5; $i++)
                        <div class="bg-secondary/10 min-w-[350px] border-2 border-dashed border-primary/10 rounded-lg px-4 py-2">
                            <h3 class="text-lg font-medium mb-1">Skill Session {{ $i }}</h3>
                            <p class="text-gray-600 text-sm">with User {{ $i }}</p>
                            <p class="text-secondary text-xs">on {{ now()->addDays($i)->format('F j, Y') }}</p>
                            {{-- <x-button :variant="ButtonVariant::Primary" :size="ButtonSize::Small" :text="'Join Now'" class="w-full" /> --}}
                        </div>
                    @endfor
                </div>
            </div>

            <div class="flex flex-col items-center justify-center gap-3">
                <p class="text-gray-600">Want to share something you know?</p>
                <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Large" :text="'Host Your Own Session'" :icon="'<i data-lucide=\'users-round\'></i>'"/>
            </div>
            
        </section> 

        <section class="flex flex-col items-center justify-center min-h-screen bg-secondary/5 p-5">
            <h2 class="text-3xl font-bold text-center mb-4">Most Liked Blogs</h2>
            <p class="text-text/50 text-lg text-center max-w-2xl mb-6">
                မင်္ဂလာပါတောသားတွေ
            </p>
            <div class="flex flex-col w-full gap-3 max-w-[80vw]">
                @for ($i = 0; $i < 3; $i++)
                    <div class="border-l-8 border-dashed border-primary/10 pl-6 pr-4 py-4 bg-secondary/5 rounded-r-lg">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <img
                                    src="{{ asset('images/default-profile.webp') }}"
                                    alt="Story {{ $i + 1 }}"
                                    class="w-16 h-16 rounded-full object-cover opacity-90 cursor-pointer border-2 border-dashed border-primary/20"
                                />
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-foreground">Blog Name {{ $i + 1 }}</h3>
                                    <p class="text-primary/70 max-w-[70%] line-clamp-1">Brief Description Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero similique illum, nostrum at a quae.</p>
                                    <p class="text-text/50 text-sm">April 12th, 2024</p>
                                </div>
                            </div>
                            <div class="text-right font-medium text-primary">
                                12.34K Likes
                            </div>
                        </div>
                    </div>
                @endfor
                <div class="flex items-center justify-center flex-col gap-3 py-3">
                    <p class="text-primary/50">Cooking something? Let us know!</p>
                    <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Large" :text="'Share What You Are Making'" :icon="'<i data-lucide=\'camera\'></i>'"/>
                </div>
            </div>
        </section>
    </section>
@endsection