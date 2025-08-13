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
        <x-carousel 
            :title="'Events Organized by FoodFusion This Year'"
            :description="'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Beatae cupiditate esse odio? Reiciendis.'"
            :items="[
                ['image' => 'for-show/1.jpg', 'title' => 'Event 1', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus est culpa, amet praesentium ea temporibus!'],
                ['image' => 'for-show/2.jpg', 'title' => 'Event 2', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus est culpa, amet praesentium ea temporibus!'],
                ['image' => 'for-show/3.jpg', 'title' => 'Event 3', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus est culpa, amet praesentium ea temporibus!'],
                ['image' => 'for-show/4.jpg', 'title' => 'Event 4', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus est culpa, amet praesentium ea temporibus!'],
                ['image' => 'for-show/5.jpg', 'title' => 'Event 5', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus est culpa, amet praesentium ea temporibus!'],
                ['image' => 'for-show/6.jpg', 'title' => 'Event 6', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus est culpa, amet praesentium ea temporibus!'],
                ['image' => 'for-show/7.jpg', 'title' => 'Event 7', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus est culpa, amet praesentium ea temporibus!'],
                ['image' => 'for-show/8.jpg', 'title' => 'Event 8', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus est culpa, amet praesentium ea temporibus!'],
            ]"
            :showSeeAll="true"
            :seeAllUrl="route('events.index')"
            :slidesVisible="5"
            :autoPlay="true"
            :autoPlayInterval="3000"
        />
    </section>
@endsection