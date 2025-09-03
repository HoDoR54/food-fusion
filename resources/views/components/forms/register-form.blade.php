@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;
@endphp

<form
    method="POST"
    action="{{ route('auth.register') }}"
    class="flex flex-col md:min-w-[450px] gap-4 p-6 items-center justify-center bg-white rounded-xl border-2 border-primary border-dashed"
>
    @csrf

    @if($isPopUp ?? true)
        <span 
            class="w-full flex items-center justify-start gap-2 text-primary hover:text-secondary cursor-pointer mb-4" 
            data-action="close-popup"
        >
            <i data-lucide="arrow-left" class="stroke-2 w-[1.5rem] h-[1.5rem]"></i>
            Back to Home
        </span>
    @else
        <a 
            href="{{ route('home') }}" 
            class="w-full flex items-center justify-start gap-2 text-primary hover:text-secondary cursor-pointer mb-4" 
        >
            <i data-lucide="arrow-left" class="stroke-2 w-[1.5rem] h-[1.5rem]"></i>
            Back to Home
        </a>
    @endif

    <!-- Labels -->
    <div class="flex flex-col items-center justify-center">
        <img src="{{ asset('logo/logo-light.png') }}" alt="Food Fusion Logo" class="w-16 h-16">
        <h2 class="text-primary font-bold text-2xl">Join Us</h2>
        <p class="text-gray-600 text-sm my-3">Create your account and start your culinary journey with us!</p>
    </div>

    <!-- Inputs -->
    <div class="flex flex-col gap-3 w-full">
        <div class="flex flex-col md:flex-row gap-3">
            <div class="flex flex-col gap-2 w-full">
                <label for="firstName" class="text-gray-600 text-sm">First Name</label>
                <input 
                    type="text" 
                    id="firstName" 
                    name="firstName" 
                    required 
                    placeholder="John" 
                    value="{{ old('firstName') }}"
                    class="bg-secondary/15 border px-4 py-2 focus:outline-2 focus:outline-primary rounded w-full @error('firstName') border-red-500 @else border-gray-300 @enderror" 
                />
                @error('firstName')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col gap-2 w-full">
                <label for="lastName" class="text-gray-600 text-sm">Last Name</label>
                <input 
                    type="text" 
                    id="lastName" 
                    name="lastName" 
                    required 
                    placeholder="Doe" 
                    value="{{ old('lastName') }}"
                    class="bg-secondary/15 border px-4 py-2 focus:outline-2 focus:outline-primary rounded w-full @error('lastName') border-red-500 @else border-gray-300 @enderror" 
                />
                @error('lastName')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <label for="username" class="text-gray-600 text-sm">Username</label>
            <input 
                type="text" 
                id="username" 
                name="username" 
                required 
                placeholder="johndoe123" 
                pattern="[a-zA-Z0-9_]+"
                minlength="3"
                title="Username must be at least 3 characters and contain only letters, numbers, and underscores"
                value="{{ old('username') }}"
                class="bg-secondary/15 border px-4 py-2 focus:outline-2 focus:outline-primary rounded w-full @error('username') border-red-500 @else border-gray-300 @enderror" 
            />
            @error('username')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col gap-2">
            <label for="email" class="text-gray-600 text-sm">Email</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                required 
                placeholder="john.doe@example.com" 
                value="{{ old('email') }}"
                class="bg-secondary/15 border px-4 py-2 focus:outline-2 focus:outline-primary rounded w-full @error('email') border-red-500 @else border-gray-300 @enderror" 
            />
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col gap-2">
            <label for="phoneNumber" class="text-gray-600 text-sm">Phone</label>
            <input 
                type="tel" 
                id="phoneNumber" 
                name="phoneNumber" 
                required 
                placeholder="+95 9 123456789" 
                value="{{ old('phoneNumber') }}"
                class="bg-secondary/15 border px-4 py-2 focus:outline-2 focus:outline-primary rounded w-full @error('phoneNumber') border-red-500 @else border-gray-300 @enderror" 
            />
            @error('phoneNumber')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col gap-2">
            <label for="mastery_level" class="text-gray-600 text-sm">Cooking Level</label>
            <div class="relative">
                <select
                    id="mastery_level"
                    name="mastery_level"
                    required
                    class="bg-secondary/15 border px-4 pr-10 py-2 focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-gray-700 @error('mastery_level') border-red-500 @else border-gray-300 @enderror"
                >
                    <option value="" class="text-gray-500" disabled {{ old('mastery_level') ? '' : 'selected' }}>How cooked are you?</option>
                    <option value="beginner" {{ old('mastery_level') == 'beginner' ? 'selected' : '' }}>🍳 Beginner</option>
                    <option value="intermediate" {{ old('mastery_level') == 'intermediate' ? 'selected' : '' }}>👨‍🍳 Intermediate</option>
                    <option value="advanced" {{ old('mastery_level') == 'advanced' ? 'selected' : '' }}>🏆 Advanced</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
            @error('mastery_level')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col gap-2">
            <label for="password" class="text-gray-600 text-sm">Password</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                required 
                placeholder="veryVerySecure123!@#" 
                minlength="6"
                title="Password must be at least 6 characters long"
                class="bg-secondary/15 border px-4 py-2 focus:outline-2 focus:outline-primary rounded w-full @error('password') border-red-500 @else border-gray-300 @enderror" 
            />
            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Actions -->
    <div class="w-full flex flex-col items-center justify-center gap-4 mt-4">
        <x-button 
            type="submit" 
            :variant="ButtonVariant::Primary" 
            :size="ButtonSize::Medium"
            :text="'Register'"
            class="w-full"
        />
        
        <span class="text-sm text-gray-600">
            Already have an account? 
            @if($showPopupSwitcher ?? true)
                <button 
                    type="button" 
                    data-action="show-login-popup" 
                    class="text-primary hover:text-secondary underline bg-transparent border-none cursor-pointer"
                >
                    Log in here
                </button>
            @else
                <a href="{{ route('auth.login.show') }}" class="text-primary hover:text-secondary underline">
                    Log in here
                </a>
            @endif
        </span>
    </div>
</form>
