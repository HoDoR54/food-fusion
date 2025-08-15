@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();

    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Profile', 'url' => '/profile'],
    ];
@endphp

@extends('layout.index')
@section('title', 'Food Fusion - ' . ($user->name ?? 'Profile'))

@section('content')
    <section class="flex flex-col p-5">
        <div class="mx-auto container">
            <h1 class="text-2xl font-bold mb-4">Profile</h1>

            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">User Information</h2>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Joined:</strong> {{ $user->created_at->format('F j, Y') }}</p>
            </div>
        </div>
    </section>
@endsection

