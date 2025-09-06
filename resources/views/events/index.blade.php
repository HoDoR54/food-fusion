@php
    use Illuminate\Support\Facades\Log;
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Events', 'url' => '/events'],
    ];
@endphp

@extends('layout.index')

@section('title', $title ?? 'Events')

@section('content')
    <div class="events">
        <h1 class="animate-on-scroll text-3xl font-bold" data-delay="0.1s">Upcoming Events</h1>
        
        <ul class="flex flex-col gap-3 py-3 px-5">
            @foreach ($events as $event)
                <li class="animate-on-scroll text-blue-500 hover:underline" data-delay="{{ ($loop->index * 0.1) + 0.2 }}s">
                    <a href="{{ route('events.show', ['id' => $event['id']]) }}">{{ $event['name'] }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection