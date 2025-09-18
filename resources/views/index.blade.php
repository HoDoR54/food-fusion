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
        <section class="flex flex-col items-center justify-center gap-6 sm:gap-8 min-h-[90vh] px-4 sm:px-6 py-8 sm:py-12">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-center flex flex-col gap-2 sm:gap-3">
                <span style="animation-delay: 0.1s;" class="text-text animate-fade-in-up">We are building something</span>
                <span style="animation-delay: 0.2s;" class="text-primary animate-fade-in-up">Together</span>
            </h1>
            <p style="animation-delay: 0.2s;" class="animate-fade-in-up text-text/60 text-base sm:text-lg text-center max-w-xs sm:max-w-2xl px-2 sm:px-0">
                Neighbours aren't just next door — they're the people stirring, chopping, and sharing recipes around the world.
            </p>                
            <div id="next-gathering-display" style="animation-delay: 0.4s;" class="animate-fade-in-up lazy-load">
                <x-skeletons.next-gathering />
            </div>
        </section>

        {{-- What You Can Do With Us Section --}}
        <section class="w-full flex flex-col items-center justify-center min-h-screen px-4 sm:px-6 py-8 sm:py-12">
            <h2 class="animate-on-scroll text-2xl sm:text-3xl font-semibold text-center mb-4 sm:mb-6" data-delay="0.1s">Our Mission</h2>
            <p class="animate-on-scroll text-text/60 text-sm sm:text-lg text-center max-w-xs sm:max-w-2xl mb-8 sm:mb-12 px-2 sm:px-0" data-delay="0.2s">
                It's our mission to connect neighbours through shared skills and passions. Whether you're a seasoned cook or just starting out, FoodFusion is here to help you learn, share, and connect with others in your community.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-between w-full max-w-6xl px-4 sm:px-6 gap-8 sm:gap-12">
                <!-- Step 1 -->
                <div class="animate-on-scroll flex flex-col items-center text-center gap-2 sm:gap-3 flex-1" data-delay="0.3s">
                    <i data-lucide="book-open" class="w-8 h-8 sm:w-10 sm:h-10 text-primary mb-1 sm:mb-2"></i>
                    <span class="text-base sm:text-lg font-semibold">Learn Recipes</span>
                    <p class="text-text/60 text-xs sm:text-sm px-2 sm:px-0">Discover new dishes and cooking techniques from around the world.</p>
                </div>

                <div class="hidden sm:block w-12 border-t-2 border-primary/30 rotate-0"></div>

                <!-- Step 2 -->
                <div class="animate-on-scroll flex flex-col items-center text-center gap-2 sm:gap-3 flex-1" data-delay="0.4s">
                    <i data-lucide="users" class="w-8 h-8 sm:w-10 sm:h-10 text-primary mb-1 sm:mb-2"></i>
                    <span class="text-base sm:text-lg font-semibold">Share Skills</span>
                    <p class="text-text/60 text-xs sm:text-sm px-2 sm:px-0">Host a session or post your recipes to inspire fellow cooks.</p>
                </div>

                <div class="hidden sm:block w-12 border-t-2 border-primary/30 rotate-0"></div>

                <!-- Step 3 -->
                <div class="animate-on-scroll flex flex-col items-center text-center gap-2 sm:gap-3 flex-1" data-delay="0.5s">
                    <i data-lucide="heart-handshake" class="w-8 h-8 sm:w-10 sm:h-10 text-primary mb-1 sm:mb-2"></i>
                    <span class="text-base sm:text-lg font-semibold">Connect</span>
                    <p class="text-text/60 text-xs sm:text-sm px-2 sm:px-0">Meet fellow hobbyists, exchange tips, and share your kitchen adventures.</p>
                </div>

                <div class="hidden sm:block w-12 border-t-2 border-primary/30 rotate-0"></div>

                <!-- Step 4 -->
                <div class="animate-on-scroll flex flex-col items-center text-center gap-2 sm:gap-3 flex-1" data-delay="0.6s">
                    <i data-lucide="calendar" class="w-8 h-8 sm:w-10 sm:h-10 text-primary mb-1 sm:mb-2"></i>
                    <span class="text-base sm:text-lg font-semibold">Join Events</span>
                    <p class="text-text/60 text-xs sm:text-sm px-2 sm:px-0">Participate in skill-sharing sessions, challenges, and monthly gatherings.</p>
                </div>
            </div>

            <a href="{{ config('social-links.discord.server') }}" target="_blank" class="animate-on-scroll mt-8 sm:mt-12" data-delay="0.7s">
                <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Large" :text="'Join Our Discord'" :icon="'<i class=\'fa-brands fa-discord\'></i>'"/>
            </a>
        </section>

        {{-- Upcoming Events Carousel --}}
        <section id="upcoming-events-carousel" class="lazy-load flex flex-col items-center justify-center w-full min-h-screen px-4 sm:px-6 py-8 sm:py-12">
            <h2 class="animate-on-scroll text-2xl sm:text-3xl font-semibold text-center mb-4 sm:mb-6" data-delay="0.1s">Upcoming Events</h2>
            <p class="animate-on-scroll text-text/60 text-sm sm:text-lg text-center max-w-xs sm:max-w-2xl mb-8 sm:mb-12 px-2 sm:px-0" data-delay="0.2s">
                Don't miss out on exciting gatherings and skill-sharing sessions
            </p>
            
            <div class="animate-on-scroll w-full max-w-6xl relative" data-delay="0.3s">
                <!-- Carousel Container -->
                <div id="events-carousel-container" class="relative overflow-hidden rounded-xl">
                    <div id="events-carousel-track" class="flex transition-transform duration-500 ease-in-out">
                        <!-- Skeleton cards while loading -->
                        <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                            <x-skeletons.card />
                        </div>
                        <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                            <x-skeletons.card />
                        </div>
                        <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                            <x-skeletons.card />
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

            <div class="animate-on-scroll flex flex-col items-center justify-center gap-3 sm:gap-4 mt-6 sm:mt-8" data-delay="0.4s">
                <p class="text-text/60 text-sm sm:text-base text-center px-2 sm:px-0">Want to organize an event?</p>
                <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Large" :text="'Create Your Event'" :icon="'<i data-lucide=\'calendar-plus\'></i>'"/>
            </div>
        </section>        
        
        <section id="upcoming-skill-sharing" class="lazy-load flex flex-col items-center justify-center min-h-screen px-4 sm:px-6 py-8 sm:py-12">
            <h2 class="animate-on-scroll text-2xl sm:text-3xl font-semibold text-center mb-4 sm:mb-6" data-delay="0.1s">Upcoming Skill-Sharing Sessions</h2>
            <p class="animate-on-scroll text-text/60 text-sm sm:text-lg text-center max-w-xs sm:max-w-2xl mb-8 sm:mb-12 px-2 sm:px-0" data-delay="0.2s">
                Learn from your neighbours
            </p>
            <div class="flex justify-center px-4">
                <div id="upcoming-skill-sharing-sessions" 
                    class="animate-on-scroll grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full auto-rows-fr" data-delay="0.3s">
                    @for ($i = 1; $i <= 6; $i++)
                        <x-skeletons.skill-session />
                    @endfor
                </div>
            </div>

            <div class="animate-on-scroll flex flex-col items-center justify-center gap-3 sm:gap-4 py-3 sm:py-4" data-delay="0.4s">
                <p class="text-text/60 text-sm sm:text-base text-center px-2 sm:px-0">Want to share something you know?</p>
                <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Large" :text="'Host Your Own Session'" :icon="'<i data-lucide=\'users-round\'></i>'"/>
            </div>
            
        </section> 

        <section id="featured-recipes" class="lazy-load flex flex-col items-center justify-center min-h-screen px-4 sm:px-6 py-8 sm:py-12">
            <h2 class="animate-on-scroll text-2xl sm:text-3xl font-semibold text-center mb-4 sm:mb-6" data-delay="0.1s">Featured Recipes</h2>
            <p class="animate-on-scroll text-text/60 text-sm sm:text-lg text-center max-w-xs sm:max-w-2xl mb-8 sm:mb-12 px-2 sm:px-0" data-delay="0.2s">
                Discover delicious recipes from our community chefs
            </p>
            
            <div class="flex flex-col items-center justify-center w-full max-w-6xl">
                <div id="featured-recipes-grid" class="animate-on-scroll grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 w-full" data-delay="0.3s">
                    @for ($i = 0; $i < 4; $i++)
                        <x-skeletons.recipe-card />
                    @endfor
                </div>
                <div class="animate-on-scroll flex items-center justify-center flex-col gap-3 sm:gap-4 py-3 sm:py-4 mt-6 sm:mt-8" data-delay="0.4s">
                    <p class="text-text/60 text-sm sm:text-base text-center px-2 sm:px-0">Got a delicious recipe to share?</p>
                    <a href="{{ route('recipes.index') }}">
                        <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Large" :text="'See All'" :icon="'<i data-lucide=\'chef-hat\'></i>'"/>
                    </a>
                </div>
            </div>
        </section>

        <section id="top-blogs" class="lazy-load flex flex-col items-center justify-center min-h-screen px-4 sm:px-6 py-8 sm:py-12">
            <h2 class="animate-on-scroll text-2xl sm:text-3xl font-semibold text-center mb-4 sm:mb-6" data-delay="0.1s">Most Liked Blogs</h2>
            <p class="animate-on-scroll text-text/60 text-sm sm:text-lg text-center max-w-xs sm:max-w-2xl mb-8 sm:mb-12 px-2 sm:px-0" data-delay="0.2s">
                See what your neighbours are cooking (literally)
            </p>
            
            <div class="flex flex-col items-center justify-center w-full max-w-[80vw]">
                <div id="top-blogs-list" class="animate-on-scroll flex flex-col w-full gap-3" data-delay="0.3s">
                    @for ($i = 0; $i < 3; $i++)
                        <x-skeletons.blog-item />
                    @endfor
                </div>
                <div class="animate-on-scroll flex items-center justify-center flex-col gap-3 sm:gap-4 py-3 sm:py-4" data-delay="0.4s">
                    <p class="text-text/60 text-sm sm:text-base text-center px-2 sm:px-0">Cooking something? Let us know!</p>
                    <a href="{{ route('blogs.create') }}">
                        <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Large" :text="'Share What You Are Making'" :icon="'<i data-lucide=\'camera\'></i>'"/>
                    </a>
                </div>
            </div>
        </section>
    </section>
@endsection