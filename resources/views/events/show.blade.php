@php
    use App\Enums\VenueType;



    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Events', 'url' => '/events'],
        ['label' => $event->name, 'url' => '/events/' . $event->id]
    ];
@endphp

@extends('layout.index')

@section('title', 'Event Details')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-3">{{ $event->name }}</h1>

        <p><strong>Description:</strong> {{ $event->description }}</p>
        <p><strong>Organizer:</strong> {{ $event->organizer->name }}</p>
        <p><strong>Start Time:</strong> {{ $event->start_time->format('F j, Y, g:i A') }}</p>
        <p><strong>End Time:</strong> {{ $event->end_time->format('F j, Y, g:i A') }}</p>
        <p><strong>Status:</strong> {{ $event->status->value }}</p>
        <p><strong>Type:</strong> {{ $event->type->value }}</p>
        <p><strong>Venue:</strong> 
            @if($event->venue_type === VenueType::ONLINE)
                Online ({{ $event->platform }})
            @else
                {{ $event->location }}
            @endif
        </p>
        <p><strong>Attendees:</strong> {{ $event->attendees_count }}</p>


    </div>
@endsection