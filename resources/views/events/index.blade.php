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
        <h1 class="animate-on-scroll text-3xl font-bold" data-delay="0.1s">Upcoming Events</h1>
        
        <ul class="flex flex-col gap-3 py-3 px-5">
            @foreach ($response as $index => $item)
                <li class="animate-on-scroll text-blue-500 hover:underline" data-delay="{{ ($index * 0.1) + 0.2 }}s">
                    <a href="{{ route('events.show', ['id' => $item['event']->id]) }}">{{ $item['event']->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection