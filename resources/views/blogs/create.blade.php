@php
    $title = 'Share Your Story';
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Community Cookbook', 'url' => route('blogs.index')],
        ['label' => 'Share Your Story', 'url' => route('blogs.create')]
    ];
@endphp

@extends('layout.index')

@section('title', $title)

@section('content')
    <section class="flex flex-col md:flex-row w-full gap-5 p-5 pb-12">
        <div class="flex flex-col md:w-[40%] animate-fade-in-left">
            <div class="blog-form-card rounded-lg p-6 bg-primary/5">
                <div class="mb-6">
                    <h1 class="text-lg font-bold text-primary flex items-center gap-2 mb-4">
                        <i data-lucide="feather"></i>
                        Community Guidelines
                    </h1>
                </div>
                
                <div class="space-y-4">
                    <p class="text-text leading-relaxed text-sm">
                        Share your culinary journey, cooking experiences, and food stories with our community. Here's what makes a great blog post:
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 border border-dashed border-secondary/40 rounded-lg bg-secondary/10 animate-fade-in-up" style="animation-delay: 0.1s;">
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-secondary text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-semibold">
                                    <i data-lucide="lightbulb" class="w-3 h-3"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-primary mb-1">Be Authentic</h3>
                                    <p class="text-xs text-text/60">
                                        Share your personal cooking experiences, failures, successes, and lessons learned.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 border border-dashed border-primary/40 rounded-lg bg-primary/10 animate-fade-in-up" style="animation-delay: 0.2s;">
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-semibold">
                                    <i data-lucide="users" class="w-3 h-3"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-primary mb-1">Add Value</h3>
                                    <p class="text-xs text-text/60">
                                        Include tips, techniques, or insights that can help fellow food enthusiasts.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 border border-dashed border-secondary/40 rounded-lg bg-secondary/10 animate-fade-in-up" style="animation-delay: 0.3s;">
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-secondary text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-semibold">
                                    <i data-lucide="heart" class="w-3 h-3"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-primary mb-1">Stay Respectful</h3>
                                    <p class="text-xs text-text/60">
                                        Keep content family-friendly and respect diverse culinary traditions and preferences.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-primary/5 p-4 rounded-lg border border-dashed border-primary/20 animate-fade-in-up" style="animation-delay: 0.4s;">
                        <p class="text-xs text-text/60">
                            <strong>Great topics include:</strong> cooking adventures, kitchen disasters and recoveries, family recipes, seasonal cooking, ingredient spotlights, cooking techniques, food culture, and dining experiences.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:w-[60%] md:px-5 animate-fade-in-right" id="blog-form-section" style="animation-delay: 0.2s;">
            @include('blogs.blog-form')
        </div>
    </section>
@endsection