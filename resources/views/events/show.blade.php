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

        @auth
            @if(!$event->attendees->contains(auth()->user()))
                <div class="mt-6">
                    <form id="event-registration-form" class="inline-block">
                        @csrf
                        <input type="hidden" name="eventId" value="{{ $event->id }}">
                        <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                            Register for Event
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-6">
                    <p class="text-green-600 font-semibold">✓ You are already registered for this event</p>
                </div>
            @endif
        @else
            <div class="mt-6">
                <p class="text-gray-600">
                    <a href="{{ route('auth.login.show') }}" class="text-primary hover:underline">Login</a> 
                    to register for this event
                </p>
            </div>
        @endauth


    </div>
@endsection