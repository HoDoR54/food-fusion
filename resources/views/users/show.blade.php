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
            <h1 class="text-4xl font-bold mb-6">
                @if($displayUser->id === $currentUser?->id)
                    My Profile
                @else
                    {{ $displayUser->name }}'s Profile
                @endif
            </h1>

            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4">User Information</h2>
                <p><strong>Name:</strong> {{ $displayUser->name }}</p>
                <p><strong>Username:</strong> {{ $displayUser->username }}</p>
                <p><strong>Email:</strong> {{ $displayUser->email }}</p>
                <p><strong>Joined:</strong> {{ $displayUser->created_at->format('F j, Y') }}</p>
                <p><strong>Mastery Level:</strong> {{ $displayUser->mastery_level->value }}</p>
                @if ($displayUser->id === $currentUser?->id)
                    <x-button :variant="ButtonVariant::Primary" :size="ButtonSize::Large" :text="'Log out'" class="w-full mt-3"/>
                @endif
            </div>
        </div>
    </section>
@endsection

