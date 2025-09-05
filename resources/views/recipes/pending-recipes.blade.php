@php
    use Illuminate\Support\Facades\Log;

    $recipes = $res->getData()->getItems();
    $pagination = $res->getData()->getPagination();
    Log::info('Recipes in View:', $recipes);
@endphp

@extends('layout.admin')
@section('title', 'Pending Recipes')

@section('content')
    <h1 class="text-2xl font-bold">Pending Recipes</h1>
    
    @if(empty($recipes))
        <p>No pending recipes found.</p>
    @else
        <ul>
            @foreach ($recipes as $recipeData)
                @php
                    $recipe = $recipeData['recipe'];
                    Log::info('Recipe Data:', ['recipe' => $recipe]);
                @endphp
                <li>
                    <strong>{{ $recipe->name }}</strong> - 
                    by {{ $recipe->postedBy->first_name }} {{ $recipe->postedBy->last_name }} - 
                    {{ $recipe->difficulty }} difficulty - 
                    {{ $recipe->servings }} servings
                </li>
            @endforeach
        </ul>
    @endif
@endsection