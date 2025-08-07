@php
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Create A New Account', 'url' => '/register']
    ]
@endphp

@extends('layout.index')
@section('title', 'Create A New Account')

@section('content')
    <div class="container text-center w-full flex items-center justify-center flex-col">
        <h1 class="text-[2rem] font-bold mb-4">Create A New Account</h1>        
    </div>
@endsection