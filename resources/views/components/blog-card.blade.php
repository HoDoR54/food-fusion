@php
    $readTime = ceil(str_word_count(strip_tags($blog->content)) / 200);
@endphp

<a href="{{ route('blogs.show', ['uuid' => $blog->id]) }}" class="block group bg-secondary/10 border-dashed border-2 rounded-2xl border-primary/20 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 cursor-pointer">
    <div class="flex flex-col md:flex-row">
        <div class="relative w-full md:w-1/3 h-48 md:h-48 overflow-hidden flex-shrink-0">
            @if($blog->image_url)
                <img src="{{ $blog->image_url }}" 
                    alt="{{ $blog->title }}" 
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @else
                <div class="w-full h-full bg-gradient-to-br from-secondary/20 to-primary/30 flex items-center justify-center">
                    <i class="fa-solid fa-book-open text-3xl text-secondary/40"></i>
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

        <div class="flex flex-col justify-between w-full md:w-2/3 p-5">
            <div>
                <h3 class="text-xl font-semibold text-text mb-2 line-clamp-2 group-hover:text-primary transition-colors duration-300">
                    {{ $blog->title }}
                </h3>

                <p class="text-sm text-text/70 mb-3 line-clamp-3 leading-relaxed">
                    {{ Str::limit(strip_tags($blog->content), 200) }}
                </p>

                @if($blog->relationLoaded('tags') && $blog->tags && $blog->tags->count() > 0)
                    <div class="flex flex-wrap gap-1 mb-3">
                        @foreach($blog->tags->take(3) as $tag)
                            <span class="px-2 py-1 bg-secondary/10 text-secondary text-xs rounded-full">
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
            </div>

            <div class="flex items-center justify-between pt-3 border-t border-primary/10 mt-3">
                <div class="flex items-center gap-2 text-xs text-text/60">
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-user-pen text-primary"></i>
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
    </div>

    <div class="absolute inset-0 bg-secondary/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
        <div class="bg-white/90 backdrop-blur-sm rounded-full p-3 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
            <i class="fa-solid fa-arrow-right text-primary"></i>
        </div>
    </div>
</a>
