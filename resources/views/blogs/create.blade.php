@php
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Cookbook', 'url' => '/blogs'],
        ['label' => 'Share Your Recipe', 'url' => '/blogs/new-post']
    ]
@endphp

@extends('layout.index')
@section('title', 'Share Your Recipe')

@section('content')
    <div class="container text-center w-full flex items-center justify-center flex-col">
        <h1 class="text-[2rem] font-bold mb-4">Share Your Recipe</h1>        
    </div>
@endsection