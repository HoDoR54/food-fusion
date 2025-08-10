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
    <section class="w-full mb-4 min-h-[4rem] bg-primary/30 flex items-center justify-center text-text">
        Imaginary Search Bar
    </section>
    <section class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <div  class="bg-secondary/40 text-text flex items-center justify-center p-3">
            Imaginary Filter Options
        </div>
        <ul class="grid grid-cols-1 lg:grid-cols-3 p-3 gap-4 md:col-span-2 lg:col-span-3">
            @foreach ($items as $item)
                <li>
                    <livewire:recipe-card 
                        :recipe-id="$item['recipe']->id"
                        wire:key="recipe-card-{{ $item['recipe']->id }}"
                    />
                </li>
            @endforeach
        </ul>
    </section>
@endsection