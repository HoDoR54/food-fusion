@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;
@endphp

<form 
    action="{{ route('auth.login') }}" 
    method="POST"
    class="flex flex-col md:min-w-[450px] items-center justify-center gap-3 p-5 bg-white rounded-xl border-2 border-gray-500 border-dotted"
>
    @csrf
    {{-- back to home --}}
    <span class="w-full flex items-center justify-start gap-2 text-primary hover:text-secondary cursor-pointer mb-3" onclick="window.location.href='{{ route('home') }}'">
        <i data-lucide="arrow-left" class="stroke-2 w-[1.5rem] h-[1.5rem]"></i>
        Back to Home
    </span>

    {{-- Labels --}}
    <div class="flex flex-col items-center justify-center">
        <img src="{{ asset('logo/logo-light.png') }}" alt="Food Fusion Logo" class="w-16 h-16">
        <h2 class="text-primary font-bold text-2xl">Welcome Back</h2>
        <p class="text-gray-600 text-sm my-3">Sign in to your FoodFusion account</p>
    </div>

    {{-- Inputs --}}
    <div class="flex flex-col gap-3 w-full">
        <div class="flex flex-col gap-2">
            <label for="email" class="text-gray-600 text-sm">Email</label>
            <input type="email" id="email" name="email" required placeholder="johnDoe123@gmail.com" required class="bg-secondary/15 border border-gray-300 px-4 py-2 focus:outline-2 focus:outline-primary rounded w-full" />
        </div>
        <div class="flex flex-col gap-2">
            <label for="password" class="text-gray-600 text-sm">Password</label>
            <input type="password" id="password" name="password" required placeholder="veryVerySecure123!@#" required class="bg-secondary/15 border border-gray-300 px-4 py-2 focus:outline-2 focus:outline-primary rounded w-full" />
        </div>
        <div class="w-full">
            <a href="{{ route('auth.ဘာတွေမျှော်လင့်') }}" class="text-primary hover:text-secondary underline text-sm">Forgot Password?</a>
        </div>
    </div>

    <div class="w-full flex flex-col items-center justify-center gap-3 mt-3">
        <x-button
            type="submit"
            class="w-full"
            :text="'Login'"
            :variant="ButtonVariant::Primary"
            :size="ButtonSize::Large"
        />
        <span class="text-sm text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="text-primary hover:text-secondary underline text-sm">Sign up here</a></span>
    </div>
    
</form>
