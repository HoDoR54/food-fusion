@extends('layout.index')

@section('title', 'Food Fusion')

@section('content')
    <section class="w-full flex flex-col gap-5">
        <div class="flex flex-col items-center justify-center text-centerS">
            <h1 class="w-full text-center font-[lobster] text-[2.5rem] text-primary">Mingalar par, taw thar tway!</h1>
            {{-- <p class="text-primary/80 font-thin leading-relaxed font-[lobster]"></p> --}}
        </div>
        <x-carousel />
    </section>
@endsection