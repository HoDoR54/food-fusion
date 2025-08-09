@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;
@endphp

<form 
    action="{{ route('auth.register') }}" 
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
        <h2 class="text-primary font-bold text-2xl">Join FoodFusion</h2>
        <p class="text-gray-600 text-sm my-3">Create your account and start your culinary journey with us!</p>
    </div>

    {{-- Inputs --}}
    <div class="flex flex-col gap-3 w-full">
        <div class="flex flex-col md:flex-row gap-3">
            <div class="flex flex-col gap-2 w-full">
                <label for="firstName" class="text-gray-600 text-sm">First Name</label>
                <input type="text" id="firstName" name="firstName" required placeholder="John" class="bg-secondary/15 border border-gray-300 px-4 py-2 focus:outline-2 focus:outline-primary rounded w-full" />
            </div>
            <div class="flex flex-col gap-2 w-full">
                <label for="lastName" class="text-gray-600 text-sm">Last Name</label>
                <input type="text" id="lastName" name="lastName" required placeholder="Doe" class="bg-secondary/15 border border-gray-300 px-4 py-2 focus:outline-2 focus:outline-primary rounded w-full" />
            </div>
        </div>
        <div class="flex flex-col gap-2">
            <label for="email" class="text-gray-600 text-sm">Email</label>
            <input type="email" id="email" name="email" required placeholder="john.doe@example.com" class="bg-secondary/15 border border-gray-300 px-4 py-2 focus:outline-2 focus:outline-primary rounded w-full" />
        </div>
        <div class="flex flex-col gap-2">
            <label for="phoneNumber" class="text-gray-600 text-sm">Phone</label>
            <input type="tel" id="phoneNumber" name="phoneNumber" required placeholder="+95 9 123456789" class="bg-secondary/15 border border-gray-300 px-4 py-2 focus:outline-2 focus:outline-primary rounded w-full" />
        </div>
        <div class="flex flex-col gap-2">
            <label for="mastery_level" class="text-gray-600 text-sm">Cooking Level</label>
            <div class="relative">
                <select
                    id="mastery_level"
                    name="mastery_level"
                    required
                    class="bg-secondary/15 border border-gray-300 px-4 pr-10 py-2 focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-gray-700"
                >
                    <option value="" class="text-gray-500 py-3" disabled selected>How cooked are you?</option>
                    <option value="beginner" class="text-gray-700 py-2 cursor-pointer">
                        🍳 Beginner
                    </option>
                    <option value="intermediate" class="text-gray-700 py-2 cursor-pointer">
                        👨‍🍳 Intermediate
                    </option>
                    <option value="advanced" class="text-gray-700 py-2 cursor-pointer">
                        🏆 Advanced
                    </option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-2">
            <label for="password" class="text-gray-600 text-sm">Password</label>
            <input type="password" id="password" name="password" required placeholder="veryVerySecure123!@#" class="bg-secondary/15 border border-gray-300 px-4 py-2 focus:outline-2 focus:outline-primary rounded w-full" />
        </div>
    </div>

    {{-- Actions --}}
    <div class="w-full flex flex-col items-center justify-center gap-3 mt-3">
        <x-button
            type="submit"
            class="w-full"
            :text="'Register'"
            :variant="ButtonVariant::Primary"
            :size="ButtonSize::Large"
        />
        <span class="text-sm text-gray-600">Already have an account? 
            <a href="{{ route('login') }}" class="text-primary hover:text-secondary underline text-sm">Log in here</a>
        </span>
    </div>
</form>
