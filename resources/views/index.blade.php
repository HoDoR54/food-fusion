@extends('layout.index')

@section('title', $title)

@section('content')
    <h1>Welcome to Food Fusion</h1>
    <p>Your one-stop destination for delicious recipes.</p>

    <a href="{{ route('recipes.index', ['page' => 3, 'size' => 2]) }}" class="text-blue-400 hover:text-blue-600 hover:underline">Recipes Page</a>
@endsection