@extends('layout.index')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    <ul>
        @foreach ($paginatedRecipes->items as $recipe)
            <li>
                <x-recipe-card :recipe="$recipe" />
                <a href="{{ route('recipes.show', $recipe->id) }}" class="text-blue-500 hover:underline">View Recipe</a>
            </li>
        @endforeach
    </ul>
@endsection
