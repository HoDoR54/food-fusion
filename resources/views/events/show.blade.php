@php
    use App\Enums\VenueType;
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;

    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Events', 'url' => '/events'],
        ['label' => $event->name, 'url' => '/events/' . $event->id]
    ];
@endphp

@extends('layout.index')

@section('title', $event->name . ' - Event Details')

@section('content')
    <section id="event-details" data-event-id="{{ $event->id }}" class="flex items-center justify-center pb-16">
        <section class="flex flex-col min-w-[50vw] lg:max-w-[60vw] gap-5">
            {{-- overall section --}}
            <div class="w-full grid grid-cols-3 animate-fade-in-up">
                <div class="flex flex-col p-3 justify-start items-start gap-2 md:col-span-2 relative">
                    <div class="absolute top-3 right-3 p-1 rounded-full flex gap-2">
                        @auth
                            @if(!$event->attendees->contains(auth()->user()) && $event->status->value === 'scheduled')
                                <button data-event-id="{{ $event->id }}" class="event-bookmark-button border-text/60 text-text/60 p-1 rounded border cursor-pointer hover:border-secondary hover:text-secondary">
                                    <i data-lucide="bookmark" class="w-4 h-4 bookmark-icon"></i>
                                </button>
                            @endif
                        @endauth
                        <button class="event-share-button border-text/60 text-text/60 p-1 rounded border cursor-pointer hover:border-secondary hover:text-secondary">
                            <i data-lucide="share-2" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <h1 class="text-primary text-3xl font-bold">{{ $event->name }}</h1>
                    <div class="flex gap-2 flex-wrap">
                        <div class="bg-{{ $event->type->value === 'gathering' ? 'primary' : 'secondary' }}/20 border-2 border-primary/20 rounded-full px-2 py-1 border-dashed text-xs">
                            {{ ucfirst(str_replace('-', ' ', $event->type->value)) }}
                        </div>
                        <div class="bg-secondary/20 border-2 border-primary/20 rounded-full px-2 py-1 border-dashed text-xs">
                            {{ $event->venue_type === VenueType::ONLINE ? 'Online' : 'In-Person' }}
                        </div>
                        <div class="bg-secondary/20 border-2 border-primary/20 rounded-full px-2 py-1 border-dashed text-xs">
                            {{ ucfirst($event->status->value) }}
                        </div>
                    </div>
                    <h3 class="text-primary text-sm">Organized by <a class="font-medium hover:underline hover:text-secondary cursor-pointer">{{ $event->organizer->name }}</a></h3>
                    <p class="text-text/60 text-xs">{{ $event->created_at->format('F j, Y') }} • {{ $event->attendees_count }} registered</p>
                </div>
                <div class="flex justify-end items-center">
                    <img 
                        src="{{ $event->image_url ?? asset('images/example-recipe.jpg') }}" 
                        alt="{{ $event->name }}" 
                        class="h-40 w-auto object-cover rounded-2xl border-2 border-dashed border-primary/20"
                    >
                </div>
            </div>

            {{-- description section --}}
            <div class="flex flex-col gap-3 py-5 px-8 bg-primary/10 rounded-2xl border-dashed border-2 border-primary/20 animate-fade-in-up" style="animation-delay: 0.1s;">
                <h2 class="text-primary text-xl font-semibold">About this event</h2>
                <p class="text-text/60">
                    {{ $event->description }}
                </p>
            </div>

            {{-- attributes section --}}
            <div class="grid md:grid-cols-4 grid-cols-2 gap-3 min-h-32">
                <div class="flex items-center p-3 justify-center flex-col bg-white/30 rounded-2xl border-2 border-primary/20 border-dashed animate-fade-in-up" style="animation-delay: 0.2s;">
                    <i data-lucide="calendar" class="text-secondary mb-3"></i>
                    <span class="text-text/60">Date</span>
                    <span class="text-text font-semibold text-xl">{{ $event->start_time->format('M j') }}</span>
                </div>
                <div class="flex items-center p-3 justify-center flex-col bg-white/30 rounded-2xl border-2 border-primary/20 border-dashed animate-fade-in-up" style="animation-delay: 0.3s;">
                    <i data-lucide="clock" class="text-secondary mb-3"></i>
                    <span class="text-text/60">Time</span>
                    <span class="text-text font-semibold text-xl">{{ $event->start_time->format('g:i A') }}</span>
                </div>
                <div class="flex items-center p-3 justify-center flex-col bg-white/30 rounded-2xl border-2 border-primary/20 border-dashed animate-fade-in-up" style="animation-delay: 0.4s;">
                    <i data-lucide="{{ $event->venue_type === VenueType::ONLINE ? 'monitor' : 'map-pin' }}" class="text-secondary mb-3"></i>
                    <span class="text-text/60">Location</span>
                    <span class="text-text font-semibold text-md text-center">
                        @if($event->venue_type === VenueType::ONLINE)
                            {{ $event->platform }}
                        @else
                            {{ $event->location }}
                        @endif
                    </span>
                </div>
                <div class="flex items-center p-3 justify-center flex-col bg-white/30 rounded-2xl border-2 border-primary/20 border-dashed animate-fade-in-up" style="animation-delay: 0.5s;">
                    <i data-lucide="users" class="text-secondary mb-3"></i>
                    <span class="text-text/60">Registered</span>
                    <span class="text-text font-semibold text-xl">{{ $event->attendees_count }}</span>
                </div>
            </div>

            {{-- attendees section --}}
            <div class="flex flex-col gap-3">
                <div class="border-b-3 border-dashed border-primary/20 w-full flex py-3 items-center justify-between">
                    <h1 class="text-primary text-2xl font-semibold">Who's Coming?</h1>
                    @if($event->attendees_count > 8)
                        <a class="flex items-center gap-2 hover:text-secondary hover:underline cursor-pointer">
                            See all
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    @endif
                </div>

                <div id="event-attendees-grid" class="grid md:grid-cols-4 gap-3">
                    @forelse($event->attendees->take(8) as $attendee)
                        <div class="border-2 border-dashed border-primary/20 rounded-lg overflow-hidden bg-white/30 flex flex-col">
                            <div class="w-full py-5 flex items-center justify-center">
                                <img 
                                    src="{{ $attendee->profile_image ?? '/images/default-profile.webp' }}" 
                                    alt="{{ $attendee->name }}" 
                                    class="rounded-full border-primary/20 border-2 border-dashed w-24 h-24 object-cover"
                                >
                            </div>
                            <div class="py-3 px-3 flex flex-col gap-1 items-center justify-center">
                                <span class="text-sm font-semibold text-primary text-center">{{ $attendee->name }}</span>
                                <span class="text-xs text-text/60">Registered</span>
                            </div>
                        </div>
                    @empty
                        <div id="no-attendees-message" class="md:col-span-4 col-span-2">
                            <div class="rounded-lg p-8 text-center">
                                <i data-lucide="users" class="w-12 h-12 text-secondary/60 mx-auto mb-3"></i>
                                <p class="text-text/60">No one has registered yet!</p>
                                <p class="text-text/60 text-sm">Be the first to join this event.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                
                {{-- Registration Section --}}
                <div class="flex items-center justify-center flex-col gap-4 py-4">
                    @auth
                        @if($event->status->value === 'scheduled')
                            @if(!$event->attendees->contains(auth()->user()))
                                <p class="text-text/60 text-base">Ready to join {{ $event->attendees_count }} other participants?</p>
                                <form id="event-registration-form" class="w-full max-w-md">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <x-button 
                                        type="submit" 
                                        :variant="ButtonVariant::Secondary" 
                                        :size="ButtonSize::Large" 
                                        :text="'Register for Event'" 
                                        class="w-full cursor-pointer" 
                                        :icon="'<i data-lucide=\'calendar-plus\'></i>'" 
                                    />
                                </form>
                            @else
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-secondary/20 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i data-lucide="check-circle" class="w-8 h-8 text-secondary"></i>
                                    </div>
                                    <p class="text-secondary font-semibold text-lg">You're Registered!</p>
                                    <p class="text-text/60 text-sm">We'll send you event updates and reminders.</p>
                                </div>
                            @endif
                        @elseif($event->status->value === 'completed')
                            <div class="text-center">
                                <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i data-lucide="calendar-check" class="w-8 h-8 text-primary"></i>
                                </div>
                                <p class="text-primary font-semibold text-lg">Event Completed</p>
                                <p class="text-text/60 text-sm">This event has already taken place.</p>
                            </div>
                        @else
                            <div class="text-center">
                                <div class="w-16 h-16 bg-text/20 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i data-lucide="calendar-x" class="w-8 h-8 text-text/60"></i>
                                </div>
                                <p class="text-text/70 font-semibold text-lg">Registration Closed</p>
                                <p class="text-text/60 text-sm">This event is no longer accepting registrations.</p>
                            </div>
                        @endif
                    @else
                        <p class="text-text/60 text-base">Want to join this event?</p>
                        <a href="{{ route('auth.login.show') }}" class="w-full max-w-md">
                            <x-button 
                                :variant="ButtonVariant::Secondary" 
                                :size="ButtonSize::Large" 
                                :text="'Login to Register'" 
                                class="w-full cursor-pointer" 
                                :icon="'<i data-lucide=\'log-in\'></i>'" 
                            />
                        </a>
                    @endauth
                </div>
            </div>

        </section>
    </section>

    @if(auth()->check())
        <script>
            window.currentUser = {
                name: @json(auth()->user()->name),
                username: @json(auth()->user()->username ?? ''),
                id: @json(auth()->user()->id)
            };
        </script>
    @endif
@endsection