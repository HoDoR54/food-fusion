@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $sessionValue = session('isPopUpConsent', true);
    
    if ($sessionValue === 'false' || $sessionValue === false || $sessionValue === 0) {
        $isPopUpConsent = false;
    } elseif ($sessionValue === 'true' || $sessionValue === true || $sessionValue === 1) {
        $isPopUpConsent = true;
    } else {
        $isPopUpConsent = (bool) $sessionValue;
    }
@endphp

@extends('layout.index')

@section('title', 'Food Fusion')

@if (!$user && $isPopUpConsent)
    @section('pop-up')
        <livewire:register-form :isPopUp="true"/>
    @endsection
@endif

@section('content')
    <section class="w-full flex flex-col gap-5 relative">
        <div class="flex flex-col items-center justify-center text-centerS">
            <h1 class="w-full text-center font-[lobster] text-[2.5rem] text-primary">Mingalar par, taw thar tway!</h1>
        </div>
        <x-carousel />
    </section>
@endsection