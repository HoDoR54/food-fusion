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
            class="bg-secondary/15 border border-gray-300 px-4 pr-10 py-2 focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-text/60"
        >
            <option value="" disabled selected>Difficulty Level</option>
            @foreach ($difficultyLevels as $value => $label)
                <option value="{{ $value }}" {{ request('difficulty_level') == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-5 h-5 text-text/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>

    {{-- Dietary Preference --}}
    <div class="relative w-full sm:w-auto flex-1">
        <select
            id="dietary_preference"
            name="dietary_preference"
            class="bg-secondary/15 border border-gray-300 px-4 pr-10 py-2 focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-text/60"
        >
            <option value="" disabled selected>Dietary Preference</option>
            @foreach ($dietaryPreferences as $value => $label)
                <option value="{{ $value }}" {{ request('dietary_preference') == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-5 h-5 text-text/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>

    {{-- Cuisine Type --}}
    <div class="relative w-full sm:w-auto flex-1">
        <select
            id="cuisine_type"
            name="cuisine_type"
            class="bg-secondary/15 border border-gray-300 px-4 pr-10 py-2 focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-text/60"
        >
            <option value="" disabled selected>Cuisine Type</option>
            @foreach ($cuisineTypes as $value => $label)
                <option value="{{ $value }}" {{ request('cuisine_type') == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-5 h-5 text-text/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>

    {{-- Course --}}
    <div class="relative w-full sm:w-auto flex-1">
        <select
            id="course"
            name="course"
            class="bg-secondary/15 border border-gray-300 px-4 pr-10 py-2 focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-text/60"
        >
            <option value="" disabled selected>Course</option>
            @foreach ($courses as $value => $label)
                <option value="{{ $value }}" {{ request('course') == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-5 h-5 text-text/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>

    {{-- Sort By --}}
    <div class="relative w-full sm:w-auto flex-1">
        <select
            id="sort_by"
            name="sort_by"
            class="bg-secondary/15 border border-gray-300 px-4 pr-10 py-2 focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-text/60"
        >
            <option value="" disabled selected>Sort by</option>
            <option value="popularity,desc" {{ request('sort_by') == 'popularity' && request('sort_direction') == 'desc' ? 'selected' : '' }}>Most Popular</option>
            <option value="created_at,desc" {{ request('sort_by') == 'created_at' && request('sort_direction') == 'desc' ? 'selected' : '' }}>Newest</option>
            <option value="created_at,asc" {{ request('sort_by') == 'created_at' && request('sort_direction') == 'asc' ? 'selected' : '' }}>Oldest</option>
            <option value="name,asc" {{ request('sort_by') == 'name' && request('sort_direction') == 'asc' ? 'selected' : '' }}>A-Z</option>
            <option value="name,desc" {{ request('sort_by') == 'name' && request('sort_direction') == 'desc' ? 'selected' : '' }}>Z-A</option>
            <option value="difficulty,asc" {{ request('sort_by') == 'difficulty' && request('sort_direction') == 'asc' ? 'selected' : '' }}>Easiest</option>
            <option value="difficulty,desc" {{ request('sort_by') == 'difficulty' && request('sort_direction') == 'desc' ? 'selected' : '' }}>Hardest</option>
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-5 h-5 text-text/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
