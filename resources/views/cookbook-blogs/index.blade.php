@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;

    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Cookbook', 'url' => '/cookbook']
    ];
@endphp

@extends('layout.index')
@section('title', 'Community Cookbook')

@section('content')
    <div class="container text-center w-full flex items-center justify-center flex-col">
        <h1 class="text-3xl font-bold mb-6">Community Cookbook</h1>
        <a href="{{ url('cookbook/new-post') }}" class="mb-4">
            <x-button :variant="ButtonVariant::Primary" :size="ButtonSize::Medium" :text="'Share Your Recipe'"></x-button>
        </a>
    </div>
@endsection