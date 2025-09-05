@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;

    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Cookbook', 'url' => '/blogs']
    ];

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
<section class="w-full flex flex-col p-5 mb-16">
    <section class="animate-on-scroll w-full mb-6" data-delay="0.1s">
        
        <div class="max-w-2xl mx-auto mb-6">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-search text-gray-400"></i>
                </div>
                <input type="text" 
                       class="block w-full pl-10 pr-12 py-3 border border-primary/30 rounded-lg bg-secondary/10 focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-300" 
                       placeholder="Search for cooking tips, recipes, and more..."
                       disabled>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button class="bg-primary text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary/90 transition-colors duration-300" disabled>
                        Search
                    </button>
                </div>
            </div>
        </div>
    </section>
    
    <section class="w-full">
        @if (count($blogs) > 0)
            <div class="animate-on-scroll mb-6 text-center" data-delay="0.2s">
                <p class="text-sm text-text/60">
                    Found {{ $pagination['total_items'] }} blog {{ $pagination['total_items'] === 1 ? 'post' : 'posts' }}
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 mb-12">
                @foreach ($blogs as $index => $blog)
                    <div class="animate-on-scroll" data-delay="{{ getDelayTime($index) }}s">
                        <x-blog-card :blog="$blog" />
                    </div>
                @endforeach
            </div>

            <div class="flex flex-col w-full gap-4">
                <p class="text-sm text-text/60 w-full flex items-center justify-center text-center font-medium">
                    Showing page {{ $pagination['current_page'] }} of {{ $pagination['total_pages'] }}
                    <span class="mx-2">•</span>
                    {{ $pagination['total_items'] }} total {{ $pagination['total_items'] === 1 ? 'post' : 'posts' }}
                </p>
                <x-paginator 
                    :current-page="$pagination['current_page']" 
                    :total-pages="$pagination['total_pages']" 
                    :total-items="$pagination['total_items']" 
                    :has-prev="$pagination['has_previous_page']" 
                    :has-next="$pagination['has_next_page']"
                    :base-url="route('blogs.index')"
                    :preserve-params="[]"
                    :max-buttons="5"
                />
            </div>
        @else
            <div class="flex flex-col items-center justify-center min-h-[60vh] text-center">
                <div class="text-8xl text-primary/30 mb-6 animate-pulse">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div class="max-w-md">
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
    </section>
</section>
@endsection