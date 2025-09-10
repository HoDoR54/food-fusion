@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;
    
    $title = 'Culinary Tools & Equipment';
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Resources', 'url' => '/resources'],
        ['label' => 'Culinary Tools']
    ];
@endphp

@extends('layout.index')

@section('title', $title)

@section('content')
    <section class="flex flex-col w-full max-w-6xl mx-auto px-6 py-8 gap-8">
        {{-- Header --}}
        <div class="animate-fade-in-up">
            <nav class="mb-6">
                <a href="/resources" class="text-primary hover:text-primary/80 text-sm flex items-center gap-2">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back to Resources
                </a>
            </nav>
            <h1 class="text-4xl font-bold text-primary mb-4">
                Culinary Tools & Equipment
            </h1>
            <p class="text-text/70 text-lg leading-relaxed max-w-3xl">
                Discover professional-grade tools and equipment to elevate your cooking. From essential knives to specialty gadgets, 
                find everything you need to equip your kitchen like a pro.
            </p>
        </div>

        <div class="animate-fade-in-up">
            <h2 class="text-2xl font-semibold text-primary mb-8">Essential Kitchen Tools</h2>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Chef's Knife --}}
                <div class="bg-white/30 border-2 border-dashed border-primary/20 rounded-2xl p-6">
                    <div class="w-full h-48 bg-primary/10 rounded-2xl mb-4 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/default-card.webp') }}" alt="Professional Chef's Knife" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-semibold text-primary mb-2">Professional Chef's Knife</h3>
                    <p class="text-text/70 text-sm mb-4">8-10 inch high-carbon steel blade for precision cutting</p>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm">
                            <i data-lucide="star" class="w-4 h-4 text-yellow-500 mr-2"></i>
                            <span class="text-text/60">Essential Tool</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i data-lucide="dollar-sign" class="w-4 h-4 text-secondary mr-2"></i>
                            <span class="text-text/60">$80 - $200</span>
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                        <a href="{{ asset('images/default-card.webp') }}" download="chef-knife-guide.webp" class="flex-1">
                            <x-button 
                                :variant="ButtonVariant::Primary" 
                                :size="ButtonSize::Small" 
                                :text="'Download Guide'" 
                                class="w-full cursor-pointer"
                            />
                        </a>
                    </div>
                </div>

                {{-- Cast Iron Pan --}}
                <div class="bg-white/30 border-2 border-dashed border-primary/20 rounded-2xl p-6">
                    <div class="w-full h-48 bg-secondary/10 rounded-2xl mb-4 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/default-card.webp') }}" alt="Cast Iron Skillet" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-semibold text-primary mb-2">Cast Iron Skillet</h3>
                    <p class="text-text/70 text-sm mb-4">12-inch pre-seasoned cast iron for versatile cooking</p>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm">
                            <i data-lucide="star" class="w-4 h-4 text-yellow-500 mr-2"></i>
                            <span class="text-text/60">Must-Have</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i data-lucide="dollar-sign" class="w-4 h-4 text-secondary mr-2"></i>
                            <span class="text-text/60">$25 - $60</span>
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                        <a href="{{ asset('images/default-card.webp') }}" download="cast-iron-guide.webp" class="flex-1">
                            <x-button 
                                :variant="ButtonVariant::Primary" 
                                :size="ButtonSize::Small" 
                                :text="'Download Guide'" 
                                class="w-full cursor-pointer"
                            />
                        </a>
                    </div>
                </div>

                {{-- Stand Mixer --}}
                <div class="bg-white/30 border-2 border-dashed border-primary/20 rounded-2xl p-6">
                    <div class="w-full h-48 bg-primary/10 rounded-2xl mb-4 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/default-card.webp') }}" alt="Stand Mixer" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-semibold text-primary mb-2">Stand Mixer</h3>
                    <p class="text-text/70 text-sm mb-4">Professional-grade mixer for baking and cooking</p>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm">
                            <i data-lucide="award" class="w-4 h-4 text-yellow-500 mr-2"></i>
                            <span class="text-text/60">Pro Level</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i data-lucide="dollar-sign" class="w-4 h-4 text-secondary mr-2"></i>
                            <span class="text-text/60">$200 - $500</span>
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                        <a href="{{ asset('images/default-card.webp') }}" download="stand-mixer-guide.webp" class="flex-1">
                            <x-button 
                                :variant="ButtonVariant::Primary" 
                                :size="ButtonSize::Small" 
                                :text="'Download Guide'" 
                                class="w-full cursor-pointer"
                            />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection