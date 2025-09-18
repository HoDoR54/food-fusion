@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;

    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Cookbook', 'url' => '/blogs']
    ];
@endphp

@extends('layout.index')
@section('title', $title)

@section('content')
<section class="flex items-center justify-center pb-16">
    <section class="flex flex-col min-w-[50vw] lg:max-w-[80vw] xl:max-w-[70vw] gap-5 px-5">
        <section class="w-full mb-6" data-delay="0.1s">
            <div class="max-w-2xl mx-auto mb-6">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-search text-gray-400"></i>
                    </div>
                    <input type="text" 
                           id="search-input"
                           class="block w-full pl-10 pr-12 py-3 border border-primary/30 rounded-lg bg-secondary/10 focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-300" 
                           placeholder="Search for cooking tips, recipes, and more..."
                           value="{{ request('search_term') }}">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button id="search-button" class="bg-primary text-white cursor-pointer px-4 py-2 rounded-md text-sm font-medium hover:bg-primary/90 transition-colors duration-300">
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <div class="md:col-span-2 lg:col-span-3 flex flex-col pr-3 gap-3">
            @if (count($blogs) > 0)
                <div class="flex flex-col gap-5 mb-12">
                    @foreach ($blogs as $index => $blog)
                        <div class="animate-on-scroll">
                            <x-blog-card :blog="$blog" />
                        </div>
                    @endforeach
                </div>

                <div class="flex flex-col w-full gap-3" data-delay="0.5s">
                    <p class="text-sm text-text/60 w-full flex items-center justify-center text-center">
                        Showing {{ $pagination['current_page'] }} of {{ $pagination['total_pages'] }} pages
                    </p>
                    <x-paginator 
                        :current-page="$pagination['current_page']" 
                        :total-pages="$pagination['total_pages']" 
                        :total-items="$pagination['total_items']" 
                        :has-prev="$pagination['has_previous_page']" 
                        :has-next="$pagination['has_next_page']"
                        :base-url="route('blogs.index')"
                        :preserve-params="['search_term', 'category', 'topic', 'sort_by', 'sort_direction']"
                        :max-buttons="5"
                    />
                </div>
            @else
                <div class="md:cols-span-2 lg:col-span-3 flex flex-col items-center justify-center pr-3 gap-3 min-h-[80vh]">
                    <div class="text-8xl text-primary/30 mb-6 animate-pulse">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <div class="max-w-md text-center">
                        <h2 class="text-2xl font-bold text-text/80 mb-3">No blogs found</h2>
                        <p class="text-text/60 text-base mb-6 leading-relaxed">
                            Our community cookbook is waiting for amazing content! Check back later or be the first to share your culinary wisdom.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="{{ route('home') }}" 
                            class="inline-flex items-center justify-center gap-2 text-primary hover:text-secondary hover:underline text-sm font-medium transition-colors duration-300 px-4 py-2 rounded-lg hover:bg-primary/5">
                                <i class="fa-solid fa-arrow-left"></i>
                                Back to home
                            </a>
                            <a href="{{ route('recipes.index') }}" 
                            class="inline-flex items-center justify-center gap-2 text-secondary hover:text-primary hover:underline text-sm font-medium transition-colors duration-300 px-4 py-2 rounded-lg hover:bg-secondary/5">
                                <i class="fa-solid fa-utensils"></i>
                                Browse recipes instead
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="flex flex-col gap-3" data-delay="0.2s">
            <div class="w-full rounded-2xl bg-primary/20 text-text p-4 flex flex-col gap-4">
                <!-- Add New Blog Button -->
                @auth
                    <a href="{{ route('blogs.create') }}" class="w-full">
                        <x-button 
                            :variant="App\Enums\ButtonVariant::Primary" 
                            :size="App\Enums\ButtonSize::Medium"
                            class="w-full"
                            icon='<i class="fa-solid fa-plus"></i>'
                            text="New Blog Post"
                        />
                    </a>
                @else
                    <a href="{{ route('auth.login.show') }}" class="w-full">
                        <x-button 
                            :variant="App\Enums\ButtonVariant::SECONDARY" 
                            :size="App\Enums\ButtonSize::MEDIUM"
                            class="w-full"
                            icon='<i class="fa-solid fa-sign-in-alt"></i>'
                            text="Login to Post"
                        />
                    </a>
                @endauth
                
                <!-- Blog Filters -->
                <div class="border-t border-primary/30 pt-4">
                    <div class="flex flex-col gap-3">
                        {{-- Category Filter --}}
                        <div class="relative w-full">
                            <select
                                id="category"
                                name="category"
                                class="bg-secondary/15 border border-gray-300 px-4 pr-10 py-2 focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-text/60"
                            >
                                <option value="" disabled selected>All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                                        {{ ucfirst($category) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-text/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        {{-- Topic Filter --}}
                        <div class="relative w-full">
                            <select
                                id="topic"
                                name="topic"
                                class="bg-secondary/15 border border-gray-300 px-4 pr-10 py-2 focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-text/60"
                            >
                                <option value="" disabled selected>All Topics</option>
                                @foreach($topics as $topic)
                                    <option value="{{ $topic }}" {{ request('topic') === $topic ? 'selected' : '' }}>
                                        {{ ucfirst($topic) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-text/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        {{-- Sort By --}}
                        <div class="relative w-full">
                            <select
                                id="sort_by"
                                name="sort_by"
                                class="bg-secondary/15 border border-gray-300 px-4 pr-10 py-2 focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-text/60"
                            >
                                <option value="" disabled selected>Sort by</option>
                                <option value="created_at,desc" {{ request('sort_by') === 'created_at' && request('sort_direction') === 'desc' ? 'selected' : '' }}>Newest First</option>
                                <option value="created_at,asc" {{ request('sort_by') === 'created_at' && request('sort_direction') === 'asc' ? 'selected' : '' }}>Oldest First</option>
                                <option value="popularity,desc" {{ request('sort_by') === 'popularity' && request('sort_direction') === 'desc' ? 'selected' : '' }}>Most Popular</option>
                                <option value="updated_at,desc" {{ request('sort_by') === 'updated_at' && request('sort_direction') === 'desc' ? 'selected' : '' }}>Recently Updated</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-text/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        {{-- Clear Filters Button --}}
                        <div class="w-full pt-2 border-t border-primary/20">
                            <x-button 
                                :variant="ButtonVariant::Secondary" 
                                :size="ButtonSize::Medium" 
                                class="w-full"
                                icon='<i class="fa-solid fa-filter-circle-xmark"></i>'
                                text="Clear All Filters"
                                id="clear-filters"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
</section>
@endsection