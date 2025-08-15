@php
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Contact', 'url' => '/contact']
    ];
@endphp

@extends('layout.index')

@section('title', 'Contact Us')

@section('content')
    <div class="container text-center w-full flex items-center justify-center flex-col">
        <h1 class="text-[2rem] font-bold mb-4">Contact Us</h1>
        <p class="text-lg text-text/60">Get in touch with us for any inquiries or support.</p>
    </div>
@endsection