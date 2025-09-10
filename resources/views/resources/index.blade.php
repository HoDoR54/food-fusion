@php
    $title = 'Resources Hub';
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Resources']
    ];
@endphp

@extends('layout.index')

@section('title', $title)

@section('content')
    <section class="w-full max-w-6xl mx-auto px-6 py-8">
        {{-- Header --}}
        <div class="mb-12 text-center">
            <h1 class="animate-on-scroll text-4xl font-bold text-primary mb-4" data-delay="0.1s">
                Resources Hub
            </h1>
            <p class="animate-on-scroll text-text/70 text-lg leading-relaxed max-w-3xl mx-auto" data-delay="0.2s">
                Enhance your culinary journey with our comprehensive collection of cooking resources. From educational materials to professional tools, everything you need to elevate your cooking skills.
            </p>
        </div>

        {{-- Resource Categories --}}
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            {{-- Educational Resources Card --}}
            <div class="animate-fade-in-up flex flex-col bg-white/30 border-2 border-dashed border-primary/20 rounded-2xl p-8" style="animation-delay: 0.1s;">
                <div class="flex items-center mb-6 gap-3">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mr-4">
                        <i data-lucide="book-open" class="w-6 h-6 text-primary"></i>
                    </div>
                    <h2 class="text-2xl font-semibold text-primary">Educational Resources</h2>
                </div>
                <p class="text-text/70 mb-6 leading-relaxed">
                    Comprehensive guides, tutorials, and educational materials to help you master culinary techniques and expand your cooking knowledge.
                </p>
                <ul class="space-y-3 mb-6 flex-1">
                    <li class="flex items-center text-text/60 gap-3">
                        <i data-lucide="check-circle" class="w-4 h-4 text-secondary mr-3"></i>
                        Cooking technique guides
                    </li>
                    <li class="flex items-center text-text/60 gap-3">
                        <i data-lucide="check-circle" class="w-4 h-4 text-secondary mr-3"></i>
                        Ingredient encyclopedias
                    </li>
                    <li class="flex items-center text-text/60 gap-3">
                        <i data-lucide="check-circle" class="w-4 h-4 text-secondary mr-3"></i>
                        Video tutorials
                    </li>
                    <li class="flex items-center text-text/60 gap-3">
                        <i data-lucide="check-circle" class="w-4 h-4 text-secondary mr-3"></i>
                        Nutrition information
                    </li>
                </ul>
                <x-button 
                    :variant="\App\Enums\ButtonVariant::Primary"
                    :size="\App\Enums\ButtonSize::Medium"
                    :text="'Explore Educational Resources'"
                    :icon="'<i data-lucide=\'arrow-right\' class=\'w-4 h-4\'></i>'"
                    onclick="window.location.href='{{ route('resources.edu') }}'"
                    class="cursor-pointer mt-auto"
                />
            </div>

            {{-- Culinary Tools Card --}}
            <div class="animate-fade-in-up flex flex-col bg-white/30 border-2 border-dashed border-primary/20 rounded-2xl p-8" style="animation-delay: 0.2s;">
                <div class="flex items-center mb-6 gap-3">
                    <div class="w-12 h-12 bg-secondary/10 rounded-full flex items-center justify-center mr-4">
                        <i data-lucide="chef-hat" class="w-6 h-6 text-secondary"></i>
                    </div>
                    <h2 class="text-2xl font-semibold text-primary">Culinary Resources</h2>
                </div>
                <p class="text-text/70 mb-6 leading-relaxed">
                    Professional-grade tools and equipment recommendations to equip your kitchen with everything needed for culinary excellence.
                </p>
                <ul class="space-y-3 mb-6 flex-1">
                    <li class="flex items-center text-text/60 gap-3">
                        <i data-lucide="check-circle" class="w-4 h-4 text-secondary mr-3"></i>
                        Kitchen equipment guides
                    </li>
                    <li class="flex items-center text-text/60 gap-3">
                        <i data-lucide="check-circle" class="w-4 h-4 text-secondary mr-3"></i>
                        Tool recommendations
                    </li>
                    <li class="flex items-center text-text/60 gap-3">
                        <i data-lucide="check-circle" class="w-4 h-4 text-secondary mr-3"></i>
                        Maintenance guides
                    </li>
                    <li class="flex items-center text-text/60 gap-3">
                        <i data-lucide="check-circle" class="w-4 h-4 text-secondary mr-3"></i>
                        Budget-friendly alternatives
                    </li>
                </ul>
                <x-button 
                    :variant="\App\Enums\ButtonVariant::Secondary"
                    :size="\App\Enums\ButtonSize::Medium"
                    :text="'Browse Culinary Tools'"
                    :icon="'<i data-lucide=\'arrow-right\' class=\'w-4 h-4\'></i>'"
                    onclick="window.location.href='{{ route('resources.culinary') }}'"
                    class="cursor-pointer mt-auto"
                />
            </div>
        </div>

        {{-- Quick Access Section --}}
        <div class="animate-fade-in-up bg-primary/10 border-2 border-dashed border-primary/20 rounded-2xl p-8" style="animation-delay: 0.3s;">
            <h3 class="text-2xl font-semibold text-primary mb-6 text-center">Popular Downloads</h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white/30 rounded-2xl p-6 text-center border-2 border-dashed border-primary/20">
                    <div class="w-full h-24 mb-4 rounded-2xl overflow-hidden">
                        <img src="{{ asset('images/default-card.webp') }}" alt="Cooking Basics Guide" class="w-full h-full object-cover">
                    </div>
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="file-text" class="w-6 h-6 text-primary"></i>
                    </div>
                    <h4 class="font-semibold text-primary mb-2">Cooking Basics Guide</h4>
                    <p class="text-text/60 text-sm mb-4">Essential techniques for beginners</p>
                                        <a href="{{ asset('images/default-card.webp') }}" download="nutrition-guide.webp" class="text-primary text-sm font-medium hover:underline cursor-pointer">Download Image</a>
                </div>
                
                <div class="bg-white/30 rounded-2xl p-6 text-center border-2 border-dashed border-primary/20">
                    <div class="w-full h-24 mb-4 rounded-2xl overflow-hidden">
                        <img src="{{ asset('images/default-card.webp') }}" alt="Conversion Chart" class="w-full h-full object-cover">
                    </div>
                    <div class="w-12 h-12 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="calculator" class="w-6 h-6 text-secondary"></i>
                    </div>
                    <h4 class="font-semibold text-primary mb-2">Conversion Chart</h4>
                    <p class="text-text/60 text-sm mb-4">Measurements and temperatures</p>
                    <a href="{{ asset('images/default-card.webp') }}" download="conversion-chart.webp" class="text-primary text-sm font-medium hover:underline cursor-pointer">Download Image</a>
                </div>
                
                <div class="bg-white/30 rounded-2xl p-6 text-center border-2 border-dashed border-primary/20">
                    <div class="w-full h-24 mb-4 rounded-2xl overflow-hidden">
                        <img src="{{ asset('images/default-card.webp') }}" alt="Shopping Lists" class="w-full h-full object-cover">
                    </div>
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="shopping-cart" class="w-6 h-6 text-primary"></i>
                    </div>
                    <h4 class="font-semibold text-primary mb-2">Shopping Lists</h4>
                    <p class="text-text/60 text-sm mb-4">Organized grocery templates</p>
                    <a href="{{ asset('images/default-card.webp') }}" download="shopping-lists.webp" class="text-primary text-sm font-medium hover:underline cursor-pointer">Download Image</a>
                </div>
                
                <div class="bg-white/30 rounded-2xl p-6 text-center border-2 border-dashed border-primary/20">
                    <div class="w-full h-24 mb-4 rounded-2xl overflow-hidden">
                        <img src="{{ asset('images/default-card.webp') }}" alt="Meal Planner" class="w-full h-full object-cover">
                    </div>
                    <div class="w-12 h-12 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="calendar" class="w-6 h-6 text-secondary"></i>
                    </div>
                    <h4 class="font-semibold text-primary mb-2">Meal Planner</h4>
                    <p class="text-text/60 text-sm mb-4">Weekly planning template</p>
                                                            <a href="{{ asset('images/default-card.webp') }}" download="recipe-collection.webp" class="text-primary text-sm font-medium hover:underline cursor-pointer">Download Image</a>
                </div>
            </div>
        </div>
    </section>
@endsection