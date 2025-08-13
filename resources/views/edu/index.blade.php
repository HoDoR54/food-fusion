@php
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Educational Resources', 'url' => '/educational-resources']
    ];
@endphp

@extends('layout.index')

@section('title', 'Educational Resources')

@section('content')
    <div class="container text-center w-full flex items-center justify-center flex-col">
        <h1 class="text-[2rem] font-bold mb-4">Educational Resources</h1>
        <p class="text-lg text-gray-700">Explore our collection of educational materials and resources.</p>
    </div>
@endsection