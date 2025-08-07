@php
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Log In To Your Account', 'url' => '/login']
    ]
@endphp

@extends('layout.index')
@section('title', 'Log In To Your Account')

@section('content')
    <div class="container text-center w-full flex items-center justify-center flex-col">
        <h1 class="text-[2rem] font-bold mb-4">Log In To Your Account</h1>        
    </div>
@endsection