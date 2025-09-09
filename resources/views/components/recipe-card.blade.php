@php
    use App\Enums\DifficultyLevel;
    
    $difficultyColors = [
        DifficultyLevel::Easy->value => 'bg-green-100 text-green-800 border-green-200',
        DifficultyLevel::Medium->value => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        DifficultyLevel::Hard->value => 'bg-red-100 text-red-800 border-red-200',
    ];
    
    $difficultyColor = $difficultyColors[$recipe->difficulty->value] ?? 'bg-gray-100 text-gray-800 border-gray-200';
@endphp

<a href="{{ route('recipes.show', ['uuid' => $recipe->id]) }}" class="block group bg-secondary/10 border-dashed border-2 rounded-2xl border-primary/20 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 cursor-pointer">
    <div class="relative aspect-[4/3] overflow-hidden">
        @if($recipe->image_url)
            <img src="{{ $recipe->image_url }}" 
                 alt="{{ $recipe->name }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/30 flex items-center justify-center">
                <i class="fa-solid fa-utensils text-4xl text-primary/40"></i>
            </div>
        @endif
        
        <div class="absolute top-3 right-3">
            <span class="px-2 py-1 rounded-full text-xs font-medium border backdrop-blur-sm">
                {{ $recipe->difficulty->value }}
            </span>
        </div>

        @if($recipe->servings)
            <div class="absolute top-3 left-3">
                <span class="px-2 py-1 rounded-full text-xs font-medium bg-black/50 text-white backdrop-blur-sm">
                    <i class="fa-solid fa-users text-xs mr-1"></i>{{ $recipe->servings }}
                </span>
            </div>
        @endif
    </div>

    <div class="p-4">
        <h3 class="text-lg font-semibold text-text mb-2 line-clamp-2 group-hover:text-primary transition-colors duration-300">
            {{ $recipe->name }}
        </h3>

        @if($recipe->description)
            <p class="text-sm text-text/70 mb-3 line-clamp-1 leading-relaxed">
                {{ $recipe->description }}
            </p>
        @endif

        @if($recipe->relationLoaded('tags') && $recipe->tags && $recipe->tags->count() > 0)
            <div class="flex flex-wrap gap-1 mb-3">
                @foreach($recipe->tags->take(3) as $tag)
                    <span class="px-2 py-1 bg-secondary/10 text-secondary text-xs rounded-full">
                        {{ $tag->name }}
                    </span>
                @endforeach
                @if($recipe->tags->count() > 3)
                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                        +{{ $recipe->tags->count() - 3 }}
                    </span>
                @endif
            </div>
        @endif

        <div class="flex items-center justify-between pt-3 border-t border-primary/10">
            <div class="flex items-center gap-2 text-xs text-text/60">
                <div class="flex items-center gap-1">
                    <i class="fa-solid fa-user-chef text-primary"></i>
                    <span>{{ $recipe->author_name ?? 'Anonymous' }}</span>
                </div>
                @if($recipe->created_at)
                    <span>•</span>
                    <span>{{ $recipe->created_at->diffForHumans() }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="absolute inset-0 bg-secondary/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
        <div class="bg-white/90 backdrop-blur-sm rounded-full p-3 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
            <i class="fa-solid fa-arrow-right text-primary"></i>
        </div>
    </div>
</a>
