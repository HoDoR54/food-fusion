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
        <section class="flex flex-col items-center justify-center gap-8 min-h-[90vh] px-6 py-12">
            <h1 class="text-5xl font-bold text-center flex flex-col gap-3">
                <span style="animation-delay: 0.1s;" class="text-text animate-fade-in-up">We are building something</span>
                <span style="animation-delay: 0.2s;" class="text-primary animate-fade-in-up">Together</span>
            </h1>
            <p style="animation-delay: 0.2s;" class="animate-fade-in-up text-text/60 text-lg text-center max-w-2xl">
                Neighbours aren’t just next door — they’re the people stirring, chopping, and sharing recipes around the world.
            </p>                
            <div id="next-gathering-display" style="animation-delay: 0.4s;" class="animate-fade-in-up lazy-load flex items-center w-[80vw] min-h-[40vh] justify-center bg-secondary/10 rounded-xl border-primary/30 border-3 border-dashed">
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
                    <x-button data-action="show-event-registration-popup" data-event-id="next-event-register" id="next-event-register" :variant="ButtonVariant::Primary" :size="ButtonSize::Large" :text="'I\'ll be there'" class="mt-4 px-5" :icon="'<i data-lucide=\'calendar-plus\'></i>'" />
                </div>
            </div>
        </section>

        {{-- What You Can Do With Us Section --}}
        <section class="w-full flex flex-col items-center justify-center min-h-screen px-6 py-12">
            <h2 class="animate-on-scroll text-3xl font-semibold text-center mb-6" data-delay="0.1s">Our Mission</h2>
            <p class="animate-on-scroll text-text/60 text-lg text-center max-w-2xl mb-12" data-delay="0.2s">
                It's our mission to connect neighbours through shared skills and passions. Whether you're a seasoned cook or just starting out, FoodFusion is here to help you learn, share, and connect with others in your community.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-between w-full max-w-6xl px-6 gap-12">
                <!-- Step 1 -->
                <div class="animate-on-scroll flex flex-col items-center text-center gap-3 flex-1" data-delay="0.3s">
                    <i data-lucide="book-open" class="w-10 h-10 text-primary mb-2"></i>
                    <span class="text-lg font-semibold">Learn Recipes</span>
                    <p class="text-text/60 text-sm">Discover new dishes and cooking techniques from around the world.</p>
                </div>

                <div class="hidden sm:block w-12 border-t-2 border-primary/30 rotate-0"></div>

                <!-- Step 2 -->
                <div class="animate-on-scroll flex flex-col items-center text-center gap-3 flex-1" data-delay="0.4s">
                    <i data-lucide="users" class="w-10 h-10 text-primary mb-2"></i>
                    <span class="text-lg font-semibold">Share Skills</span>
                    <p class="text-text/60 text-sm">Host a session or post your recipes to inspire fellow cooks.</p>
                </div>

                <div class="hidden sm:block w-12 border-t-2 border-primary/30 rotate-0"></div>

                <!-- Step 3 -->
                <div class="animate-on-scroll flex flex-col items-center text-center gap-3 flex-1" data-delay="0.5s">
                    <i data-lucide="heart-handshake" class="w-10 h-10 text-primary mb-2"></i>
                    <span class="text-lg font-semibold">Connect</span>
                    <p class="text-text/60 text-sm">Meet fellow hobbyists, exchange tips, and share your kitchen adventures.</p>
                </div>

                <div class="hidden sm:block w-12 border-t-2 border-primary/30 rotate-0"></div>

                <!-- Step 4 -->
                <div class="animate-on-scroll flex flex-col items-center text-center gap-3 flex-1" data-delay="0.6s">
                    <i data-lucide="calendar" class="w-10 h-10 text-primary mb-2"></i>
                    <span class="text-lg font-semibold">Join Events</span>
                    <p class="text-text/60 text-sm">Participate in skill-sharing sessions, challenges, and monthly gatherings.</p>
                </div>
            </div>

            <a href="{{ config('social-links.discord.server') }}" target="_blank" class="animate-on-scroll mt-12" data-delay="0.7s">
                <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Large" :text="'Join Our Discord'" :icon="'<i class=\'fa-brands fa-discord\'></i>'"/>
            </a>
        </section>

        {{-- Upcoming Events Carousel --}}
        <section id="upcoming-events-carousel" class="lazy-load flex flex-col items-center justify-center w-full min-h-screen px-6 py-12">
            <h2 class="animate-on-scroll text-3xl font-semibold text-center mb-6" data-delay="0.1s">Upcoming Events</h2>
            <p class="animate-on-scroll text-text/60 text-lg text-center max-w-2xl mb-12" data-delay="0.2s">
                Don't miss out on exciting gatherings and skill-sharing sessions
            </p>
            
            <div class="animate-on-scroll w-full max-w-6xl relative" data-delay="0.3s">
                <!-- Carousel Container -->
                <div id="events-carousel-container" class="relative overflow-hidden rounded-xl">
                    <div id="events-carousel-track" class="flex transition-transform duration-500 ease-in-out">
                        <!-- Placeholder cards while loading -->
                        <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                            <div class="bg-white/60 border-2 border-dashed border-primary/20 rounded-lg p-6 h-80 flex flex-col justify-between">
                                <div>
                                    <div class="w-16 h-4 bg-primary/20 rounded mb-3 animate-pulse"></div>
                                    <div class="w-full h-6 bg-text/20 rounded mb-3 animate-pulse"></div>
                                    <div class="w-3/4 h-4 bg-text/10 rounded mb-4 animate-pulse"></div>
                                    <div class="w-full h-20 bg-text/10 rounded animate-pulse"></div>
                                </div>
                                <div class="flex justify-between items-center mt-4">
                                    <div class="w-20 h-4 bg-secondary/30 rounded animate-pulse"></div>
                                    <div class="w-24 h-8 bg-primary/20 rounded animate-pulse"></div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                            <div class="bg-white/60 border-2 border-dashed border-primary/20 rounded-lg p-6 h-80 flex flex-col justify-between">
                                <div>
                                    <div class="w-20 h-4 bg-secondary/20 rounded mb-3 animate-pulse"></div>
                                    <div class="w-full h-6 bg-text/20 rounded mb-3 animate-pulse"></div>
                                    <div class="w-2/3 h-4 bg-text/10 rounded mb-4 animate-pulse"></div>
                                    <div class="w-full h-20 bg-text/10 rounded animate-pulse"></div>
                                </div>
                                <div class="flex justify-between items-center mt-4">
                                    <div class="w-16 h-4 bg-secondary/30 rounded animate-pulse"></div>
                                    <div class="w-24 h-8 bg-primary/20 rounded animate-pulse"></div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                            <div class="bg-white/60 border-2 border-dashed border-primary/20 rounded-lg p-6 h-80 flex flex-col justify-between">
                                <div>
                                    <div class="w-24 h-4 bg-primary/20 rounded mb-3 animate-pulse"></div>
                                    <div class="w-full h-6 bg-text/20 rounded mb-3 animate-pulse"></div>
                                    <div class="w-5/6 h-4 bg-text/10 rounded mb-4 animate-pulse"></div>
                                    <div class="w-full h-20 bg-text/10 rounded animate-pulse"></div>
                                </div>
                                <div class="flex justify-between items-center mt-4">
                                    <div class="w-24 h-4 bg-secondary/30 rounded animate-pulse"></div>
                                    <div class="w-24 h-8 bg-primary/20 rounded animate-pulse"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carousel Navigation -->
                <x-button :icon="'<i class=\'fa-solid fa-chevron-left\'></i>'" id="carousel-prev" class="cursor-pointer absolute py-3 -left-4 top-1/2 transform -translate-y-1/2 shadow-lg">
                </x-button>
                <x-button :icon="'<i class=\'fa-solid fa-chevron-right\'></i>'" id="carousel-next" class="cursor-pointer absolute py-3 -right-4 top-1/2 transform -translate-y-1/2 shadow-lg">
                </x-button>

                <div id="carousel-indicators" class="flex justify-center mt-6 gap-2 opacity-0">
                </div>
            </div>

            <div class="animate-on-scroll flex flex-col items-center justify-center gap-4 mt-8" data-delay="0.4s">
                <p class="text-text/60 text-base">Want to organize an event?</p>
                <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Large" :text="'Create Your Event'" :icon="'<i data-lucide=\'calendar-plus\'></i>'"/>
            </div>
        </section>        
        
        <section id="upcoming-skill-sharing" class="lazy-load flex flex-col items-center justify-center min-h-screen px-6 py-12">
            <h2 class="animate-on-scroll text-3xl font-semibold text-center mb-6" data-delay="0.1s">Upcoming Skill-Sharing Sessions</h2>
            <p class="animate-on-scroll text-text/60 text-lg text-center max-w-2xl mb-12" data-delay="0.2s">
                Learn from your neighbours
            </p>
            <div class="flex justify-center px-4">
                <div id="upcoming-skill-sharing-sessions" 
                    class="animate-on-scroll grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full auto-rows-fr" data-delay="0.3s">
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

            <div class="animate-on-scroll flex flex-col items-center justify-center gap-4 py-4" data-delay="0.4s">
                <p class="text-text/60 text-base">Want to share something you know?</p>
                <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Large" :text="'Host Your Own Session'" :icon="'<i data-lucide=\'users-round\'></i>'"/>
            </div>
            
        </section> 

        <section id="featured-recipes" class="lazy-load flex flex-col items-center justify-center min-h-screen bg-secondary/5 px-6 py-12">
            <h2 class="animate-on-scroll text-3xl font-semibold text-center mb-6" data-delay="0.1s">Featured Recipes</h2>
            <p class="animate-on-scroll text-text/60 text-lg text-center max-w-2xl mb-12" data-delay="0.2s">
                Discover delicious recipes from our community chefs
            </p>
            
            <div class="flex flex-col items-center justify-center w-full max-w-6xl">
                <div id="featured-recipes-grid" class="animate-on-scroll grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full" data-delay="0.3s">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="bg-white/60 border-2 border-dashed border-primary/20 rounded-lg overflow-hidden hover:border-primary/40 transition-all duration-200 group">
                            <div class="aspect-video bg-secondary/10 flex items-center justify-center">
                                <div class="w-24 h-16 bg-primary/20 rounded animate-pulse"></div>
                            </div>
                            <div class="p-4">
                                <div class="w-3/4 h-6 bg-text/20 rounded mb-2 animate-pulse"></div>
                                <div class="w-1/2 h-4 bg-text/10 rounded mb-3 animate-pulse"></div>
                                <div class="flex justify-between items-center">
                                    <div class="w-16 h-4 bg-secondary/30 rounded animate-pulse"></div>
                                    <div class="w-20 h-4 bg-primary/20 rounded animate-pulse"></div>
                                </div>
                                <div class="flex gap-2 mt-3">
                                    <div class="w-12 h-5 bg-primary/10 rounded-full animate-pulse"></div>
                                    <div class="w-16 h-5 bg-secondary/10 rounded-full animate-pulse"></div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="animate-on-scroll flex items-center justify-center flex-col gap-4 py-4 mt-8" data-delay="0.4s">
                    <p class="text-text/60 text-base">Got a delicious recipe to share?</p>
                    <a href="{{ route('recipes.index') }}">
                        <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Large" :text="'See All'" :icon="'<i data-lucide=\'chef-hat\'></i>'"/>
                    </a>
                </div>
            </div>
        </section>

        <section id="top-blogs" class="lazy-load flex flex-col items-center justify-center min-h-screen px-6 py-12">
            <h2 class="animate-on-scroll text-3xl font-semibold text-center mb-6" data-delay="0.1s">Most Liked Blogs</h2>
            <p class="animate-on-scroll text-text/60 text-lg text-center max-w-2xl mb-12" data-delay="0.2s">
                See what your neighbours are cooking (literally)
            </p>
            
            <div class="flex flex-col items-center justify-center w-full max-w-[80vw]">
                <div id="top-blogs-list" class="animate-on-scroll flex flex-col w-full gap-3" data-delay="0.3s">
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
                <div class="animate-on-scroll flex items-center justify-center flex-col gap-4 py-4" data-delay="0.4s">
                    <p class="text-text/60 text-base">Cooking something? Let us know!</p>
                    <a href="{{ route('blogs.create') }}">
                        <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Large" :text="'Share What You Are Making'" :icon="'<i data-lucide=\'camera\'></i>'"/>
                    </a>
                </div>
            </div>
        </section>
    </section>
@endsection