@php
    use App\Enums\ButtonSize;
    use App\Enums\ButtonVariant;
    
    $title = 'Volunteer Opportunities';
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Volunteer Opportunities']
    ];
@endphp

@extends('layout.index')

@section('title', $title)

@section('content')
    <section class="w-full max-w-4xl mx-auto px-6 py-8">
        {{-- Simple header --}}
        <div class="mb-12">
            <h1 class="animate-on-scroll text-3xl font-semibold text-primary mb-4" data-delay="0.1s">
                Volunteer Opportunities
            </h1>
            <p class="animate-on-scroll text-text/70 leading-relaxed" data-delay="0.2s">
                Help us build something amazing. Whether you have 10 minutes or 10 hours, there's a way to contribute to our food community.
            </p>
        </div>

        {{-- Why Volunteer --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">Why volunteer with us?</h2>
            
            <div class="grid md:grid-cols-3 gap-6">
                <div class="animate-on-scroll bg-primary/5 p-4 rounded border border-dashed border-primary/20" data-delay="0.2s">
                    <h3 class="text-base font-medium text-primary mb-3">Learn & Grow</h3>
                    <p class="text-sm text-text/70">
                        Gain experience in community building, content creation, or event management while helping food lovers connect.
                    </p>
                </div>
                
                <div class="animate-on-scroll bg-primary/5 p-4 rounded border border-dashed border-primary/20" data-delay="0.3s">
                    <h3 class="text-base font-medium text-primary mb-3">Flexible Time</h3>
                    <p class="text-sm text-text/70">
                        Contribute on your schedule. Help when you can, step back when life gets busy. No pressure.
                    </p>
                </div>
                
                <div class="animate-on-scroll bg-primary/5 p-4 rounded border border-dashed border-primary/20" data-delay="0.4s">
                    <h3 class="text-base font-medium text-primary mb-3">Real Impact</h3>
                    <p class="text-sm text-text/70">
                        See your contributions help real people discover new recipes and connect over shared meals.
                    </p>
                </div>
            </div>
        </div>

        {{-- Current Opportunities --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">Current Opportunities</h2>
            
            <div class="space-y-6">
                <div class="animate-on-scroll bg-white/50 p-6 rounded border border-dashed border-primary/20" data-delay="0.2s">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-medium text-primary">Content Moderator</h3>
                        <span class="text-xs bg-secondary/20 text-secondary px-2 py-1 rounded">Remote</span>
                    </div>
                    <p class="text-sm text-text/70 mb-3">
                        Help review recipe submissions and ensure they meet our community guidelines. 
                        Perfect for detail-oriented food enthusiasts.
                    </p>
                    <div class="text-xs text-text/60">
                        <strong>Time:</strong> 2-3 hours per week • <strong>Skills:</strong> Food knowledge, attention to detail
                    </div>
                </div>

                <div class="animate-on-scroll bg-white/50 p-6 rounded border border-dashed border-primary/20" data-delay="0.3s">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-medium text-primary">Community Manager</h3>
                        <span class="text-xs bg-secondary/20 text-secondary px-2 py-1 rounded">Remote</span>
                    </div>
                    <p class="text-sm text-text/70 mb-3">
                        Welcome new members, moderate discussions, and help foster positive interactions in our community.
                    </p>
                    <div class="text-xs text-text/60">
                        <strong>Time:</strong> 5-7 hours per week • <strong>Skills:</strong> Communication, empathy
                    </div>
                </div>

                <div class="animate-on-scroll bg-white/50 p-6 rounded border border-dashed border-primary/20" data-delay="0.4s">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-medium text-primary">Recipe Tester</h3>
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Your Kitchen</span>
                    </div>
                    <p class="text-sm text-text/70 mb-3">
                        Try out community recipes and provide feedback on clarity, taste, and difficulty level. 
                        Get to cook new dishes while helping others!
                    </p>
                    <div class="text-xs text-text/60">
                        <strong>Time:</strong> 1-2 recipes per month • <strong>Skills:</strong> Love of cooking, honest feedback
                    </div>
                </div>

                <div class="animate-on-scroll bg-white/50 p-6 rounded border border-dashed border-primary/20" data-delay="0.5s">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-medium text-primary">Event Assistant</h3>
                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">Hybrid</span>
                    </div>
                    <p class="text-sm text-text/70 mb-3">
                        Help organize cooking classes, potluck events, and food festivals. Support both online and in-person gatherings.
                    </p>
                    <div class="text-xs text-text/60">
                        <strong>Time:</strong> Project-based • <strong>Skills:</strong> Organization, people skills
                    </div>
                </div>
            </div>

            <div class="animate-on-scroll mt-6 bg-secondary/10 p-4 border-l-4 border-secondary" data-delay="0.6s">
                <p class="text-sm text-text/70">
                    <strong>Don't see something that fits?</strong> We're always open to new ideas. 
                    Have a skill or passion you think could help? Let's talk about creating a custom volunteer role for you.
                </p>
            </div>
        </div>

        {{-- Getting Started --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">Getting Started</h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="animate-on-scroll space-y-4" data-delay="0.2s">
                    <div class="bg-primary/5 p-4 rounded border border-dashed border-primary/20">
                        <h4 class="font-medium text-primary mb-2">1. Reach Out</h4>
                        <p class="text-sm text-text/70">
                            Send us a message about what interests you. No formal application needed—just tell us about yourself.
                        </p>
                    </div>
                    
                    <div class="bg-primary/5 p-4 rounded border border-dashed border-primary/20">
                        <h4 class="font-medium text-primary mb-2">2. Quick Chat</h4>
                        <p class="text-sm text-text/70">
                            We'll have a casual conversation to understand your interests and find the right fit.
                        </p>
                    </div>
                </div>
                
                <div class="animate-on-scroll space-y-4" data-delay="0.3s">
                    <div class="bg-primary/5 p-4 rounded border border-dashed border-primary/20">
                        <h4 class="font-medium text-primary mb-2">3. Start Small</h4>
                        <p class="text-sm text-text/70">
                            Begin with a small task or project to see how things feel. No long-term commitment required.
                        </p>
                    </div>
                    
                    <div class="bg-primary/5 p-4 rounded border border-dashed border-primary/20">
                        <h4 class="font-medium text-primary mb-2">4. Grow Together</h4>
                        <p class="text-sm text-text/70">
                            Take on more responsibilities as you get comfortable, or keep things light. Your choice.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- What We Provide --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">What We Provide</h2>
            
            <div class="animate-on-scroll bg-secondary/10 p-6 rounded border border-dashed border-secondary/20" data-delay="0.2s">
                <div class="grid md:grid-cols-2 gap-6 text-sm">
                    <div>
                        <h4 class="font-medium text-primary mb-3">Support & Training</h4>
                        <ul class="text-text/70 space-y-1">
                            <li>• Clear guidelines and documentation</li>
                            <li>• One-on-one mentoring when needed</li>
                            <li>• Regular check-ins and feedback</li>
                            <li>• Access to volunteer-only Discord channel</li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="font-medium text-primary mb-3">Perks & Recognition</h4>
                        <ul class="text-text/70 space-y-1">
                            <li>• Early access to new features</li>
                            <li>• Volunteer badge on your profile</li>
                            <li>• Free access to premium cooking classes</li>
                            <li>• Annual volunteer appreciation dinner</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ready to Start? --}}
        <div class="text-center">
            <div class="animate-on-scroll p-8 bg-primary/5 rounded border border-dashed border-primary/20" data-delay="0.1s">
                <h3 class="text-xl font-medium text-primary mb-4">Ready to Get Involved?</h3>
                <p class="text-text/70 leading-relaxed mb-6">
                    Join a community of food lovers who are passionate about sharing knowledge and building connections. 
                    Every contribution, big or small, makes a difference.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact.index') }}">
                        <x-button 
                            :variant="ButtonVariant::Primary"
                            :size="ButtonSize::Large"
                            :text="'Get Started'"
                        />
                    </a>
                    <a href="{{ config('social-links.discord.server') }}" target="_blank">
                        <x-button 
                            :variant="ButtonVariant::Secondary"
                            :size="ButtonSize::Large"
                            :text="'Join Our Discord'"
                        />
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
