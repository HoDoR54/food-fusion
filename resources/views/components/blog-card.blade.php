@php
    $readTime = ceil(str_word_count(strip_tags($blog->content)) / 200);
@endphp

<a href="{{ route('blogs.show', ['id' => $blog->id]) }}" class="block group bg-secondary/10 border-dashed rounded-2xl border-2 border-primary/20 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 cursor-pointer">
    <div class="relative aspect-[4/3] overflow-hidden">
        @if($blog->image_url)
            <img src="{{ $blog->image_url }}" 
                 alt="{{ $blog->title }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full bg-gradient-to-br from-secondary/20 to-primary/30 flex items-center justify-center">
                <i class="fa-solid fa-book-open text-4xl text-secondary/40"></i>
            </div>
        @endif
        
        <div class="absolute top-3 right-3">
            <span class="px-2 py-1 rounded-full text-xs font-medium bg-black/50 text-white backdrop-blur-sm">
                <i class="fa-solid fa-clock text-xs mr-1"></i>{{ $readTime }} min read
            </span>
        </div>

        @if($blog->relationLoaded('tags') && $blog->tags && $blog->tags->count() > 0)
            <div class="absolute top-3 left-3">
                <span class="px-2 py-1 rounded-full text-xs font-medium bg-secondary/80 text-white backdrop-blur-sm">
                    {{ $blog->tags->first()->name }}
                </span>
            </div>
        @endif
    </div>

    <div class="p-4">
        <h3 class="text-lg font-semibold text-text mb-2 line-clamp-2 group-hover:text-secondary transition-colors duration-300">
            {{ $blog->title }}
        </h3>

        <p class="text-sm text-text/70 mb-3 line-clamp-3 leading-relaxed">
            {{ Str::limit(strip_tags($blog->content), 120) }}
        </p>

        @if($blog->relationLoaded('tags') && $blog->tags && $blog->tags->count() > 0)
            <div class="flex flex-wrap gap-1 mb-3">
                @foreach($blog->tags->take(3) as $tag)
                    <span class="px-2 py-1 bg-primary/10 text-primary text-xs rounded-full">
                        {{ $tag->name }}
                    </span>
                @endforeach
                @if($blog->tags->count() > 3)
                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                        +{{ $blog->tags->count() - 3 }}
                    </span>
                @endif
            </div>
        @endif

        <div class="flex items-center justify-between pt-3 border-t border-primary/10">
            <div class="flex items-center gap-2 text-xs text-text/60">
                <div class="flex items-center gap-1">
                    <i class="fa-solid fa-user-pen text-secondary"></i>
                    <span>{{ $blog->author->name ?? 'Anonymous' }}</span>
                </div>
                @if($blog->created_at)
                    <span>•</span>
                    <span>{{ $blog->created_at->diffForHumans() }}</span>
                @endif
            </div>
            
            <div class="flex items-center gap-3 text-xs">
                @if(method_exists($blog, 'getVoteScoreAttribute'))
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-heart text-red-500"></i>
                        <span class="text-text/70 font-medium">{{ $blog->vote_score }}</span>
                    </div>
                @endif
                
                @if($blog->relationLoaded('comments') && $blog->comments && $blog->comments->count() > 0)
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-comments text-blue-500"></i>
                        <span class="text-text/70 font-medium">{{ $blog->comments->count() }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="absolute inset-0 bg-secondary/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
        <div class="bg-white/90 backdrop-blur-sm rounded-full p-3 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
            <i class="fa-solid fa-arrow-right text-secondary"></i>
        </div>
    </div>
</a>
