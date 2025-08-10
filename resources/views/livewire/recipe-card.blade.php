@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;
@endphp

<div class="bg-secondary/10 shadow rounded-lg border-2 border-gray-900 border-dotted flex flex-col relative">
    {{-- difficulty badge --}}
    <div class="{{ $this->getDifficultyColor() }} group gap-2 cursor-pointer text-white absolute top-1 left-1 z-10 rounded flex items-center justify-center text-center px-2 py-1">
        <span>
            <i class="{{ $this->getDifficultyIcon() }} stroke-2 text-white"></i>
        </span>
        <span class="group-hover:block hidden transition duration-300 ease-in-out">
            {{ $this->getDifficulty() }}
        </span>
    </div>

    <div class="absolute text-text top-0 right-0 p-2 flex items-center justify-center z-10 bg-transparent hover:bg-background/50 rounded-full cursor-pointer transition-colors">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </div>

    <img src="{{ asset('images/example-recipe.jpg') }}" alt="{{ $this->getName() }}" class="w-full h-48 object-cover rounded-t-lg">

    <div class="p-3 flex flex-col gap-3">
        {{-- name and timestamp --}}
        <div class="flex items-center justify-between">
            <h3 class="text-md font-bold text-text line-clamp-1">
                {{ $this->getName() }}
            </h3>
            <p class="text-xs text-gray-500">
                {{ $this->getFormattedCreatedAt() }}
            </p>
        </div>

        {{-- tags --}}
        <ul class="flex gap-2 w-full">
            @foreach ($this->getVisibleTags() as $tagName)
                <li class="cursor-pointer bg-secondary hover:brightness-95 text-text border border-gray-900 border-dotted px-3 py-1 rounded-full text-xs">
                    {{ $tagName }}
                </li>
            @endforeach

            @if ($this->getRemainingTagsCount() > 0)
                <li class="cursor-pointer bg-secondary/70 hover:brightness-95 text-text border border-gray-900 border-dotted px-3 py-1 rounded-full text-xs">
                    {{ $this->getRemainingTagsCount() }}+ more
                </li>
            @endif
        </ul>

        {{-- description --}}
        <p class="text-sm text-gray-700 line-clamp-1">
            {{ $this->getDescription() }}
        </p>

        <div class="w-full flex justify-end items-end">
            {{-- to details --}}
            <div class="flex items-center justify-center">
                <x-button 
                    :variant="ButtonVariant::Primary" 
                    :size="ButtonSize::Small" 
                    :icon="'<i class=\'fa-solid fa-eye\'></i>'" 
                    :text="'View Recipe'"
                    onclick="window.location.href='{{ route('recipes.show', $this->getId()) }}'"
                />
            </div>
        </div>
    </div>
</div>