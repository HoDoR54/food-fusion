@php
    $title = 'About Us';
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'About Us']
    ];
@endphp

@extends('layout.index')

@section('title', $title)

@section('content')
    <section class="w-full max-w-4xl mx-auto px-6 py-8">
        {{-- Simple header --}}
        <div class="mb-12">
            <h1 class="text-3xl font-semibold text-primary mb-4">
                About Food Fusion
            </h1>
            <p class="text-text/70 leading-relaxed">
                A community of food lovers sharing recipes and connecting over great meals. Simple, honest, and focused on what matters.
            </p>
        </div>

        {{-- The story --}}
        <div class="mb-12">
            <h2 class="text-xl font-medium text-primary mb-6">How it all started</h2>
            <div class="space-y-4 text-text/80 leading-relaxed">
                <p>
                    We got tired of recipe websites cluttered with ads and endless stories about someone's childhood. 
                    All we wanted was a clean place where people could share actual recipes without the noise.
                </p>
                <p>
                    It started small—a few friends sharing their favorite dishes. Word spread, more people joined, 
                    and now we have home cooks from different countries sharing their family recipes and discoveries.
                </p>
                <p>
                    We're not trying to be perfect. We're focused on being genuine. Real people, real food, real connections.
                </p>
            </div>
            
            <div class="mt-8 p-4 bg-primary/5 border-l-4 border-secondary">
                <p class="text-sm text-text/70 italic">
                    "The best communities grow naturally around shared passions" - and ours happened to be good food
                </p>
            </div>
        </div>

        {{-- What we're about --}}
        <div class="mb-12">
            <h2 class="text-xl font-medium text-primary mb-6">What we believe in</h2>
            
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-primary/5 p-4 rounded border border-dashed border-primary/20">
                    <h3 class="text-base font-medium text-primary mb-3">Keep it authentic</h3>
                    <p class="text-sm text-text/70">
                        No fake reviews or sponsored posts. Real people sharing recipes they actually make and love.
                    </p>
                </div>
                
                <div class="bg-primary/5 p-4 rounded border border-dashed border-primary/20">
                    <h3 class="text-base font-medium text-primary mb-3">Everyone belongs</h3>
                    <p class="text-sm text-text/70">
                        Whether you're just learning to cook or you're a seasoned chef, there's a place for you here.
                    </p>
                </div>
                
                <div class="bg-primary/5 p-4 rounded border border-dashed border-primary/20">
                    <h3 class="text-base font-medium text-primary mb-3">Learn and grow</h3>
                    <p class="text-sm text-text/70">
                        Share tips, discover new techniques, and help each other become better cooks along the way.
                    </p>
                </div>
            </div>
        </div>

        {{-- The people --}}
        <div class="mb-12">
            <h2 class="text-xl font-medium text-primary mb-6">Members</h2>
            <p class="text-text/70 mb-8">
                A small team passionate about food and community. We're learning as we go and always listening to feedback.
            </p>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="flex gap-4 p-4 bg-white/50 rounded border border-dashed border-primary/20">
                    <img src="{{ asset('images/users/hpone-tauk-nyi.jpg') }}" 
                         alt="Hpone Tauk Nyi" 
                         class="w-16 h-16 rounded object-cover flex-shrink-0">
                    <div>
                        <h3 class="font-medium text-primary mb-1">Hpone Tauk Nyi</h3>
                        <p class="text-sm text-secondary mb-2">Founder</p>
                        <p class="text-sm text-text/70">
                            The original. Started Food Fusion.
                        </p>
                    </div>
                </div>
                
                <div class="flex gap-4 p-4 bg-white/50 rounded border border-dashed border-primary/20">
                    <img src="{{ asset('images/users/cooler-hpone-tauk-nyi.jpg') }}" 
                         alt="Cooler Hpone Tauk Nyi" 
                         class="w-16 h-16 rounded object-cover flex-shrink-0">
                    <div>
                        <h3 class="font-medium text-primary mb-1">Cooler Hpone Tauk Nyi</h3>
                        <p class="text-sm text-secondary mb-2">Co-Founder</p>
                        <p class="text-sm text-text/70">
                            The same person but cooler.
                        </p>
                    </div>
                </div>
                
                <div class="flex gap-4 p-4 bg-white/50 rounded border border-dashed border-primary/20">
                    <img src="{{ asset('images/users/bald-hpone-tauk-nyi.jpg') }}" 
                         alt="Bald Hpone Tauk Nyi" 
                         class="w-16 h-16 rounded object-cover flex-shrink-0">
                    <div>
                        <h3 class="font-medium text-primary mb-1">Bald Hpone Tauk Nyi</h3>
                        <p class="text-sm text-secondary mb-2">Co-Founder</p>
                        <p class="text-sm text-text/70">
                            Lost his hair, gained wisdom.
                        </p>
                    </div>
                </div>
                
                <div class="flex gap-4 p-4 bg-white/50 rounded border border-dashed border-primary/20">
                    <img src="{{ asset('images/users/mastauche-hpone-tauk-nyi.jpg') }}" 
                         alt="Mustache Hpone Tauk Nyi" 
                         class="w-16 h-16 rounded object-cover flex-shrink-0">
                    <div>
                        <h3 class="font-medium text-primary mb-1">Mustache Hpone Tauk Nyi</h3>
                        <p class="text-sm text-secondary mb-2">Co-Founder</p>
                        <p class="text-sm text-text/70">
                            The distinguished one.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Some numbers --}}
        <div class="mb-12">
            <h2 class="text-xl font-medium text-primary mb-6">Where we're at</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-4 border border-dashed border-primary/30 rounded">
                    <div class="text-lg font-semibold text-primary">400+</div>
                    <div class="text-xs text-text/60">Members</div>
                </div>
                <div class="text-center p-4 border border-dashed border-primary/30 rounded">
                    <div class="text-lg font-semibold text-primary">200+</div>
                    <div class="text-xs text-text/60">Recipes</div>
                </div>
                <div class="text-center p-4 border border-dashed border-primary/30 rounded">
                    <div class="text-lg font-semibold text-primary">12</div>
                    <div class="text-xs text-text/60">Events</div>
                </div>
                <div class="text-center p-4 border border-dashed border-primary/30 rounded">
                    <div class="text-lg font-semibold text-primary">15+</div>
                    <div class="text-xs text-text/60">Countries</div>
                </div>
            </div>
        </div>

        {{-- That's it --}}
        <div class="text-center">
            <div class="p-8 bg-primary/5 rounded border border-dashed border-primary/20">
                <p class="text-text/70 leading-relaxed mb-4">
                    That's our story so far. We're building something simple but meaningful—a place where people can share great food 
                    and connect with others who love cooking. If you have a recipe worth sharing, we'd love to have you join us.
                </p>
                <p class="text-sm text-text/60">
                    Thanks for taking the time to learn about us. Now go make something delicious! 🍳
                </p>
            </div>
        </div>
    </section>
@endsection