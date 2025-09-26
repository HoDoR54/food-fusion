@php
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Recipes', 'url' => '/recipes'],
    ];

    $data = $res->getData();
    $items = $data->getItems();
    $pagination = $data->getPagination();

    function getDelayTime($index) {
        switch($index % 3) {
            case 0: return "0.1";
            case 1: return "0.2";
            case 2: return "0.3";
            default: return "0.1";
        }
    }
@endphp

@extends('layout.index')

@section('title', $title)

@section('content')
<section class="flex items-center justify-center pb-16">
    <section class="flex flex-col gap-5 px-5">
        <section class="w-full mb-6" data-delay="0.1s">
            <div class="max-w-2xl mx-auto mb-6">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-search text-gray-400"></i>
                    </div>
                    <input type="text" 
                           id="search-input"
                           class="block w-full pl-10 pr-12 py-3 border border-primary/30 rounded-lg bg-secondary/10 focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-300" 
                           placeholder="Search for recipes, ingredients, and more..."
                           value="{{ request('search_term') }}">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button id="search-button" class="cursor-pointer bg-primary text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary/90 transition-colors duration-300">
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full grid md:px-16 grid-cols-1 sm:grid-cols-2 gap-5 md:grid-cols-3 lg:grid-cols-4">
        <div class="flex flex-col gap-3" data-delay="0.2s">
            <div class="w-full rounded-2xl bg-primary/20 text-text p-4 flex flex-col gap-4">
                <!-- Add New Recipe Button -->
                @auth
                    <a href="{{ route('recipes.create.show') }}" class="w-full">
                        <x-button 
                            :variant="App\Enums\ButtonVariant::Primary" 
                            :size="App\Enums\ButtonSize::Medium"
                            class="w-full"
                            icon='<i class="fa-solid fa-plus"></i>'
                            text="New Recipe"
                        />
                    </a>
                @else
                    <a href="{{ route('auth.login.show') }}" class="w-full">
                        <x-button 
                            :variant="App\Enums\ButtonVariant::Secondary" 
                            :size="App\Enums\ButtonSize::Medium"
                            class="w-full"
                            icon='<i class="fa-solid fa-sign-in-alt"></i>'
                            text="Login to Post"
                        />
                    </a>
                @endauth
                
                <!-- Recipe Filters -->
                <div class="border-t border-primary/30 pt-4">
                    <x-recipe-filters />
                </div>
            </div>
        </div>
        <div class="md:col-span-2 lg:col-span-3 flex flex-col pl-3 gap-3">
            @if (count($items) > 0)
                    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($items as $index => $item)
                            <li class="animate-on-scroll" data-delay="{{ getDelayTime($index) }}s">
                                <x-recipe-card :recipe="$item" />
                            </li>
                        @endforeach
                    </ul>
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
                            :base-url="route('recipes.index')"
                            :preserve-params="['search_term', 'difficulty_level', 'dietary_preference', 'cuisine_type', 'course', 'sort_by', 'sort_direction']"
                            :max-buttons="5"
                        />
                    </div>
            @else
                <div class="md:cols-span-2 lg:col-span-3 flex flex-col items-center justify-center pl-3 gap-3">
                    <div class="text-8xl text-primary/30 mb-6 animate-pulse">
                        <i class="fa-solid fa-utensils"></i>
                    </div>
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-text/80 mb-3">No recipes found</h2>
                        <p class="text-text/60 text-base mb-6 leading-relaxed">
                            We couldn't find any recipes matching your search. Try adjusting your filters or search terms to discover delicious new dishes.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="{{ route('recipes.index') }}" 
                            class="inline-flex items-center justify-center gap-2 text-primary hover:text-secondary hover:underline text-sm font-medium transition-colors duration-300 px-4 py-2 rounded-lg hover:bg-primary/5">
                                <i class="fa-solid fa-arrow-left"></i>
                                See all recipes
                            </a>
                            <a href="{{ route('blogs.index') }}" 
                            class="inline-flex items-center justify-center gap-2 text-secondary hover:text-primary hover:underline text-sm font-medium transition-colors duration-300 px-4 py-2 rounded-lg hover:bg-secondary/5">
                                <i class="fa-solid fa-book-open"></i>
                                Browse cookbook instead
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        </section>
    </section>
</section>
@endsection