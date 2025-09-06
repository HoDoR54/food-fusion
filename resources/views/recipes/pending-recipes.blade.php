@php
    $recipes = $res->getData()->getItems();
    $pagination = $res->getData()->getPagination();
@endphp

@extends('layout.admin')
@section('title', 'Pending Recipes')

@section('content')
    <h1 class="text-2xl font-bold">Pending Recipes</h1>
    
    @if(empty($recipes))
        <p>No pending recipes found.</p>
    @else
        <ul class="flex flex-col w-full">
            {{-- TO-DO: get rid of this god damn resposne structure (It doesn't make sense) --}}
            @foreach ($recipes as $recipeData)
                @php
                    $recipe = $recipeData['recipe'];
                @endphp
                <li class="flex gap-3 items-center justify-between border-b border-gray-300 py-2 px-3">
                    <strong>{{ $recipe->name }}</strong> - 
                    <a href="{{ route('recipes.show', ['id' => $recipe->id]) }}">View Recipe</a>
                    <div class="flex gap-2">
                        <form id="reject-{{ $recipe->id }}">
                            @csrf
                            <button type="submit" class="text-red-500 flex items-center justify-center gap-3 hover:underline hover:text-red-700 cursor-pointer">
                                <i data-lucide="x" class="w-4 h-4"></i>
                                Reject
                            </button>
                        </form>
                        <form id="approve-{{ $recipe->id }}">
                            @csrf
                            <button type="submit" class="text-green-500 flex items-center justify-center gap-3 hover:underline hover:text-green-700 cursor-pointer">
                                <i data-lucide="check" class="w-4 h-4"></i>
                                Approve
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
@endsection