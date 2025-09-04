@extends('layout.auth')
@section('title', 'Log In To Your Account')
@section('left')
    <x-forms.login-form :isPopUp="false" :showPopupSwitcher="false" />
@endsection

@section('right')
    <div class="bg-primary/10 rounded-3xl w-full h-full flex flex-col items-center justify-center px-10 py-8 space-y-6">
        <div class="flex items-center justify-center gap-3 animate-fade-in-up">
            <div class="rounded-full bg-secondary p-4 text-white flex items-center justify-center">
                <i data-lucide="utensils" class="stroke-2 w-[2.5rem] h-[2.5rem]"></i>
            </div>
            <div class="rounded-full bg-primary p-4 text-white flex items-center justify-center">
                <i data-lucide="chef-hat" class="stroke-2 w-[2.5rem] h-[2.5rem]"></i>
            </div>
        </div>

        <h1 class="text-primary font-semibold text-4xl animate-fade-in-up" style="animation-delay: 0.1s;">FoodFusion</h1>

        <p class="text-center text-lg text-gray-600 leading-relaxed animate-fade-in-up" style="animation-delay: 0.2s;">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. <br />
            Minima accusantium labore quod, distinctio numquam magni inventore! <br />
            Non odio aliquid doloremque illum delectus! Repudiandae, nulla.
        </p>

        <div class="grid grid-cols-3 gap-5 w-full">
            <div class="flex items-center flex-col justify-center bg-primary/30 text-primary rounded py-5 animate-fade-in-up" style="animation-delay: 0.3s;">
                <span class="text-3xl font-medium">4+</span>
                <span>Recipes</span>
            </div>
            <div class="flex items-center flex-col justify-center bg-secondary/30 text-primary rounded py-5 animate-fade-in-up" style="animation-delay: 0.4s;">
                <span class="text-3xl font-medium">2</span>
                <span>Followers</span>
            </div>
            <div class="flex items-center flex-col justify-center bg-primary/30 text-primary rounded py-5 animate-fade-in-up" style="animation-delay: 0.5s;">
                <span class="text-3xl font-medium">0</span>
                <span>Events</span>
            </div>
        </div>
    </div>
@endsection