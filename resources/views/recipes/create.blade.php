@php
    $title = 'Share Your Recipe';
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Share Your Recipe', 'url' => route('recipes.create.show')]
    ];
@endphp

@extends('layout.index')

@section('title', $title)

@section('content')
    <section class="flex w-full gap-5 p-5 pb-12">
        <div class="flex flex-col w-[40%] animate-fade-in-left">
            <div class="recipe-form-card rounded-lg p-6 bg-primary/5">
                <div class="mb-6">
                    <h1 class="text-lg font-bold text-primary flex items-center gap-2 mb-4">
                        <i data-lucide="book-open"></i>
                        Standard Process
                    </h1>
                </div>
                
                <div class="space-y-4">
                    <p class="text-text leading-relaxed text-sm">
                        We believe every great recipe deserves to be shared thoughtfully. Here's how our community recipe process works:
                    </p>

                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="text-center p-4 border border-dashed border-secondary/40 rounded-lg bg-secondary/10 animate-fade-in-up" style="animation-delay: 0.1s;">
                            <div class="w-8 h-8 bg-secondary text-white rounded-full flex items-center justify-center mx-auto mb-2 font-semibold">
                                1
                            </div>
                            <h3 class="font-semibold text-primary mb-2">You Submit</h3>
                            <p class="text-xs text-text/60">
                                Fill out the form below with your recipe details, ingredients, and step-by-step instructions.
                            </p>
                        </div>

                        <div class="text-center p-4 border border-dashed border-primary/40 rounded-lg bg-primary/10 animate-fade-in-up" style="animation-delay: 0.2s;">
                            <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-2 font-semibold">
                                2
                            </div>
                            <h3 class="font-semibold text-primary mb-2">We Review</h3>
                            <p class="text-xs text-text/60">
                                Our community moderators review your recipe for clarity, completeness, and community guidelines.
                            </p>
                        </div>

                        <div class="text-center p-4 border border-dashed border-secondary/40 rounded-lg bg-secondary/10 animate-fade-in-up" style="animation-delay: 0.3s;">
                            <div class="w-8 h-8 bg-secondary text-white rounded-full flex items-center justify-center mx-auto mb-2 font-semibold">
                                3
                            </div>
                            <h3 class="font-semibold text-primary mb-2">Community Enjoys</h3>
                            <p class="text-xs text-text/60">
                                Once approved, your recipe joins our curated collection for everyone to discover and try.
                            </p>
                        </div>
                    </div>

                    <div class="bg-primary/5 p-4 rounded-lg border border-dashed border-primary/20 animate-fade-in-up" style="animation-delay: 0.4s;">
                        <p class="text-xs text-text/60">
                            <strong>Review typically takes 2-3 days.</strong> We'll email you once your recipe is approved or if we need any clarifications. Our goal is to maintain a high-quality collection that serves our community well.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-[60%] px-5 animate-fade-in-right" id="recipe-form-section" style="animation-delay: 0.2s;">
            @include('recipes.recipe-form')
        </div>
    </section>
@endsection