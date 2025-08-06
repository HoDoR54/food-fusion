@extends('index')

@section('title', $recipe->name)

@section('content')
    <h1>{{ $recipe->name }}</h1>
    <p>{{ $recipe->description }}</p>
@endsection
