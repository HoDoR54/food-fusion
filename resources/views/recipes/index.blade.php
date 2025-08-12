@php
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Recipes', 'url' => '/recipes'],
    ];

    $items = $res->getData();
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
            <div class="w-full bg-primary/50 rounded-2xl min-h-[3rem] text-white flex items-center justify-center">
                Pagination
            </div>
        </div>
    </section>
@endsection