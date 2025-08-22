@php
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Cookbook', 'url' => '/cookbook'],
        ['label' => $blog->title, 'url' => '/cookbook/' . $blog->id],
    ];
@endphp

@extends('layout.index')

@section('title', $blog->title)

@section('content')
    <h1 class="text-3xl font-bold mb-4">{{ $blog->title }}</h1>
    <div class="mb-4">
        <strong>Author:</strong> {{ $blog->author->name }}
    </div>
    <div class="mb-4">
        <strong>Content:</strong>
        <p>{{ $blog->content }}</p>
    </div>
@endsection