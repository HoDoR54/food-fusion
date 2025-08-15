@php
    $recipe = $res->getData();

    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Recipes', 'url' => '/recipes'],
        ['label' => $recipe->name, 'url' => '/recipes/' . $recipe->id],
    ];
@endphp

@extends('layout.index')

@section('title', $recipe->name)

@section('content')
    <section class="flex flex-col gap-3">
        <div class="grid md:grid-cols-2 gap-3 p-5">
            <div class="flex justify-center items-center rounded-2xl border-4 border-primary/20 border-dashed relative">
                <div class="absolute bottom-0 left-0 top-0 min-w-32 opacity-0 hover:opacity-80 transition-opacity bg-gradient-to-r text-white from-black/50 via-black/20 to-transparent flex items-center justify-center">
                    <i data-lucide='chevron-left' class="cursor-pointer"></i>
                </div>
                <img src="{{ asset('images/example-recipe.jpg') }}" alt="{{ $recipe->name }}" class="w-full h-auto object-cover">
                <div class="absolute bottom-0 right-0 top-0 min-w-32 opacity-0 hover:opacity-80 transition-opacity bg-gradient-to-l text-white from-black/50 via-black/20 to-transparent flex items-center justify-center">
                    <i data-lucide='chevron-right' class="cursor-pointer"></i>
                </div>
            </div>
            <div class="p-5">
                <div class="flex flex-col gap-2">
                    <h2 class="text-3xl font-bold text-primary">{{ $recipe->name }}</h2>
                    <p class="text-gray-600">{{ $recipe->description }}</p>
                </div>
            </div>
            
        </div>
    </section>
@endsection
