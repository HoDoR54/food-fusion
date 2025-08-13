@php
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Recipes', 'url' => '/recipes'],
    ];

    $data = $res->getData();
    $items = $data->getItems();
    $pagination = $data->getPagination();
@endphp

@extends('layout.index')

@section('title', $title)

@section('content')
    <section class="w-full mb-4 rounded-2xl flex items-center justify-center text-text">
        <x-recipe-search-bar />
    </section>
    <section class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <div  class="flex flex-col gap-3">
            <div class="w-full h-[500px] rounded-2xl bg-primary/20 text-text flex items-center justify-center">
                Something Cool Here
            </div>
        </div>
        @if (count($items) > 0)
            <div class="md:col-span-2 lg:col-span-3 flex flex-col pl-3 gap-3">
                <x-recipe-filters />
                <ul class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    @foreach ($items as $item)
                        <li>
                            <livewire:recipe-card 
                                :recipe-id="$item['recipe']->id"
                                wire:key="recipe-card-{{ $item['recipe']->id }}"
                            />
                        </li>
                    @endforeach
                </ul>
                <div class="flex flex-col w-full gap-3">
                    <p class="text-sm text-gray-500 w-full flex items-center justify-center text-center">
                        Showing {{ $pagination['current_page'] }} of {{ $pagination['total_pages'] }} pages
                    </p>
                    <x-paginator 
                        :current-page="$pagination['current_page']" 
                        :total-pages="$pagination['total_pages']" 
                        :total-items="$pagination['total_items']" 
                        :has-prev="$pagination['has_previous_page']" 
                        :has-next="$pagination['has_next_page']"
                        :base-url="route('recipes.index')"
                        :preserve-params="['search_term', 'difficulty_level', 'dietary_preference', 'cuisine_type', 'course', 'order_by']"
                        :max-buttons="5"
                    />
                </div>
                
            </div>
        @else
            <div class="md:cols-span-2 lg:col-span-3 flex flex-col items-center justify-center pl-3 gap-3">
                <p class="text-red-500/70 text-2xl font-semibold">No match found.</p>
                <a href="{{ route('recipes.index') }}" class="text-gray-700/70 hover:text-gray-700 hover:underline text-sm flex items-center gap-1">
                    <i data-lucide="arrow-left"></i>
                    See all recipes
                </a>
            </div>
        @endif
        
    </section>
@endsection