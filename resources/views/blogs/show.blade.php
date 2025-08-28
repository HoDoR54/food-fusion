@php
    use App\Enums\ButtonSize;
    use App\Enums\ButtonVariant;

    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Cookbook', 'url' => '/cookbook'],
        ['label' => $blog->title, 'url' => '/cookbook/' . $blog->id],
    ];
@endphp

@extends('layout.index')

@section('title', $blog->title)

@section('content')
    <section id="blog-details" data-blog-id="{{ $blog->id }}" class="flex items-center justify-center pb-16">
        <section class="flex flex-col min-w-[50vw] lg:max-w-[60vw] gap-5">

            {{-- featured image --}}
            <div class="w-full">
                <img src="{{ asset('images/example-recipe.jpg') }}" alt="{{ $blog->title }}" 
                    class="w-full h-64 object-cover rounded-2xl border-2 border-dashed border-primary/20">
            </div>

            {{-- header --}}
            <div class="w-full relative">
                <div class="flex flex-col gap-2 pr-20">
                    <h1 class="text-primary text-3xl font-bold">{{ $blog->title }}</h1>
                    @php
                        $wordCount = strlen($blog->content) < 100 ? 500 : str_word_count($blog->content);
                        $readTime = ceil($wordCount / 200);
                    @endphp
                    <div class="flex items-center gap-2">
                        <i data-lucide="clock" class="text-secondary w-4 h-4"></i>
                        <span class="text-text/60 text-sm">{{ $readTime }} min read</span>
                    </div>

                    <div class="flex gap-2 flex-wrap">
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
            <div class="flex items-center justify-between py-3 px-4 bg-primary/5 rounded-lg border border-primary/10">
                <div class="flex items-center gap-3">
                    @php
                        $userVote = auth()->user() ? $blog->getUserVote(auth()->user()->id) : null;
                        $upvoteClasses = $userVote && $userVote->isUpvote() ? 'border-green-500 text-green-500' : 'border-text/60 text-text/60';
                        $downvoteClasses = $userVote && $userVote->isDownvote() ? 'border-red-500 text-red-500' : 'border-text/60 text-text/60';
                    @endphp
                    <div class="flex items-center gap-1">
                        <button data-blog-id="{{ $blog->id }}" 
                            class="blog-upvote-button {{ $upvoteClasses }} p-1 rounded border cursor-pointer hover:border-green-500 hover:text-green-500 transition-colors">
                            <i data-lucide="arrow-up" class="w-4 h-4"></i>
                        </button>
                        <span class="vote-count-display text-text font-medium text-sm min-w-[20px] text-center">
                            {{ $blog->vote_score }}
                        </span>
                        <button data-blog-id="{{ $blog->id }}" 
                            class="blog-downvote-button {{ $downvoteClasses }} p-1 rounded border cursor-pointer hover:border-red-500 hover:text-red-500 transition-colors">
                            <i data-lucide="arrow-down" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-3 text-xs text-text/60">
                    <button class="to-comments flex items-center gap-1 hover:text-secondary transition-colors cursor-pointer">
                        <i data-lucide="message-circle" class="w-3 h-3"></i>
                        <span>Comment</span>
                    </button>
                    <button class="flex items-center gap-1 hover:text-secondary transition-colors cursor-pointer">
                        <i data-lucide="share-2" class="w-3 h-3"></i>
                        <span>Share</span>
                    </button>
                    <button class="flex items-center gap-1 hover:text-secondary transition-colors cursor-pointer">
                        <i data-lucide="bookmark" class="w-3 h-3"></i>
                        <span>Save</span>
                    </button>
                    <button class="flex items-center gap-1 hover:text-secondary transition-colors cursor-pointer">
                        <i data-lucide="download" class="w-3 h-3"></i>
                        <span>Download</span>
                    </button>
                </div>
            </div>

            {{-- content --}}
            <article class="prose prose-lg max-w-none text-text leading-relaxed">
                {!! nl2br(e($blog->content)) !!}
            </article>

            {{-- comments --}}
            <div id="comment-section" class="flex flex-col gap-4 mt-16 pt-8 border-t border-primary/10">
                <div class="w-full flex py-2 items-center justify-between">
                    <h2 class="text-primary text-lg font-medium">
                        Comments (<span id="comment-count">{{ $blog->comments->count() }}</span>)
                    </h2>
                </div>

                <div class="border border-primary/10 rounded-lg p-4 bg-white/20">
                    <form data-blog-id="{{ $blog->id }}" id="comment-upload-form" method="POST" class="w-full">
                        @csrf
                        <div class="flex flex-col gap-3">
                            <div class="relative">
                                <textarea 
                                    id="comment-content"
                                    name="content"
                                    placeholder="Share your thoughts on this article..."
                                    class="w-full p-3 border border-primary/20 rounded-lg bg-white/50 resize-none focus:outline-none focus:border-secondary text-sm"
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
                        <div class="border-l-2 border-primary/20 pl-4 py-2 comment-item">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-secondary/10 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="user" class="w-4 h-4 text-secondary/60"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h4 class="font-medium text-primary text-sm">{{ $comment->user->name }}</h4>
                                        <span class="text-xs text-text/50">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-text/80 text-sm leading-relaxed">{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div id="no-comments" class="text-center py-6">
                            <i data-lucide="message-circle" class="w-8 h-8 text-secondary/40 mx-auto mb-2"></i>
                            <p class="text-text/60 text-sm">No comments yet.</p>
                            <p class="text-text/50 text-xs">Be the first to share your thoughts.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- related articles --}}
            <div class="flex flex-col gap-4 mt-12 pt-6 border-t border-primary/10">
                <div class="w-full flex py-2">
                    <h2 class="text-primary text-lg font-medium">Related Articles</h2>
                </div>
                <div class="grid md:grid-cols-2 gap-3">
                    {{-- Placeholder --}}
                    <div class="border border-primary/10 rounded-lg p-3 bg-white/20 cursor-pointer hover:bg-white/30 transition-colors">
                        <div class="flex gap-3">
                            <img src="{{ asset('images/example-recipe.jpg') }}" alt="Related article" 
                                class="w-16 h-16 object-cover rounded-lg border border-primary/10">
                            <div class="flex-1">
                                <h4 class="font-medium text-primary mb-1 text-sm">10 Essential Cooking Tips for Beginners</h4>
                                <p class="text-text/60 text-xs mb-1">Master the basics with these fundamental cooking techniques...</p>
                                <span class="text-xs text-secondary/80">5 min read</span>
                            </div>
                        </div>
                    </div>
                    <div class="border border-primary/10 rounded-lg p-3 bg-white/20 cursor-pointer hover:bg-white/30 transition-colors">
                        <div class="flex gap-3">
                            <img src="{{ asset('images/example-recipe.jpg') }}" alt="Related article" 
                                class="w-16 h-16 object-cover rounded-lg border border-primary/10">
                            <div class="flex-1">
                                <h4 class="font-medium text-primary mb-1 text-sm">The Science Behind Perfect Pasta</h4>
                                <p class="text-text/60 text-xs mb-1">Understanding the chemistry that makes pasta al dente...</p>
                                <span class="text-xs text-secondary/80">8 min read</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </section>
@endsection
