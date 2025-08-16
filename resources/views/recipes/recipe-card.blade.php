@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;
@endphp

<div class="bg-secondary/10 shadow rounded-lg border-2 border-primary border-dashed flex flex-col relative">
    {{-- difficulty badge --}}
    <div class="{{ $this->getDifficultyColor() }} group gap-2 cursor-pointer text-white absolute top-2 left-2 z-10 rounded flex items-center justify-center text-center px-2 py-1">
        <span>
            <i class="{{ $this->getDifficultyIcon() }} stroke-2 text-white"></i>
        </span>
        <span class="group-hover:block hidden transition duration-300 ease-in-out">
            {{ $this->getDifficulty() }}
        </span>
    </div>

    <div class="absolute text-text top-2 right-2 p-2 flex items-center justify-center z-10 bg-transparent hover:bg-background/50 rounded-full cursor-pointer transition-colors">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </div>

    <img src="{{ asset('images/example-recipe.jpg') }}" alt="{{ $this->getName() }}" class="w-full h-48 object-cover rounded-t-lg">

    <div class="p-4 flex flex-col gap-4">
        {{-- name and timestamp --}}
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-text line-clamp-1">
                {{ $this->getName() }}
            </h3>
            <p class="text-xs text-text/60">
                {{ $this->getFormattedCreatedAt() }}
            </p>
        </div>

        {{-- tags --}}
        <ul class="flex gap-2 w-full flex-wrap min-h-[60px] items-center">
            @foreach ($this->getVisibleTags() as $tagName)
                <li class="cursor-pointer h-fit bg-secondary hover:brightness-95 text-text border border-primary border-dashed px-3 py-1 rounded-full text-xs">
                    {{ $tagName }}
                </li>
            @endforeach

            @if ($this->getRemainingTagsCount() > 0)
                <li class="cursor-pointer h-fit bg-secondary/70 hover:brightness-95 text-text border border-primary border-dashed px-3 py-1 rounded-full text-xs">
                    {{ $this->getRemainingTagsCount() }}+ more
                </li>
            @endif
        </ul>

        {{-- description --}}
        <p class="text-sm text-text/60 line-clamp-1">
            {{ $this->getDescription() }}
        </p>

        <div class="w-full flex justify-between items-end">
            {{-- TO-DO: Get Author Id from database --}}
            <a href="{{ route('users.show', ['username' => 'author username']) }}" class="flex items-center justify-center gap-3 group max-w-1/2">
                <img src="{{  asset('images/default-profile.webp') }}" alt="Profile Picture" class="h-8 w-8 rounded-full cursor-pointer border-2 border-primary/50 border-dashed">
                <div class="flex flex-col justify-center items-start text-left">
                    <span class=" line-clamp-1 cursor-pointer font-medium text-sm group-hover:text-secondary text-primary transition duration-300 ease-in-out group-hover:underline">
                        {{  $this->getAuthorName() ?? 'Nothing beats an Jet 2 holiday' }}
                    </span>
                    <span class="text-xs text-text/60">
                        69 Followers
                    </span>
                </div>     
            </a>

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