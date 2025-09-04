@php
    use Illuminate\Support\Facades\Auth;
    use App\Enums\ButtonSize;
    use App\Enums\ButtonVariant;

    $currentUser = Auth::user();
    $displayUser = $profileUser ?? $currentUser;

    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Profile', 'url' => '/profile'],
    ];
@endphp

@extends('layout.index')
@section('title', 'Food Fusion - ' . ($displayUser->name ?? 'Profile'))

@section('content')
    <section class="flex flex-col p-5">
        <div class="mx-auto container">
            <h1 class="text-4xl font-bold mb-6 animate-fade-in-up">
                @if($displayUser->id === $currentUser?->id)
                    My Profile
                @else
                    {{ $displayUser->name }}'s Profile
                @endif
            </h1>

            <div class="bg-white shadow rounded-lg p-6 animate-fade-in-up" style="animation-delay: 0.1s;">
                <h2 class="text-2xl font-semibold mb-4">User Information</h2>
                <p class="animate-fade-in-up" style="animation-delay: 0.2s;"><strong>Name:</strong> {{ $displayUser->name }}</p>
                <p class="animate-fade-in-up" style="animation-delay: 0.3s;"><strong>Username:</strong> {{ $displayUser->username }}</p>
                <p class="animate-fade-in-up" style="animation-delay: 0.4s;"><strong>Email:</strong> {{ $displayUser->email }}</p>
                <p class="animate-fade-in-up" style="animation-delay: 0.5s;"><strong>Joined:</strong> {{ $displayUser->created_at->format('F j, Y') }}</p>
                <p class="animate-fade-in-up" style="animation-delay: 0.6s;"><strong>Mastery Level:</strong> {{ $displayUser->mastery_level->value }}</p>
                @if ($displayUser->id === $currentUser?->id)
                    <div class="animate-fade-in-up" style="animation-delay: 0.7s;">
                        <x-button :variant="ButtonVariant::Primary" :size="ButtonSize::Large" :text="'Log out'" class="w-full mt-3"/>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

