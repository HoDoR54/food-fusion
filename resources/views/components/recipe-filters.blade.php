@php
    use App\Enums\ButtonSize;
    use App\Enums\ButtonVariant;
@endphp

<div class="w-full flex flex-wrap items-center justify-between gap-3">

    {{-- Difficulty Level --}}
    <div class="relative w-full sm:w-auto flex-1">
        <select
            id="difficulty_level"
            name="difficulty_level"
            class="bg-secondary/15 border border-gray-300 px-4 pr-10 py-2 focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-gray-700"
        >
            <option value="" disabled selected>Difficulty Level</option>
            @foreach ($difficultyLevels as $value => $label)
                <option value="{{ $value }}" {{ request('difficulty_level') == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>

    {{-- Dietary Preference --}}
    <div class="relative w-full sm:w-auto flex-1">
        <select
            id="dietary_preference"
            name="dietary_preference"
            class="bg-secondary/15 border border-gray-300 px-4 pr-10 py-2 focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-gray-700"
        >
            <option value="" disabled selected>Dietary Preference</option>
            @foreach ($dietaryPreferences as $value => $label)
                <option value="{{ $value }}" {{ request('dietary_preference') == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>

    {{-- Cuisine Type --}}
    <div class="relative w-full sm:w-auto flex-1">
        <select
            id="cuisine_type"
            name="cuisine_type"
            class="bg-secondary/15 border border-gray-300 px-4 pr-10 py-2 focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-gray-700"
        >
            <option value="" disabled selected>Cuisine Type</option>
            @foreach ($cuisineTypes as $value => $label)
                <option value="{{ $value }}" {{ request('cuisine_type') == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>

    {{-- Course --}}
    <div class="relative w-full sm:w-auto flex-1">
        <select
            id="course"
            name="course"
            class="bg-secondary/15 border border-gray-300 px-4 pr-10 py-2 focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-gray-700"
        >
            <option value="" disabled selected>Course</option>
            @foreach ($courses as $value => $label)
                <option value="{{ $value }}" {{ request('course') == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>

    {{-- Order By --}}
    <div class="relative w-full sm:w-auto flex-1">
        <select
            id="order_by"
            name="order_by"
            class="bg-secondary/15 border border-gray-300 px-4 pr-10 py-2 focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-gray-700"
        >
            <option value="" disabled selected>Order by</option>
            <option value="vote_count" {{ request('order_by') == 'vote_count' ? 'selected' : '' }}>Highest Votes</option>
            <option value="newest" {{ request('order_by') == 'newest' ? 'selected' : '' }}>Newest</option>
            <option value="oldest" {{ request('order_by') == 'oldest' ? 'selected' : '' }}>Oldest</option>
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>

    <div class="sm:w-auto">
        <x-button :variant="ButtonVariant::Secondary" 
            :size="ButtonSize::Small" 
            :icon="'<i data-lucide=\'x\'></i>'"
            id="clear-filters"
        ></x-button>
    </div>
</div>
