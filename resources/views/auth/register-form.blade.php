@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;
@endphp

<form
    method="POST"
    action="{{ route('auth.register') }}"
    class="flex flex-col md:min-w-[450px] {{ $isPopUp ? 'max-h-[90vh] overflow-y-auto gap-3 p-5' : 'gap-4 p-6' }} items-center justify-center bg-white rounded-xl border-2 border-primary border-dashed"
>
    @csrf
    {{-- back to home --}}
    @if (!$isPopUp) 
        <div class="w-full flex items-center justify-start mb-3" onclick="window.location.href='{{ route('home') }}'">
            <span class="text-primary hover:text-secondary cursor-pointer flex gap-3">
                <i data-lucide="arrow-left" class="stroke-2 w-[1.5rem] h-[1.5rem]"></i>
                Back to Home
            </span>
        </div>
    @else
        <div class="w-full flex items-center justify-between mb-2">
            <div class="flex items-center justify-center gap-2">
                <input type="checkbox" id="doNotShowAgain">
                <label for="doNotShowAgain" class="text-gray-500 text-sm">Do not show again</label>
            </div>
            <i data-lucide="x" class="stroke-2 w-[1.5rem] h-[1.5rem] text-primary hover:text-secondary cursor-pointer" onclick="closePopup()"></i>
        </div>
    @endif

    {{-- Labels --}}
    <div class="flex flex-col items-center justify-center">
        <img src="{{ asset('logo/logo-light.png') }}" alt="Food Fusion Logo" class="{{ $isPopUp ? 'w-12 h-12' : 'w-16 h-16' }}">
        <h2 class="text-primary font-bold {{ $isPopUp ? 'text-lg' : 'text-2xl' }}">Join Us</h2>
        <p class="text-gray-600 {{ $isPopUp ? 'text-[10px] my-1' : 'text-sm my-3' }}">Create your account and start your culinary journey with us!</p>
    </div>

    {{-- Inputs --}}
    <div class="flex flex-col {{ $isPopUp ? 'gap-1' : 'gap-3' }} w-full">
        <div class="flex flex-col md:flex-row {{ $isPopUp ? 'gap-2' : 'gap-3' }}">
            <div class="flex flex-col {{ $isPopUp ? 'gap-1' : 'gap-2' }} w-full">
                <label for="firstName" class="text-gray-600 {{ $isPopUp ? 'text-[10px]' : 'text-sm' }}">First Name</label>
                <input type="text" id="firstName" name="firstName" required placeholder="John" class="bg-secondary/15 border border-gray-300 {{ $isPopUp ? 'px-3 py-1 text-sm' : 'px-4 py-2' }} focus:outline-2 focus:outline-primary rounded w-full" />
            </div>
            <div class="flex flex-col {{ $isPopUp ? 'gap-1' : 'gap-2' }} w-full">
                <label for="lastName" class="text-gray-600 {{ $isPopUp ? 'text-[10px]' : 'text-sm' }}">Last Name</label>
                <input type="text" id="lastName" name="lastName" required placeholder="Doe" class="bg-secondary/15 border border-gray-300 {{ $isPopUp ? 'px-3 py-1 text-sm' : 'px-4 py-2' }} focus:outline-2 focus:outline-primary rounded w-full" />
            </div>
        </div>
        <div class="flex flex-col {{ $isPopUp ? 'gap-1' : 'gap-2' }}">
            <label for="username" class="text-gray-600 {{ $isPopUp ? 'text-[10px]' : 'text-sm' }}">Username</label>
            <input 
                type="text" 
                id="username" 
                name="username" 
                required 
                placeholder="johndoe123" 
                pattern="[a-zA-Z0-9_]+"
                minlength="3"
                title="Username must be at least 3 characters and contain only letters, numbers, and underscores"
                class="bg-secondary/15 border border-gray-300 {{ $isPopUp ? 'px-3 py-1 text-sm' : 'px-4 py-2' }} focus:outline-2 focus:outline-primary rounded w-full" 
            />
        </div>
        <div class="flex flex-col {{ $isPopUp ? 'gap-1' : 'gap-2' }}">
            <label for="email" class="text-gray-600 {{ $isPopUp ? 'text-[10px]' : 'text-sm' }}">Email</label>
            <input type="email" id="email" name="email" required placeholder="john.doe@example.com" class="bg-secondary/15 border border-gray-300 {{ $isPopUp ? 'px-3 py-1 text-sm' : 'px-4 py-2' }} focus:outline-2 focus:outline-primary rounded w-full" />
        </div>
        <div class="flex flex-col {{ $isPopUp ? 'gap-2' : 'gap-2' }}">
            <label for="phoneNumber" class="text-text/60 {{ $isPopUp ? 'text-[10px]' : 'text-sm' }}">Phone</label>
            <input type="tel" id="phoneNumber" name="phoneNumber" required placeholder="+95 9 123456789" class="bg-secondary/15 border border-gray-300 {{ $isPopUp ? 'px-3 py-1 text-sm' : 'px-4 py-2' }} focus:outline-2 focus:outline-primary rounded w-full" />
        </div>
        <div class="flex flex-col {{ $isPopUp ? 'gap-2' : 'gap-2' }}">
            <label for="mastery_level" class="text-text/60 {{ $isPopUp ? 'text-[10px]' : 'text-sm' }}">Cooking Level</label>
            <div class="relative">
                <select
                    id="mastery_level"
                    name="mastery_level"
                    required
                    class="bg-secondary/15 border border-gray-300 {{ $isPopUp ? 'px-3 pr-8 py-1 text-sm' : 'px-4 pr-10 py-2' }} focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-gray-700"
                >
                    <option value="" class="text-gray-500" disabled selected>How cooked are you?</option>
                    <option value="beginner" class="text-gray-700 cursor-pointer">
                        🍳 Beginner
                    </option>
                    <option value="intermediate" class="text-gray-700 cursor-pointer">
                        👨‍🍳 Intermediate
                    </option>
                    <option value="advanced" class="text-gray-700 cursor-pointer">
                        🏆 Advanced
                    </option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center {{ $isPopUp ? 'pr-2' : 'pr-3' }} pointer-events-none">
                    <svg class="{{ $isPopUp ? 'w-3 h-3' : 'w-5 h-5' }} text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="flex flex-col {{ $isPopUp ? 'gap-1' : 'gap-2' }}">
            <label for="password" class="text-text/60 {{ $isPopUp ? 'text-[10px]' : 'text-sm' }}">Password</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                required 
                placeholder="veryVerySecure123!@#" 
                minlength="6"
                title="Password must be at least 6 characters long"
                class="bg-secondary/15 border border-gray-300 {{ $isPopUp ? 'px-3 py-1 text-sm' : 'px-4 py-2' }} focus:outline-2 focus:outline-primary rounded w-full" 
            />
        </div>
    </div>

    {{-- Actions --}}
    <div class="w-full flex flex-col items-center justify-center {{ $isPopUp ? 'gap-2 mt-2' : 'gap-4 mt-4' }}">
        <x-button
            type="submit"
            class="w-full"
            :text="'Register'"
            :variant="ButtonVariant::Primary"
            :size="ButtonSize::Large"
        />
        <span class="{{ $isPopUp ? 'text-[10px]' : 'text-sm' }} text-text/60">Already have an account? 
            @if ($isPopUp)
                <a href="{{ route('auth.login.show') }}" class="text-primary hover:text-secondary underline {{ $isPopUp ? 'text-[10px]' : 'text-sm' }}">Log in here</a>
            @else
                <a href="{{ route('auth.login.show') }}" class="text-primary hover:text-secondary underline {{ $isPopUp ? 'text-[10px]' : 'text-sm' }}">Log in here</a>
            @endif
        </span>
    </div>
</form>