@php
    use App\Enums\ButtonSize;
    use App\Enums\ButtonVariant;

    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Cookbook', 'url' => '/blogs'],
        ['label' => $blog->title, 'url' => '/blogs/' . $blog->id],
    ];
@endphp

@extends('layout.index')

@section('title', $blog->title)

@section('content')
    <section id="blog-details" data-blog-id="{{ $blog->id }}" class="flex items-center justify-center pb-8 sm:pb-16 px-4 sm:px-6">
        <section class="flex flex-col w-full max-w-sm sm:max-w-md md:max-w-2xl lg:max-w-4xl gap-4 sm:gap-5">

            {{-- featured image --}}
            <div class="w-full">
                <img src="{{ asset('images/example-recipe.jpg') }}" alt="{{ $blog->title }}" 
                    class="w-full h-48 sm:h-56 md:h-64 object-cover rounded-2xl border-2 border-dashed border-primary/20">
            </div>

            {{-- header --}}
            <div class="w-full relative">
                <div class="flex flex-col gap-2 pr-4 sm:pr-16 md:pr-20">
                    <h1 class="text-primary text-xl sm:text-2xl md:text-3xl font-bold">{{ $blog->title }}</h1>
                    @php
                        $wordCount = strlen($blog->content) < 100 ? 500 : str_word_count($blog->content);
                        $readTime = ceil($wordCount / 200);
                    @endphp
                    <div class="flex items-center gap-2">
                        <i data-lucide="clock" class="text-secondary w-4 h-4"></i>
                        <span class="text-text/60 text-sm">{{ $readTime }} min read</span>
                    </div>

                    <div class="flex gap-1.5 sm:gap-2 flex-wrap">
                        @if($blog->tags && $blog->tags->count() > 0)
                            @foreach($blog->tags as $tag)
                                <div class="bg-secondary/20 border-2 border-primary/20 rounded-full px-2 py-1 border-dashed text-xs">
                                    {{ $tag->name }}
                                </div>
                            @endforeach
                        @endif
                        <div class="bg-secondary/20 border-2 border-primary/20 rounded-full px-2 py-1 border-dashed text-xs">
                            Blog Post
                        </div>
                    </div>

                    <h3 class="text-primary text-sm">
                        By <a class="font-medium hover:underline hover:text-secondary cursor-pointer">{{ $blog->author->name }}</a>
                    </h3>
                    <p class="text-text/60 text-xs">Published {{ $blog->created_at->format('H:i, F j, Y') }}</p>
                </div>
            </div>

            {{-- voting --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0 py-3 px-3 sm:px-4 bg-primary/5 rounded-lg border border-primary/10">
                <div class="flex items-center gap-3">
                    @php
                        $userVote = auth()->user() ? $blog->getUserVote(auth()->user()->id) : null;
                        $upvoteClasses = $userVote && $userVote->isUpvote() ? 'border-green-500 text-green-500' : 'border-text/60 text-text/60';
                        $downvoteClasses = $userVote && $userVote->isDownvote() ? 'border-red-500 text-red-500' : 'border-text/60 text-text/60';
                    @endphp
                    <div class="flex items-center gap-1">
                        <button data-blog-id="{{ $blog->id }}" 
                            class="blog-upvote-button {{ $upvoteClasses }} p-1.5 sm:p-1 rounded border cursor-pointer hover:border-green-500 hover:text-green-500 transition-colors">
                            <i data-lucide="arrow-up" class="w-4 h-4"></i>
                        </button>
                        <span class="vote-count-display text-text font-medium text-sm min-w-[20px] text-center">
                            {{ $blog->vote_score }}
                        </span>
                        <button data-blog-id="{{ $blog->id }}" 
                            class="blog-downvote-button {{ $downvoteClasses }} p-1.5 sm:p-1 rounded border cursor-pointer hover:border-red-500 hover:text-red-500 transition-colors">
                            <i data-lucide="arrow-down" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-3 text-xs text-text/60 flex-wrap">
                    <button class="to-comments flex items-center gap-1 hover:text-secondary transition-colors cursor-pointer p-1">
                        <i data-lucide="message-circle" class="w-3 h-3"></i>
                        <span class="hidden sm:inline">Comment</span>
                    </button>
                    <button class="flex items-center gap-1 hover:text-secondary transition-colors cursor-pointer p-1">
                        <i data-lucide="share-2" class="w-3 h-3"></i>
                        <span class="hidden sm:inline">Share</span>
                    </button>
                    <button class="flex items-center gap-1 hover:text-secondary transition-colors cursor-pointer p-1">
                        <i data-lucide="bookmark" class="w-3 h-3"></i>
                        <span class="hidden sm:inline">Save</span>
                    </button>
                    <button class="flex items-center gap-1 hover:text-secondary transition-colors cursor-pointer p-1">
                        <i data-lucide="download" class="w-3 h-3"></i>
                        <span class="hidden sm:inline">Download</span>
                    </button>
                </div>
            </div>

            {{-- content --}}
            <article class="prose prose-lg max-w-none text-text leading-relaxed">
                {!! nl2br(e($blog->content)) !!}
            </article>

            {{-- comments --}}
            <div id="comment-section" class="flex flex-col gap-4 mt-12 sm:mt-16 pt-6 sm:pt-8 border-t border-primary/10">
                <div class="w-full flex py-2 items-center justify-between">
                    <h2 class="text-primary text-base sm:text-lg font-medium">
                        Comments (<span id="comment-count">{{ $blog->comments->count() }}</span>)
                    </h2>
                </div>

                <div class="border border-primary/10 rounded-lg p-3 sm:p-4 bg-white/20">
                    <form data-blog-id="{{ $blog->id }}" id="comment-upload-form" method="POST" class="w-full">
                        @csrf
                        <div class="flex flex-col gap-3">
                            <div class="relative">
                                <textarea 
                                    id="comment-content"
                                    name="content"
                                    placeholder="Share your thoughts on this article..."
                                    class="w-full p-2.5 sm:p-3 border border-primary/20 rounded-lg bg-white/50 resize-none focus:outline-none focus:border-secondary text-sm"
                                    rows="3"
                                    maxlength="1000"
                                    required
                                ></textarea>
                                <div class="absolute bottom-2 right-2 text-xs text-text/50">
                                    <span id="char-count">0</span>/1000
                                </div>
                            </div>
                            <div class="flex justify-end items-center">
                                <x-button 
                                    type="submit"
                                    :size="ButtonSize::Small"
                                    :variant="ButtonVariant::Secondary"
                                    :icon="'<i data-lucide=\'send\' class=\'w-4 h-4\'></i>'"
                                    :text="'Post Comment'"
                                />
                            </div>
                        </div>
                    </form>
                </div>

                <script>
                    // Character counter for comment textarea
                    document.addEventListener('DOMContentLoaded', function() {
                        const textarea = document.getElementById('comment-content');
                        const charCount = document.getElementById('char-count');
                        
                        if (textarea && charCount) {
                            textarea.addEventListener('input', function() {
                                charCount.textContent = this.value.length;
                            });
                        }
                    });
                </script>

                <div id="comments-list" class="flex flex-col gap-3">
                    @forelse($blog->comments as $comment)
                        <div class="border-l-2 border-primary/20 pl-3 sm:pl-4 py-2 comment-item">
                            <div class="flex items-start gap-2 sm:gap-3">
                                <div class="w-7 h-7 sm:w-8 sm:h-8 bg-secondary/10 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="user" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-secondary/60"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                                        <h4 class="font-medium text-primary text-sm">{{ $comment->user->name }}</h4>
                                        <span class="text-xs text-text/50">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-text/80 text-sm leading-relaxed">{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div id="no-comments" class="text-center py-4 sm:py-6">
                            <i data-lucide="message-circle" class="w-6 h-6 sm:w-8 sm:h-8 text-secondary/40 mx-auto mb-2"></i>
                            <p class="text-text/60 text-sm">No comments yet.</p>
                            <p class="text-text/50 text-xs">Be the first to share your thoughts.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- related articles --}}
            <div class="flex flex-col gap-4 mt-8 sm:mt-12 pt-4 sm:pt-6 border-t border-primary/10">
                <div class="w-full flex py-2">
                    <h2 class="text-primary text-base sm:text-lg font-medium">Related Articles</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    {{-- Placeholder --}}
                    <div class="border border-primary/10 rounded-lg p-3 bg-white/20 cursor-pointer hover:bg-white/30 transition-colors">
                        <div class="flex gap-3">
                            <img src="{{ asset('images/example-recipe.jpg') }}" alt="Related article" 
                                class="w-14 h-14 sm:w-16 sm:h-16 object-cover rounded-lg border border-primary/10 flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-primary mb-1 text-sm leading-tight">10 Essential Cooking Tips for Beginners</h4>
                                <p class="text-text/60 text-xs mb-1 line-clamp-2">Master the basics with these fundamental cooking techniques...</p>
                                <span class="text-xs text-secondary/80">5 min read</span>
                            </div>
                        </div>
                    </div>
                    <div class="border border-primary/10 rounded-lg p-3 bg-white/20 cursor-pointer hover:bg-white/30 transition-colors">
                        <div class="flex gap-3">
                            <img src="{{ asset('images/example-recipe.jpg') }}" alt="Related article" 
                                class="w-14 h-14 sm:w-16 sm:h-16 object-cover rounded-lg border border-primary/10 flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-primary mb-1 text-sm leading-tight">The Science Behind Perfect Pasta</h4>
                                <p class="text-text/60 text-xs mb-1 line-clamp-2">Understanding the chemistry that makes pasta al dente...</p>
                                <span class="text-xs text-secondary/80">8 min read</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </section>
@endsection
