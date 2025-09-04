@extends('layout.auth')
@section('title', 'Create A New Account')

@section('left')
    <div class="bg-secondary/10 rounded-3xl w-full h-full flex flex-col items-center justify-center px-10 py-8 space-y-6">
        <div class="flex items-center justify-center gap-3 animate-fade-in-up">
            <div class="rounded-full bg-primary p-4 text-white flex items-center justify-center">
                <i data-lucide="book-open" class="stroke-2 w-[2.5rem] h-[2.5rem]"></i>
            </div>
            <div class="rounded-full bg-yellow-500 p-4 text-white flex items-center justify-center">
                <i data-lucide="chef-hat" class="stroke-2 w-[2.5rem] h-[2.5rem]"></i>
            </div>
            <div class="rounded-full bg-primary p-4 text-white flex items-center justify-center">
                <i data-lucide="award" class="stroke-2 w-[2.5rem] h-[2.5rem]"></i>
            </div>
        </div>

        <h1 class="text-primary font-semibold text-4xl text-center animate-fade-in-up" style="animation-delay: 0.1s;">Start Your Culinary Adventure</h1>

        <p class="text-center text-lg text-gray-600 leading-relaxed animate-fade-in-up" style="animation-delay: 0.2s;">
            Whether you're a beginner or a seasoned chef, <br />
            FoodFusion has something for everyone. Share <br />
            recipes, learn new techniques, and be part of our <br />
            growing community.
        </p>

        <div class="flex flex-col gap-4 w-full max-w-md">
            <div class="flex items-center gap-4 p-4 bg-secondary/20 rounded-lg animate-fade-in-up" style="animation-delay: 0.3s;">
                <div class="rounded-full bg-yellow-500/30 p-3 text-primary flex items-center justify-center">
                    <i data-lucide="book-open" class="stroke-2 w-[1.5rem] h-[1.5rem]"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-semibold text-primary text-lg">Learn & Grow</span>
                    <span class="text-gray-600">Access tutorials and cooking tips</span>
                </div>
            </div>
            
            <div class="flex items-center gap-4 p-4 bg-primary/20 rounded-lg animate-fade-in-up" style="animation-delay: 0.4s;">
                <div class="rounded-full bg-primary/30 p-3 text-primary flex items-center justify-center">
                    <i data-lucide="users" class="stroke-2 w-[1.5rem] h-[1.5rem]"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-semibold text-primary text-lg">Connect</span>
                    <span class="text-gray-600">Join a vibrant cooking community</span>
                </div>
            </div>
            
            <div class="flex items-center gap-4 p-4 bg-secondary/20 rounded-lg animate-fade-in-up" style="animation-delay: 0.5s;">
                <div class="rounded-full bg-yellow-500/30 p-3 text-primary flex items-center justify-center">
                    <i data-lucide="chef-hat" class="stroke-2 w-[1.5rem] h-[1.5rem]"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-semibold text-primary text-lg">Share</span>
                    <span class="text-gray-600">Contribute your favorite recipes</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('right')
    <x-forms.register-form :isPopUp="false" :showPopupSwitcher="false" />
@endsection