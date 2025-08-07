@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;

    $recipeId = $recipe->id;
@endphp

@props(['recipe'])

<div 
    class="cursor-pointer bg-background shadow rounded-lg border-2 border-gray-900 border-dotted flex flex-col overflow-hidden relative" 
    data-recipe-id="{{ $recipe->id }}"
>
    <div class="absolute text-text top-0 right-0 p-2 flex items-center justify-center z-10 bg-transparent hover:bg-background/50 rounded-full cursor-pointer transition-colors">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </div>

    <img src="{{ asset('images/example-recipe.jpg') }}" alt="{{ $recipe->name }}" class="w-full h-48 object-cover rounded-t-lg">
    <div class="p-3 flex flex-col gap-3">
        {{-- name and timestamp --}}
        <div class="flex items-center justify-between">
            <h3 class="text-md font-bold text-text line-clamp-1">
                {{ $recipe->name }}
            </h3>
            <p class="text-xs text-gray-500">
                {{ $getFormattedCreatedAt() }}
            </p>
        </div>


        {{-- tags --}}
        <ul class="flex gap-2 w-full">
            @foreach ($getVisibleTags() as $tagName)
                <li class="bg-secondary/70 hover:bg-secondary text-text border border-gray-900 border-dotted px-3 py-1 rounded-full text-xs">
                    {{ $tagName }}
                </li>
            @endforeach

            @if ($getRemainingTagsCount() > 0)
                <li class="bg-secondary/50 hover:bg-secondary text-text border border-gray-900 border-dotted px-3 py-1 rounded-full text-xs">
                    {{ $getRemainingTagsCount() }}+ more
                </li>
            @endif
        </ul>

        {{-- description --}}
        <p class="text-sm text-gray-700 line-clamp-1">
            {{ $recipe->description }}
        </p>
     
        <div class="w-full flex justify-between items-end">
            {{-- upvote and downvote buttons --}}
            <div class="flex gap-2 justify-end items-center">
                <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Small" :icon="'bi bi-caret-up'" :text="$getVoteCount()" class="hover:bg-green-400/50 text-xs"></x-button>
                <span class="text-xs">{{ $getVoteCount() }} Votes</span>
                <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Small" :icon="'bi bi-caret-down'" :text="$getVoteCount()" class="hover:bg-red-400/50 text-xs"></x-button>
            </div>

            {{-- to details --}}
            <div class="flex items-center justify-center">
                <x-button 
                    :variant="ButtonVariant::Primary" 
                    :size="ButtonSize::Small" 
                    :icon="'fa-solid fa-eye'" 
                    :text="'View Recipe'"
                    onclick="window.location.href='{{ route('recipes.show', $recipeId) }}'"
                />
            </div>
        </div>
        
    </div>
</div>