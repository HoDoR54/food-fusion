@php
    use App\Enums\ButtonSize;
    use App\Enums\ButtonVariant;

    $recipe = $res->getData();

    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Recipes', 'url' => '/recipes'],
        ['label' => $recipe->name, 'url' => '/recipes/' . $recipe->id],
    ];
@endphp

@extends('layout.index')

@section('title', $recipe->name)

@section('content')
    <section id="recipe-details" data-recipe-id="{{ $recipe->id }}" class="flex items-center justify-center pb-8 sm:pb-16 px-4 sm:px-6">
        <section class="flex flex-col w-full max-w-sm sm:max-w-md md:max-w-2xl lg:max-w-4xl gap-4 sm:gap-5">
            {{-- overall section --}}
            <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-4 animate-fade-in-up">
                <div class="flex flex-col p-2 sm:p-3 justify-start items-start gap-2 md:col-span-2 relative order-2 md:order-1">
                    <div class="absolute top-2 sm:top-3 right-2 sm:right-3 p-1 rounded-full flex gap-2">
                        {{-- TO-DO: implement these --}}
                        <button data-recipe-id="{{ $recipe->id }}" class="recipe-save-button border-text/60 text-text/60 p-1 rounded border cursor-pointer hover:border-secondary hover:text-secondary">
                            <i data-lucide="bookmark" class="w-4 h-4 save-icon"></i>
                        </button>
                       <a href="{{ route('recipes.download', ['uuid' => $recipe->id]) }}" 
                        class="recipe-download-button border-text/60 text-text/60 p-1 rounded border cursor-pointer hover:border-secondary hover:text-secondary">
                            <i data-lucide="download" class="w-4 h-4"></i>
                        </a>
                    </div>

                    


                    <h1 class="text-primary text-xl sm:text-2xl md:text-3xl font-bold pr-16 sm:pr-20">{{ $recipe->name }}</h1>
                    <div class="flex gap-1.5 sm:gap-2 flex-wrap">
                        @foreach($recipe->tags as $tag)
                            <div class="bg-secondary/20 border-2 border-primary/20 rounded-full px-2 py-1 border-dashed text-xs">
                                {{ $tag->name }}
                            </div>
                        @endforeach
                        <div class="bg-secondary/20 border-2 border-primary/20 rounded-full px-2 py-1 border-dashed text-xs">
                            {{ $recipe->difficulty->label() }}
                        </div>
                    </div>
                    <h3 class="text-primary text-sm">By <a class="font-medium hover:underline hover:text-secondary cursor-pointer">{{ $recipe->author_name }}</a></h3>
                    @if($recipe->approved_at)
                        <p class="text-text/60 text-xs">Approved by FoodFusion QA Team — {{ $recipe->approved_at }}</p>
                    @else
                        <p class="text-text/60 text-xs">Pending approval</p>
                    @endif
                </div>
                <div class="flex justify-center md:justify-end items-center order-1 md:order-2">
                    <img src="{{ $recipe->image_url ? $recipe->image_url : asset('images/example-recipe.jpg') }}" alt="{{ $recipe->name }}" class="h-32 sm:h-40 w-auto object-cover rounded-2xl border-2 border-dashed border-primary/20">
                </div>
            </div>

            {{-- description section --}}
            <div class="flex flex-col gap-3 py-4 sm:py-5 px-4 sm:px-6 md:px-8 bg-primary/10 rounded-2xl border-dashed border-2 border-primary/20 animate-fade-in-up" style="animation-delay: 0.1s;">
                <h2 class="text-primary text-lg sm:text-xl font-semibold">About this recipe</h2>
                <p class="text-text/60">
                    {{ $recipe->description }}
                </p>
            </div>

            {{-- attributes section --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 sm:gap-3 min-h-24 sm:min-h-32">
                <div class="flex items-center justify-center flex-col bg-white/30 rounded-xl sm:rounded-2xl border-2 border-primary/20 border-dashed animate-fade-in-up py-3 sm:py-4" style="animation-delay: 0.2s;">
                    <i data-lucide="users" class="text-secondary mb-2 sm:mb-3 w-4 h-4 sm:w-5 sm:h-5"></i>
                    <span class="text-text/60 text-xs sm:text-sm">Servings</span>
                    <span class="text-text font-semibold text-lg sm:text-xl">{{ $recipe->servings ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center justify-center flex-col bg-white/30 rounded-xl sm:rounded-2xl border-2 border-primary/20 border-dashed animate-fade-in-up py-3 sm:py-4" style="animation-delay: 0.3s;">
                    <i data-lucide="clock" class="text-secondary mb-2 sm:mb-3 w-4 h-4 sm:w-5 sm:h-5"></i>
                    <span class="text-text/60 text-xs sm:text-sm">Prep</span>
                    <span class="text-text font-semibold text-lg sm:text-xl">{{ $recipe->getPreparationMinutes() }} min</span>
                </div>
                <div class="flex items-center justify-center flex-col bg-white/30 rounded-xl sm:rounded-2xl border-2 border-primary/20 border-dashed animate-fade-in-up py-3 sm:py-4" style="animation-delay: 0.4s;">
                    <i data-lucide="chef-hat" class="text-secondary mb-2 sm:mb-3 w-4 h-4 sm:w-5 sm:h-5"></i>
                    <span class="text-text/60 text-xs sm:text-sm">Cook</span>
                    <span class="text-text font-semibold text-lg sm:text-xl">{{ $recipe->getTotalCookingMinutes() }} min</span>
                </div>
                <div class="flex items-center justify-center flex-col bg-white/30 rounded-xl sm:rounded-2xl border-2 border-primary/20 border-dashed animate-fade-in-up py-3 sm:py-4" style="animation-delay: 0.5s;">
                    <i data-lucide="flame" class="text-secondary mb-2 sm:mb-3 w-4 h-4 sm:w-5 sm:h-5"></i>
                    <span class="text-text/60 text-xs sm:text-sm">Difficulty</span>
                    <span class="text-text font-semibold text-lg sm:text-xl">{{ $recipe->difficulty->label() }}</span>
                </div>
            </div>

            {{-- ingredients and instructions --}}
            <div class="grid lg:grid-cols-3 gap-4 sm:gap-5 grid-cols-1">
                <div class="flex flex-col gap-3">
                    <div class="border-b-3 border-dashed border-primary/20 w-full flex py-2 sm:py-3">
                        <h1 class="text-primary text-xl sm:text-2xl font-semibold">Ingredients</h1>
                    </div>
                    <ul class="list-disc list-outside marker:text-secondary/60 marker:text-lg space-y-1">
                        @forelse($recipe->getIngredientListAttribute() as $ingredient)
                            <li class="text-text/60">{{ $ingredient }}</li>
                        @empty
                            <li class="text-text/60 italic">No ingredients listed</li>
                        @endforelse
                    </ul>
                </div>
                <div class="lg:col-span-2 flex flex-col gap-3">
                    <div class="border-b-3 border-dashed border-primary/20 w-full flex py-2 sm:py-3">
                        <h1 class="text-primary text-xl sm:text-2xl font-semibold">Instructions</h1>
                    </div>
                    <ul class="flex flex-col gap-2">
                        @forelse($recipe->steps as $step)
                            <li>
                                <div class="border-2 border-dashed border-primary/20 rounded-lg p-3 sm:p-4 bg-white/30">
                                    <div class="flex items-start gap-3 sm:gap-4">
                                        <!-- Step Number -->
                                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-secondary text-white rounded-full flex items-center justify-center font-semibold text-xs sm:text-sm flex-shrink-0">
                                            {{ $step->order }}
                                        </div>
                                        <!-- Step Content -->
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2 flex-wrap">
                                                <h3 class="font-semibold text-primary text-sm sm:text-base">{{ $step->stepType->label() }}</h3>
                                                @if($step->estimated_minutes_taken > 0)
                                                    <span class="text-xs bg-primary/10 text-primary px-2 py-1 rounded-full">
                                                        {{ $step->estimated_minutes_taken }} min
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-text leading-relaxed text-sm sm:text-base">
                                                {{ $step->description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li>
                                <div class="border-2 border-dashed border-primary/20 rounded-lg p-4 bg-white/30">
                                    <p class="text-text/60 italic">No instructions available</p>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- attempts section --}}
            <div class="flex flex-col gap-3">
                <div class="border-b-3 border-dashed border-primary/20 w-full flex py-2 sm:py-3 items-center justify-between">
                    <h1 class="text-primary text-xl sm:text-2xl font-semibold">Tried It?</h1>
                    <a class="flex items-center gap-2 hover:text-secondary hover:underline cursor-pointer text-sm sm:text-base">
                        <span class="hidden sm:inline">See all</span>
                        <span class="sm:hidden">All</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <div id="recipe-attempts-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @forelse($recipe->attempts->take(4) as $attempt)
                        <div class="border-2 border-dashed border-primary/20 rounded-lg overflow-hidden bg-white/30 flex flex-col">
                            <div class="w-full py-4 sm:py-5 flex items-center justify-center">
                                <img 
                                    src="{{ $attempt->image_url ? $attempt->image_url : asset('images/example-recipe.jpg') }}" 
                                    alt="Attempt by {{ $attempt->user->name ?? 'Unknown' }}" 
                                    class="rounded-full border-primary/20 border-2 border-dashed w-20 h-20 sm:w-24 sm:h-24 object-cover"
                                >
                            </div>
                            <div class="py-4 sm:py-5 px-3 flex flex-col gap-2 items-center justify-center">
                                @if($attempt->notes)
                                    <p class="text-sm text-text/70 text-center leading-relaxed">
                                        {{ Str::limit($attempt->notes, 80) }}
                                    </p>
                                @else
                                    <p class="text-sm text-text/70 text-center leading-relaxed italic">
                                        No notes provided
                                    </p>
                                @endif
                                <span class="text-sm font-semibold text-primary">—{{ $attempt->user->name ?? 'Anonymous' }}—</span>
                                @if($attempt->rating)
                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i data-lucide="star" class="w-3 h-3 {{ $i <= $attempt->rating ? 'text-yellow-500 fill-yellow-500' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div id="no-attempts-message" class="col-span-full">
                            <div class="rounded-lg p-6 sm:p-8 text-center">
                                <i data-lucide="chef-hat" class="w-10 h-10 sm:w-12 sm:h-12 text-secondary/60 mx-auto mb-3"></i>
                                <p class="text-text/60 text-sm sm:text-base">No one has tried this recipe yet!</p>
                                <p class="text-text/60 text-xs sm:text-sm">Be the first to share your cooking adventure.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="flex items-center justify-center flex-col gap-3 sm:gap-4 py-4">
                    <p class="text-text/60 text-sm sm:text-base text-center px-4">Trying this recipe this weekend?</p>
                    <x-button 
                        :variant="ButtonVariant::Secondary" 
                        :size="ButtonSize::Large" 
                        :text="'Share your attempt'" 
                        :icon="'<i data-lucide=\'camera\'></i>'"
                        data-action="show-recipe-attempt-popup"
                        class="cursor-pointer"
                    />
                </div>
            </div>
        </section>
    </section>

    @if(auth()->check())
        <script>
            window.currentUser = {
                name: @json(auth()->user()->name),
                username: @json(auth()->user()->username ?? ''),
                id: @json(auth()->user()->id)
            };
        </script>
    @endif
@endsection
