@php
    use App\Enums\ButtonSize;
    use App\Enums\ButtonVariant;
    
    $title = 'Support';
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Support']
    ];
@endphp

@extends('layout.index')

@section('title', $title)

@section('content')
    <section class="w-full max-w-4xl mx-auto px-6 py-8">
        {{-- Simple header --}}
        <div class="mb-12">
            <h1 class="animate-on-scroll text-3xl font-semibold text-primary mb-4" data-delay="0.1s">
                Support
            </h1>
            <p class="animate-on-scroll text-text/70 leading-relaxed" data-delay="0.2s">
                Need help with something? Have a question? Found a bug? We're here to help make your Food Fusion experience smooth and enjoyable.
            </p>
        </div>

        {{-- Quick Help --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">Quick Help</h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="animate-on-scroll bg-primary/5 p-6 rounded border border-dashed border-primary/20" data-delay="0.2s">
                    <h3 class="font-medium text-primary mb-3">🍳 Recipe Questions</h3>
                    <div class="text-sm text-text/70 space-y-2">
                        <p><strong>Can't find an ingredient?</strong> Check the comments—other community members often suggest substitutions.</p>
                        <p><strong>Recipe not working?</strong> Double-check measurements and cooking times. When in doubt, ask the recipe creator directly.</p>
                        <p><strong>Want to modify a recipe?</strong> Go for it! Share your variations in the comments to help others.</p>
                    </div>
                </div>

                <div class="animate-on-scroll bg-primary/5 p-6 rounded border border-dashed border-primary/20" data-delay="0.3s">
                    <h3 class="font-medium text-primary mb-3">👤 Account Issues</h3>
                    <div class="text-sm text-text/70 space-y-2">
                        <p><strong>Can't log in?</strong> Check if Caps Lock is on, or try resetting your password.</p>
                        <p><strong>Want to change your username?</strong> Contact us—we can help with that.</p>
                        <p><strong>Need to update your email?</strong> Go to your profile settings or reach out if you need assistance.</p>
                    </div>
                </div>

                <div class="animate-on-scroll bg-primary/5 p-6 rounded border border-dashed border-primary/20" data-delay="0.4s">
                    <h3 class="font-medium text-primary mb-3">📤 Sharing Content</h3>
                    <div class="text-sm text-text/70 space-y-2">
                        <p><strong>Recipe submission stuck?</strong> Make sure all required fields are filled and images are under 5MB.</p>
                        <p><strong>Photos not uploading?</strong> Try refreshing the page or using a different browser.</p>
                        <p><strong>Want to edit a published recipe?</strong> Currently you'll need to contact us for major changes.</p>
                    </div>
                </div>

                <div class="animate-on-scroll bg-primary/5 p-6 rounded border border-dashed border-primary/20" data-delay="0.5s">
                    <h3 class="font-medium text-primary mb-3">🎉 Events & Community</h3>
                    <div class="text-sm text-text/70 space-y-2">
                        <p><strong>Want to attend an event?</strong> Check the events page and RSVP if required.</p>
                        <p><strong>Interested in hosting?</strong> We'd love to help you organize something—just reach out with your ideas.</p>
                        <p><strong>Community guidelines question?</strong> When in doubt, be respectful and food-focused.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Common Issues --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">Common Issues & Solutions</h2>
            
            <div class="space-y-4">
                <div class="animate-on-scroll bg-white/50 p-4 rounded border border-dashed border-primary/20" data-delay="0.2s">
                    <h4 class="font-medium text-primary mb-2">The site seems slow or unresponsive</h4>
                    <p class="text-sm text-text/70">
                        Try refreshing the page first. If that doesn't help, clear your browser cache or try a different browser. 
                        We're a small team, so during peak hours things might be a bit sluggish.
                    </p>
                </div>

                <div class="animate-on-scroll bg-white/50 p-4 rounded border border-dashed border-primary/20" data-delay="0.3s">
                    <h4 class="font-medium text-primary mb-2">I'm getting error messages</h4>
                    <p class="text-sm text-text/70">
                        Screenshot the error and send it our way. Include what you were trying to do when it happened. 
                        Most issues are quick fixes once we know what's going on.
                    </p>
                </div>

                <div class="animate-on-scroll bg-white/50 p-4 rounded border border-dashed border-primary/20" data-delay="0.4s">
                    <h4 class="font-medium text-primary mb-2">A recipe has incorrect or unsafe information</h4>
                    <p class="text-sm text-text/70">
                        Please report it immediately using the contact form. Food safety is our top priority, 
                        and we'll review and address any concerns right away.
                    </p>
                </div>

                <div class="animate-on-scroll bg-white/50 p-4 rounded border border-dashed border-primary/20" data-delay="0.5s">
                    <h4 class="font-medium text-primary mb-2">Someone is being inappropriate or spam-y</h4>
                    <p class="text-sm text-text/70">
                        Report it to us with details about what happened. We want to keep this a positive space for everyone, 
                        and we take community concerns seriously.
                    </p>
                </div>
            </div>
        </div>

        {{-- Contact Options --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">Get in Touch</h2>
            
            <div class="grid md:grid-cols-3 gap-6">
                <div class="animate-on-scroll text-center bg-secondary/10 p-6 rounded border border-dashed border-secondary/20" data-delay="0.2s">
                    <div class="text-2xl mb-3">📧</div>
                    <h3 class="font-medium text-primary mb-2">Email Support</h3>
                    <p class="text-sm text-text/70 mb-3">
                        For detailed questions, bug reports, or account issues. 
                        We usually respond within 24 hours.
                    </p>
                    <a href="{{ route('contact.index') }}">
                        <x-button 
                            :variant="ButtonVariant::Secondary"
                            :size="ButtonSize::Small"
                            :text="'Contact Form'"
                        />
                    </a>
                </div>

                <div class="animate-on-scroll text-center bg-secondary/10 p-6 rounded border border-dashed border-secondary/20" data-delay="0.3s">
                    <div class="text-2xl mb-3">💬</div>
                    <h3 class="font-medium text-primary mb-2">Community Discord</h3>
                    <p class="text-sm text-text/70 mb-3">
                        Chat with other community members and get quick help. 
                        Someone's usually around to answer questions.
                    </p>
                    <a href="{{ config('social-links.discord.server') }}" target="_blank">
                        <x-button 
                            :variant="ButtonVariant::Secondary"
                            :size="ButtonSize::Small"
                            :text="'Join Discord'"
                        />
                    </a>
                </div>

                <div class="animate-on-scroll text-center bg-secondary/10 p-6 rounded border border-dashed border-secondary/20" data-delay="0.4s">
                    <div class="text-2xl mb-3">🐛</div>
                    <h3 class="font-medium text-primary mb-2">Found a Bug?</h3>
                    <p class="text-sm text-text/70 mb-3">
                        Help us improve by reporting issues. Include screenshots 
                        and steps to reproduce the problem.
                    </p>
                    <a href="mailto:hello@foodfusion.community?subject=Bug%20Report">
                        <x-button 
                            :variant="ButtonVariant::Secondary"
                            :size="ButtonSize::Small"
                            :text="'Report Bug'"
                        />
                    </a>
                </div>
            </div>
        </div>

        {{-- Response Times --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">Response Times</h2>
            
            <div class="animate-on-scroll bg-primary/5 p-6 rounded border border-dashed border-primary/20" data-delay="0.2s">
                <div class="grid md:grid-cols-3 gap-6 text-center">
                    <div>
                        <div class="text-lg font-semibold text-primary">< 2 hours</div>
                        <div class="text-sm text-text/70">Urgent safety issues</div>
                    </div>
                    <div>
                        <div class="text-lg font-semibold text-primary">< 24 hours</div>
                        <div class="text-sm text-text/70">General support questions</div>
                    </div>
                    <div>
                        <div class="text-lg font-semibold text-primary">2-3 days</div>
                        <div class="text-sm text-text/70">Feature requests & suggestions</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Self-Service Resources --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">Helpful Resources</h2>
            
            <div class="animate-on-scroll space-y-3" data-delay="0.2s">
                <a href="{{ route('about') }}" class="block bg-white/50 p-4 rounded border border-dashed border-primary/20 hover:bg-primary/5 transition-colors">
                    <h4 class="font-medium text-primary mb-1">About Food Fusion</h4>
                    <p class="text-sm text-text/70">Learn about our community and what we're all about</p>
                </a>
                
                <a href="{{ route('terms') }}" class="block bg-white/50 p-4 rounded border border-dashed border-primary/20 hover:bg-primary/5 transition-colors">
                    <h4 class="font-medium text-primary mb-1">Community Guidelines</h4>
                    <p class="text-sm text-text/70">Our simple rules for keeping things friendly and food-focused</p>
                </a>
                
                <a href="{{ route('policies') }}" class="block bg-white/50 p-4 rounded border border-dashed border-primary/20 hover:bg-primary/5 transition-colors">
                    <h4 class="font-medium text-primary mb-1">Privacy & Cookies</h4>
                    <p class="text-sm text-text/70">How we handle your data and why we use cookies</p>
                </a>
                
                <a href="{{ route('volunteer') }}" class="block bg-white/50 p-4 rounded border border-dashed border-primary/20 hover:bg-primary/5 transition-colors">
                    <h4 class="font-medium text-primary mb-1">Get Involved</h4>
                    <p class="text-sm text-text/70">Ways to contribute to our growing community</p>
                </a>
            </div>
        </div>

        {{-- Still Need Help? --}}
        <div class="text-center">
            <div class="animate-on-scroll p-8 bg-secondary/10 rounded border border-dashed border-secondary/20" data-delay="0.1s">
                <h3 class="text-xl font-medium text-primary mb-4">Still Need Help?</h3>
                <p class="text-text/70 leading-relaxed mb-6">
                    Don't see your question answered here? No problem. We're a small but dedicated team, 
                    and we're happy to help with whatever you need. Just reach out and we'll figure it out together.
                </p>
                <a href="{{ route('contact.index') }}">
                    <x-button 
                        :variant="ButtonVariant::Primary"
                        :size="ButtonSize::Large"
                        :text="'Contact Support'"
                    />
                </a>
            </div>
        </div>
    </section>
@endsection
