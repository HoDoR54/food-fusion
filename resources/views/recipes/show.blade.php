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
    <div>
        <h1>{{ $recipe->name }}</h1>
        <p>{{ $recipe->description }}</p>
    </div>
@endsection
