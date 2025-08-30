@php
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Events', 'url' => '/events'],
    ];

    $response = $res->getData();
@endphp

@extends('layout.index')

@section('title', $title ?? 'Events')

@section('content')
    <div class="events">
        <h1 class="text-3xl font-bold">Upcoming Events</h1>
        
        <ul class="flex flex-col gap-3 py-3 px-5">
            @foreach ($response as $item)
                <li class="text-blue-500 hover:underline">
                    <a href="{{ route('events.show', ['id' => $item['event']->id]) }}">{{ $item['event']->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection