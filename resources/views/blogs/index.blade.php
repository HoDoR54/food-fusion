@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;

    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Cookbook', 'url' => '/blogs']
    ];

    $data = $res->getData();
    $items = $data->getItems();
    $pagination = $data->getPagination();
@endphp

@extends('layout.index')
@section('title', $title)

@section('content')
<section class="w-full flex flex-col p-5 mb-16">
    <section class="w-full mb-4">
        <h1 class="text-3xl font-bold text-text mb-4">Community Cookbook</h1>
        <p class="text-text/70 mb-6">Discover amazing recipes and cooking tips from our community</p>
    </section>
    
    <section class="w-full">
        @if (count($items) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($items as $item)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">
                                <a href="{{ route('blogs.show', $item['blog']->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 hover:underline">
                                    {{ $item['blog']->title }}
                                </a>
                            </h3>
                            @if($item['blog']->content)
                                <p class="text-gray-600 mb-4">{{ Str::limit(strip_tags($item['blog']->content), 150) }}</p>
                            @endif
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                @if($item['blog']->author)
                                    <span>By {{ $item['blog']->author->name }}</span>
                                @endif
                                <span>{{ $item['blog']->created_at->format('M j, Y') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex flex-col w-full gap-3">
                <p class="text-sm text-gray-600 w-full flex items-center justify-center text-center">
                    Showing {{ $pagination['current_page'] }} of {{ $pagination['total_pages'] }} pages
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
            <div class="flex flex-col items-center justify-center min-h-[60vh]">
                <p class="text-red-500/70 text-2xl font-semibold">No blogs found.</p>
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800 hover:underline text-sm flex items-center gap-1 mt-2">
                    <i data-lucide="arrow-left"></i>
                    Back to home
                </a>
            </div>
        @endif
    </section>
</section>
@endsection