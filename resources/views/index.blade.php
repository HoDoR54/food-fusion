@extends('layout.index')

@section('title', 'Food Fusion')

@section('content')
    @php
        use Illuminate\Support\Facades\Auth;
        use App\Enums\ButtonVariant;
        use App\Enums\ButtonSize;
    @endphp
    
    <section class="w-full flex flex-col gap-5 relative">
        {{-- Landing Page First Section --}}
        <section class="flex flex-col items-center justify-center gap-8 min-h-[90vh] bg-secondary/5 px-6 py-12">
            <h1 class="text-5xl font-bold text-center flex flex-col gap-3">
                <span class="text-text">We are building something</span>
                <span class="text-primary">Together</span>
            </h1>
            <p class="text-text/60 text-lg text-center max-w-2xl">
                Neighbours aren’t just next door — they’re the people stirring, chopping, and sharing recipes around the world.
            </p>                
            <div id="next-gathering-display" class="lazy-load flex items-center w-[80vw] min-h-[40vh] justify-center bg-secondary/10 rounded-xl border-primary/30 border-3 border-dashed">
                <div class="flex flex-col gap-3 p-4 items-center justify-center">
                    <h2 class="text-2xl font-bold text-primary">Next Gathering</h2>
                    <h3 class="text-lg font-medium">
                        <span class="font-semibold" id="next-gathering-title">...</span>
                        <span class="text-text font-extrabold text-2xl">.</span> 
                        <span class="text-text">Since January 2023</span>
                    </h3>
                    <p class="text-text/60">
                        <span id="next-gathering-location-or-platform">...</span>
                        <span class="font-extrabold text-2xl text-primary/30">.</span>
                        <span id="next-gathering-date">...</span>
                    </p>
                    <p class="text-text/60 text-sm" id="next-gathering-description">
                        ...
                    </p>
                    <x-button id="next-event-register" :variant="ButtonVariant::Primary" :size="ButtonSize::Large" :text="'I\'ll be there'" class="mt-4 px-5" :icon="'<i data-lucide=\'calendar-plus\'></i>'" />
                </div>
            </div>
        </section>

        {{-- What You Can Do With Us Section --}}
        <section class="w-full flex flex-col items-center justify-center min-h-screen px-6 py-12">
            <h2 class="text-3xl font-semibold text-center mb-6">What You Can Do With Us</h2>
            <p class="text-text/60 text-lg text-center max-w-2xl mb-12">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Officia similique fugiat incidunt nihil?
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-between w-full max-w-6xl px-6 gap-12">
                <!-- Step 1 -->
                <div class="flex flex-col items-center text-center gap-3 flex-1">
                    <i data-lucide="book-open" class="w-10 h-10 text-primary mb-2"></i>
                    <span class="text-lg font-semibold">Learn Recipes</span>
                    <p class="text-text/60 text-sm">Discover new dishes and cooking techniques from around the world.</p>
                </div>

                <div class="hidden sm:block w-12 border-t-2 border-primary/30 rotate-0"></div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center text-center gap-3 flex-1">
                    <i data-lucide="users" class="w-10 h-10 text-primary mb-2"></i>
                    <span class="text-lg font-semibold">Share Skills</span>
                    <p class="text-text/60 text-sm">Host a session or post your recipes to inspire fellow cooks.</p>
                </div>

                <div class="hidden sm:block w-12 border-t-2 border-primary/30 rotate-0"></div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center text-center gap-3 flex-1">
                    <i data-lucide="heart-handshake" class="w-10 h-10 text-primary mb-2"></i>
                    <span class="text-lg font-semibold">Connect</span>
                    <p class="text-text/60 text-sm">Meet fellow hobbyists, exchange tips, and share your kitchen adventures.</p>
                </div>

                <div class="hidden sm:block w-12 border-t-2 border-primary/30 rotate-0"></div>

                <!-- Step 4 -->
                <div class="flex flex-col items-center text-center gap-3 flex-1">
                    <i data-lucide="calendar" class="w-10 h-10 text-primary mb-2"></i>
                    <span class="text-lg font-semibold">Join Events</span>
                    <p class="text-text/60 text-sm">Participate in skill-sharing sessions, challenges, and monthly gatherings.</p>
                </div>
            </div>

            <a href="{{ config('social-links.discord.server') }}" target="_blank" class="mt-12">
                <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Large" :text="'Join Our Discord'" :icon="'<i class=\'fa-brands fa-discord\'></i>'"/>
            </a>
        </section>

        {{-- Previous Events Monumentals --}}
        <section class="flex items-center justify-center w-full min-h-screen bg-secondary/5 px-6 py-12">
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

        <section id="upcoming-skill-sharing" class="lazy-load flex flex-col items-center justify-center min-h-screen px-6 py-12">
            <h2 class="text-3xl font-semibold text-center mb-6">Upcoming Skill-Sharing Sessions</h2>
            <p class="text-text/60 text-lg text-center max-w-2xl mb-12">
                Learn from your neighbours
            </p>
            <div class="flex justify-center px-4">
                <div id="upcoming-skill-sharing-sessions" 
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full auto-rows-fr">
                    @for ($i = 1; $i <= 6; $i++)
                        <div class="bg-secondary/10 border-2 border-dashed border-primary/10 rounded-lg p-5 flex flex-col justify-between h-full">
                            <div>
                                <h3 class="text-lg font-semibold mb-2">...</h3>
                                <p class="text-text/60 text-sm">...</p>
                            </div>
                            <p class="text-secondary text-xs mt-4">...</p>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="flex flex-col items-center justify-center gap-4 py-4">
                <p class="text-text/60 text-base">Want to share something you know?</p>
                <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Large" :text="'Host Your Own Session'" :icon="'<i data-lucide=\'users-round\'></i>'"/>
            </div>
            
        </section> 

        <section id="top-blogs" class="lazy-load flex flex-col items-center justify-center min-h-screen bg-secondary/5 px-6 py-12">
            <h2 class="text-3xl font-semibold text-center mb-6">Most Liked Blogs</h2>
            <p class="text-text/60 text-lg text-center max-w-2xl mb-12">
                See what your neighbours are cooking (literally)
            </p>
            
            <div class="flex flex-col items-center justify-center w-full max-w-[80vw]">
                <div id="top-blogs-list" class="flex flex-col w-full gap-3">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="border-l-8 border-dashed border-primary/10 pl-6 pr-4 py-4 bg-white/40 rounded-r-lg">
                            <div class="flex justify-between items-center w-full">
                                <div class="flex items-center gap-4 w-full">
                                    <img
                                        src="{{ asset('images/default-profile.webp') }}"
                                        alt="Story {{ $i + 1 }}"
                                        class="w-16 h-16 rounded-full object-cover opacity-90 cursor-pointer border-2 border-dashed border-primary/20"
                                    />
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-foreground cursor-pointer hover:underline">...</h3>
                                        <p class="text-primary/70 max-w-[70%] line-clamp-1">...</p>
                                        <p class="text-text/60 text-sm">...</p>
                                    </div>
                                </div>
                                <div class="text-right font-medium text-primary">
                                    ...
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="flex items-center justify-center flex-col gap-4 py-4">
                    <p class="text-text/60 text-base">Cooking something? Let us know!</p>
                    <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Large" :text="'Share What You Are Making'" :icon="'<i data-lucide=\'camera\'></i>'"/>
                </div>
            </div>
        </section>
    </section>
@endsection