@php
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'About', 'url' => '/about']
    ];
@endphp

@extends('layout.index')

@section('title', 'About Us')

@section('content')
    <div class="container text-center w-full flex items-center justify-center flex-col">
        <h1 class="text-[2rem] font-bold mb-4">About Us</h1>
        <p class="text-lg text-text/60">Welcome to our website! We are dedicated to providing the best service possible.</p>
    </div>
@endsection