@php
    use App\Enums\ButtonSize;
    use App\Enums\ButtonVariant;
    
    $title = 'Privacy & Cookies Policies';
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Privacy & Cookies Policies']
    ];
@endphp

@extends('layout.index')

@section('title', $title)

@section('content')
    <section class="w-full max-w-4xl mx-auto px-6 py-8">
        {{-- Simple header --}}
        <div class="mb-12">
            <h1 class="animate-on-scroll text-3xl font-semibold text-primary mb-4" data-delay="0.1s">
                Privacy & Cookies Policies
            </h1>
            <p class="animate-on-scroll text-text/70 leading-relaxed" data-delay="0.2s">
                We believe in transparency. Here's how we handle your data and why we use cookies.
            </p>
        </div>

        {{-- Privacy Policy --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">Privacy Policy</h2>
            
            <div class="space-y-6">
                <div class="animate-on-scroll bg-primary/5 p-6 rounded border border-dashed border-primary/20" data-delay="0.2s">
                    <h3 class="font-medium text-primary mb-3">What we collect</h3>
                    <ul class="text-sm text-text/70 space-y-2">
                        <li>• Your name and email when you register</li>
                        <li>• Recipes and content you share with the community</li>
                        <li>• Basic usage data to improve our platform</li>
                        <li>• Comments and interactions with other members</li>
                    </ul>
                </div>

                <div class="animate-on-scroll bg-primary/5 p-6 rounded border border-dashed border-primary/20" data-delay="0.3s">
                    <h3 class="font-medium text-primary mb-3">How we use it</h3>
                    <div class="text-sm text-text/70 space-y-2">
                        <p>We use your information to:</p>
                        <ul class="mt-2 space-y-1 ml-4">
                            <li>• Keep your account secure and functional</li>
                            <li>• Show you recipes and content you might like</li>
                            <li>• Send important updates (no spam, promise)</li>
                            <li>• Help connect you with other food lovers</li>
                        </ul>
                    </div>
                </div>

                <div class="animate-on-scroll bg-primary/5 p-6 rounded border border-dashed border-primary/20" data-delay="0.4s">
                    <h3 class="font-medium text-primary mb-3">What we don't do</h3>
                    <div class="text-sm text-text/70 space-y-2">
                        <p>We will never:</p>
                        <ul class="mt-2 space-y-1 ml-4">
                            <li>• Sell your personal information to third parties</li>
                            <li>• Share your recipes without your permission</li>
                            <li>• Send you unwanted marketing emails</li>
                            <li>• Track you across other websites</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cookies Policy --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">Cookies Policy</h2>
            
            <div class="space-y-6">
                <div class="animate-on-scroll" data-delay="0.2s">
                    <p class="text-text/70 mb-4">
                        We use cookies to keep things working smoothly. Here's what they do:
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="animate-on-scroll bg-white/50 p-4 rounded border border-dashed border-primary/20" data-delay="0.3s">
                        <h3 class="font-medium text-primary mb-3">Essential Cookies</h3>
                        <p class="text-sm text-text/70">
                            These keep you logged in and make sure the site works properly. 
                            We can't turn these off without breaking things.
                        </p>
                    </div>
                    
                    <div class="animate-on-scroll bg-white/50 p-4 rounded border border-dashed border-primary/20" data-delay="0.4s">
                        <h3 class="font-medium text-primary mb-3">Preference Cookies</h3>
                        <p class="text-sm text-text/70">
                            Remember your settings like dark mode preferences and language choices. 
                            Makes your experience better.
                        </p>
                    </div>
                </div>

                <div class="animate-on-scroll bg-secondary/10 p-4 border-l-4 border-secondary" data-delay="0.5s">
                    <p class="text-sm text-text/70">
                        <strong>Good news:</strong> We don't use tracking or advertising cookies. 
                        Your browsing stays private.
                    </p>
                </div>
            </div>
        </div>

        {{-- Your Rights --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">Your Rights</h2>
            
            <div class="animate-on-scroll bg-primary/5 p-6 rounded border border-dashed border-primary/20" data-delay="0.2s">
                <div class="text-sm text-text/70 space-y-3">
                    <p><strong>Access:</strong> Want to see what data we have about you? Just ask.</p>
                    <p><strong>Correction:</strong> Notice something wrong? We'll fix it right away.</p>
                    <p><strong>Deletion:</strong> Want to delete your account? No problem, no questions asked.</p>
                    <p><strong>Export:</strong> Need your data? We'll give you everything in a readable format.</p>
                </div>
            </div>
        </div>

        {{-- Contact --}}
        <div class="text-center">
            <div class="animate-on-scroll p-6 bg-secondary/10 rounded flex flex-col items-center justify-center border border-dashed border-secondary/20" data-delay="0.1s">
                <h3 class="font-medium text-primary mb-3">Questions?</h3>
                <p class="text-text/70 text-sm mb-4">
                    If anything here doesn't make sense or you have concerns about your privacy, 
                    just reach out. We're happy to explain or help.
                </p>
                <a href="{{ route('contact.index') }}">
                    <x-button 
                        :variant="ButtonVariant::Primary"
                        :size="ButtonSize::Medium"
                        :text="'Contact Us'"
                    />
                </a>
            </div>
        </div>

        {{-- Last Updated --}}
        <div class="mt-8 text-center">
            <p class="text-xs text-text/50">
                Last updated: September 2025
            </p>
        </div>
    </section>
@endsection