@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;
    
    $title = 'Educational Resources';
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Resources', 'url' => '/resources'],
        ['label' => 'Educational']
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
                Educational Resources
            </h1>
            <p class="text-text/70 text-lg leading-relaxed max-w-3xl">
                Expand your culinary knowledge with our comprehensive collection of educational materials, tutorials, and guides designed for cooks of all skill levels.
            </p>
        </div>

        {{-- Environmental Awareness --}}
        <div class="animate-fade-in-up">
            <div class="bg-white/30 border-2 border-dashed border-primary/20 rounded-2xl p-8 mb-8">
                <div class="flex items-center mb-6 gap-3">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mr-4">
                        <i data-lucide="leaf" class="w-6 h-6 text-primary"></i>
                    </div>
                    <h2 class="text-2xl font-semibold text-primary">Environmental Awareness</h2>
                </div>
                <p class="text-text/70 mb-6">Learn sustainable cooking practices and reduce your environmental impact in the kitchen.</p>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="flex items-center justify-between p-4 bg-green-500/10 rounded-2xl border-2 border-dashed border-green-500/20">
                        <div class="flex items-center gap-3">
                            <i data-lucide="recycle" class="w-5 h-5 text-green-600 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-primary">Zero Waste Cooking</h4>
                                <p class="text-text/60 text-sm">Minimize food waste techniques</p>
                            </div>
                        </div>
                        <a href="{{ asset('images/default-card.webp') }}" download="zero-waste-cooking.webp">
                            <x-button 
                                :variant="ButtonVariant::Primary" 
                                :size="ButtonSize::Small" 
                                :text="'Download'" 
                                class="cursor-pointer"
                            />
                        </a>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-green-500/10 rounded-2xl border-2 border-dashed border-green-500/20">
                        <div class="flex items-center gap-3">
                            <i data-lucide="shopping-cart" class="w-5 h-5 text-green-600 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-primary">Sustainable Shopping</h4>
                                <p class="text-text/60 text-sm">Eco-friendly ingredient sourcing</p>
                            </div>
                        </div>
                        <a href="{{ asset('images/default-card.webp') }}" download="sustainable-shopping.webp">
                            <x-button 
                                :variant="ButtonVariant::Primary" 
                                :size="ButtonSize::Small" 
                                :text="'Download'" 
                                class="cursor-pointer"
                            />
                        </a>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-green-500/10 rounded-2xl border-2 border-dashed border-green-500/20">
                        <div class="flex items-center gap-3">
                            <i data-lucide="globe" class="w-5 h-5 text-green-600 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-primary">Carbon Footprint</h4>
                                <p class="text-text/60 text-sm">Reduce cooking emissions</p>
                            </div>
                        </div>
                        <a href="{{ asset('images/default-card.webp') }}" download="carbon-footprint-cooking.webp">
                            <x-button 
                                :variant="ButtonVariant::Primary" 
                                :size="ButtonSize::Small" 
                                :text="'Download'" 
                                class="cursor-pointer"
                            />
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Resource Categories Grid --}}
        <div class="grid lg:grid-cols-2 gap-8 animate-fade-in-up" style="animation-delay: 0.1s;">
            {{-- Cooking Fundamentals --}}
            <div class="bg-white/30 border-2 border-dashed border-primary/20 rounded-2xl p-8">
                <div class="flex items-center mb-6 gap-3">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mr-4">
                        <i data-lucide="book" class="w-6 h-6 text-primary"></i>
                    </div>
                    <h2 class="text-2xl font-semibold text-primary">Cooking Fundamentals</h2>
                </div>
                <p class="text-text/70 mb-6">Master the essential techniques that form the foundation of great cooking.</p>
                
                <div class="space-y-4 mb-6">
                    <div class="flex items-center justify-between p-4 bg-primary/10 rounded-2xl border-2 border-dashed border-primary/20">
                        <div class="flex items-center gap-3">
                            <i data-lucide="play-circle" class="w-5 h-5 text-secondary mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-primary">Knife Skills Masterclass</h4>
                                <p class="text-text/60 text-sm">Essential cutting techniques (45 min video)</p>
                            </div>
                        </div>
                        <a href="{{ asset('images/default-vd.mp4') }}" download="knife-skills-masterclass.mp4">
                            <x-button 
                                :variant="ButtonVariant::Primary" 
                                :size="ButtonSize::Small" 
                                :text="'Download'" 
                                class="cursor-pointer"
                            />
                        </a>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-primary/10 rounded-2xl border-2 border-dashed border-primary/20">
                        <div class="flex items-center gap-3">
                            <i data-lucide="file-text" class="w-5 h-5 text-secondary mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-primary">Heat Control Guide</h4>
                                <p class="text-text/60 text-sm">Understanding temperature in cooking (PDF)</p>
                            </div>
                        </div>
                        <a href="{{ asset('images/default-card.webp') }}" download="heat-control-guide.webp">
                            <x-button 
                                :variant="ButtonVariant::Primary" 
                                :size="ButtonSize::Small" 
                                :text="'Download'" 
                                class="cursor-pointer"
                            />
                        </a>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-primary/10 rounded-2xl border-2 border-dashed border-primary/20">
                        <div class="flex items-center gap-3">
                            <i data-lucide="book-open" class="w-5 h-5 text-secondary mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-primary">Seasoning & Flavor Building</h4>
                                <p class="text-text/60 text-sm">Complete guide to taste development (eBook)</p>
                            </div>
                        </div>
                        <a href="{{ asset('images/default-card.webp') }}" download="seasoning-flavor-building.webp">
                            <x-button 
                                :variant="ButtonVariant::Primary" 
                                :size="ButtonSize::Small" 
                                :text="'Download'" 
                                class="cursor-pointer"
                            />
                        </a>
                    </div>
                </div>
            </div>

            {{-- Technique Tutorials --}}
            <div class="bg-white/30 border-2 border-dashed border-primary/20 rounded-2xl p-8">
                <div class="flex items-center mb-6 gap-3">
                    <div class="w-12 h-12 bg-secondary/10 rounded-full flex items-center justify-center mr-4">
                        <i data-lucide="video" class="w-6 h-6 text-secondary"></i>
                    </div>
                    <h2 class="text-2xl font-semibold text-primary">Video Tutorials</h2>
                </div>
                <p class="text-text/70 mb-6">Step-by-step video guides for advanced techniques and recipes.</p>
                
                <div class="space-y-4 mb-6">
                    <div class="flex items-center justify-between p-4 bg-secondary/10 rounded-2xl border-2 border-dashed border-secondary/20">
                        <div class="flex items-center gap-3">
                            <div class="w-16 h-12 mr-3 rounded overflow-hidden">
                                <video class="w-full h-full object-cover" muted>
                                    <source src="{{ asset('images/default-vd.mp4') }}" type="video/mp4">
                                </video>
                            </div>
                            <div>
                                <h4 class="font-semibold text-primary">Bread Making Basics</h4>
                                <p class="text-text/60 text-sm">From starter to finished loaf (2 hour series)</p>
                            </div>
                        </div>
                        <a href="{{ asset('images/default-vd.mp4') }}" download="bread-making-basics.mp4">
                            <x-button 
                                :variant="ButtonVariant::Secondary" 
                                :size="ButtonSize::Small" 
                                :text="'Watch'" 
                                class="cursor-pointer"
                            />
                        </a>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-secondary/10 rounded-2xl border-2 border-dashed border-secondary/20">
                        <div class="flex items-center gap-3">
                            <div class="w-16 h-12 mr-3 rounded overflow-hidden">
                                <video class="w-full h-full object-cover" muted>
                                    <source src="{{ asset('images/default-vd.mp4') }}" type="video/mp4">
                                </video>
                            </div>
                            <div>
                                <h4 class="font-semibold text-primary">Pasta from Scratch</h4>
                                <p class="text-text/60 text-sm">Hand-rolled pasta techniques (30 min)</p>
                            </div>
                        </div>
                        <a href="{{ asset('images/default-vd.mp4') }}" download="pasta-from-scratch.mp4">
                            <x-button 
                                :variant="ButtonVariant::Secondary" 
                                :size="ButtonSize::Small" 
                                :text="'Watch'" 
                                class="cursor-pointer"
                            />
                        </a>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-secondary/10 rounded-2xl border-2 border-dashed border-secondary/20">
                        <div class="flex items-center gap-3">
                            <div class="w-16 h-12 mr-3 rounded overflow-hidden">
                                <video class="w-full h-full object-cover" muted>
                                    <source src="{{ asset('images/default-vd.mp4') }}" type="video/mp4">
                                </video>
                            </div>
                            <div>
                                <h4 class="font-semibold text-primary">Sauce Fundamentals</h4>
                                <p class="text-text/60 text-sm">Master the five mother sauces (1 hour)</p>
                            </div>
                        </div>
                        <a href="{{ asset('images/default-vd.mp4') }}" download="sauce-fundamentals.mp4">
                            <x-button 
                                :variant="ButtonVariant::Secondary" 
                                :size="ButtonSize::Small" 
                                :text="'Watch'" 
                                class="cursor-pointer"
                            />
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Reference Materials --}}
        <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
            <h3 class="text-2xl font-semibold text-primary mb-6">Reference Materials</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white/30 border-2 border-dashed border-primary/20 rounded-2xl p-6">
                    <div class="w-full h-32 mb-4 rounded-2xl overflow-hidden">
                        <img src="{{ asset('images/default-card.webp') }}" alt="Temperature Guide" class="w-full h-full object-cover">
                    </div>
                    <div class="flex items-center mb-3 gap-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mr-3">
                            <i data-lucide="thermometer" class="w-5 h-5 text-primary"></i>
                        </div>
                        <h4 class="font-semibold text-primary">Temperature Guide</h4>
                    </div>
                    <p class="text-text/60 text-sm mb-4">Safe cooking temperatures for all proteins</p>
                    <a href="{{ asset('images/default-card.webp') }}" download="temperature-guide.webp" class="text-primary text-sm font-medium hover:underline cursor-pointer">Download Image</a>
                </div>
                
                <div class="bg-white/30 border-2 border-dashed border-primary/20 rounded-2xl p-6">
                    <div class="w-full h-32 mb-4 rounded-2xl overflow-hidden">
                        <img src="{{ asset('images/default-card.webp') }}" alt="Conversion Charts" class="w-full h-full object-cover">
                    </div>
                    <div class="flex items-center mb-3 gap-3">
                        <div class="w-10 h-10 bg-secondary/10 rounded-full flex items-center justify-center mr-3">
                            <i data-lucide="scale" class="w-5 h-5 text-secondary"></i>
                        </div>
                        <h4 class="font-semibold text-primary">Conversion Charts</h4>
                    </div>
                    <p class="text-text/60 text-sm mb-4">Measurements, weights, and temperatures</p>
                    <a href="{{ asset('images/default-card.webp') }}" download="conversion-charts.webp" class="text-primary text-sm font-medium hover:underline cursor-pointer">Download Image</a>
                </div>
                
                <div class="bg-white/30 border-2 border-dashed border-primary/20 rounded-2xl p-6">
                    <div class="w-full h-32 mb-4 rounded-2xl overflow-hidden">
                        <img src="{{ asset('images/default-card.webp') }}" alt="Seasonal Produce" class="w-full h-full object-cover">
                    </div>
                    <div class="flex items-center mb-3 gap-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mr-3">
                            <i data-lucide="calendar-days" class="w-5 h-5 text-primary"></i>
                        </div>
                        <h4 class="font-semibold text-primary">Seasonal Produce</h4>
                    </div>
                    <p class="text-text/60 text-sm mb-4">What's fresh throughout the year</p>
                    <a href="{{ asset('images/default-card.webp') }}" download="seasonal-produce.webp" class="text-primary text-sm font-medium hover:underline cursor-pointer">Download Image</a>
                </div>
                
                <div class="bg-white/30 border-2 border-dashed border-primary/20 rounded-2xl p-6">
                    <div class="w-full h-32 mb-4 rounded-2xl overflow-hidden">
                        <img src="{{ asset('images/default-card.webp') }}" alt="Herb & Spice Guide" class="w-full h-full object-cover">
                    </div>
                    <div class="flex items-center mb-3 gap-3">
                        <div class="w-10 h-10 bg-secondary/10 rounded-full flex items-center justify-center mr-3">
                            <i data-lucide="leaf" class="w-5 h-5 text-secondary"></i>
                        </div>
                        <h4 class="font-semibold text-primary">Herb & Spice Guide</h4>
                    </div>
                    <p class="text-text/60 text-sm mb-4">Flavor profiles and pairing suggestions</p>
                    <a href="{{ asset('images/default-card.webp') }}" download="herb-spice-guide.webp" class="text-primary text-sm font-medium hover:underline cursor-pointer">Download Image</a>
                </div>
                
                <div class="bg-white/30 border-2 border-dashed border-primary/20 rounded-2xl p-6">
                    <div class="w-full h-32 mb-4 rounded-2xl overflow-hidden">
                        <img src="{{ asset('images/default-card.webp') }}" alt="Cooking Times" class="w-full h-full object-cover">
                    </div>
                    <div class="flex items-center mb-3 gap-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mr-3">
                            <i data-lucide="clock" class="w-5 h-5 text-primary"></i>
                        </div>
                        <h4 class="font-semibold text-primary">Cooking Times</h4>
                    </div>
                    <p class="text-text/60 text-sm mb-4">Reference for all cooking methods</p>
                    <a href="{{ asset('images/default-card.webp') }}" download="cooking-times.webp" class="text-primary text-sm font-medium hover:underline cursor-pointer">Download Image</a>
                </div>
                
                <div class="bg-white/30 border-2 border-dashed border-primary/20 rounded-2xl p-6">
                    <div class="w-full h-32 mb-4 rounded-2xl overflow-hidden">
                        <img src="{{ asset('images/default-card.webp') }}" alt="Nutrition Facts" class="w-full h-full object-cover">
                    </div>
                    <div class="flex items-center mb-3 gap-3">
                        <div class="w-10 h-10 bg-secondary/10 rounded-full flex items-center justify-center mr-3">
                            <i data-lucide="apple" class="w-5 h-5 text-secondary"></i>
                        </div>
                        <h4 class="font-semibold text-primary">Nutrition Facts</h4>
                    </div>
                    <p class="text-text/60 text-sm mb-4">Nutritional information for common ingredients</p>
                    <a href="{{ asset('images/default-card.webp') }}" download="nutrition-facts.webp" class="text-primary text-sm font-medium hover:underline cursor-pointer">Download Image</a>
                </div>
            </div>
        </div>
    </section>
@endsection