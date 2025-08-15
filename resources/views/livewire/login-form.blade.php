@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;
@endphp

<form 
    action="{{ route('auth.login') }}" 
    method="POST"
    class="flex flex-col md:min-w-[450px] items-center justify-center gap-4 p-6 bg-white rounded-xl border-2 border-primary border-dashed"
>
    @csrf
    {{-- back to home --}}
    <span class="w-full flex items-center justify-start gap-2 text-primary hover:text-secondary cursor-pointer mb-4" onclick="window.location.href='{{ route('home') }}'">
        <i data-lucide="arrow-left" class="stroke-2 w-[1.5rem] h-[1.5rem]"></i>
        Back to Home
    </span>

    {{-- Labels --}}
    <div class="flex flex-col items-center justify-center">
        <img src="{{ asset('logo/logo-light.png') }}" alt="Food Fusion Logo" class="w-16 h-16">
        <h2 class="text-primary font-bold text-3xl">Welcome Back</h2>
        <p class="text-text/60 text-base my-3">Sign in to your FoodFusion account</p>
    </div>

    {{-- Inputs --}} 
    <div class="flex flex-col gap-4 w-full">
        <div class="flex flex-col gap-2">
            <label for="identifier" class="text-text/60 text-sm">Email or Username</label>
            <input type="text" id="identifier" name="identifier" required placeholder="johnDoe123@gmail.com or johndoe" class="bg-secondary/15 border border-gray-300 px-4 py-2 focus:outline-2 focus:outline-primary rounded w-full" />
        </div>
        <div class="flex flex-col gap-2">
            <label for="password" class="text-text/60 text-sm">Password</label>
            <input type="password" id="password" name="password" required placeholder="password" class="bg-secondary/15 border border-gray-300 px-4 py-2 focus:outline-2 focus:outline-primary rounded w-full" />
        </div>
        <div class="w-full">
            <a class="text-primary hover:text-secondary underline text-sm">Forgot Password?</a>
        </div>
    </div>

    <div class="w-full flex flex-col items-center justify-center gap-4 mt-4">
        <x-button
            type="submit"
            class="w-full"
            :text="'Login'"
            :variant="ButtonVariant::Primary"
            :size="ButtonSize::Large"
        />
        <span class="text-base text-text/60">Don't have an account? <a href="{{ route('auth.register.show') }}" class="text-primary hover:text-secondary underline text-sm">Sign up here</a></span>
    </div>
    
</form>
