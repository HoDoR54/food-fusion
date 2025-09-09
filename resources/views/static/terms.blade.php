@php
    use App\Enums\ButtonSize;
    use App\Enums\ButtonVariant;
    
    $title = 'Terms & Conditions';
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Terms & Conditions']
    ];
@endphp

@extends('layout.index')

@section('title', $title)

@section('content')
    <section class="w-full max-w-4xl mx-auto px-6 py-8">
        {{-- Simple header --}}
        <div class="mb-12">
            <h1 class="animate-on-scroll text-3xl font-semibold text-primary mb-4" data-delay="0.1s">
                Terms & Conditions
            </h1>
            <p class="animate-on-scroll text-text/70 leading-relaxed" data-delay="0.2s">
                Simple rules to keep our community friendly and our recipes flowing. Nothing fancy, just the basics.
            </p>
        </div>

        {{-- Community Guidelines --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">Community Guidelines</h2>
            
            <div class="space-y-6">
                <div class="animate-on-scroll bg-primary/5 p-6 rounded border border-dashed border-primary/20" data-delay="0.2s">
                    <h3 class="font-medium text-primary mb-3">Be respectful</h3>
                    <p class="text-sm text-text/70">
                        We're all here to learn and share. Treat others with kindness, even if their cooking style 
                        is different from yours. No harassment, hate speech, or personal attacks.
                    </p>
                </div>

                <div class="animate-on-scroll bg-primary/5 p-6 rounded border border-dashed border-primary/20" data-delay="0.3s">
                    <h3 class="font-medium text-primary mb-3">Share authentic content</h3>
                    <p class="text-sm text-text/70">
                        Only post recipes you've actually tried or content you've created. 
                        Don't copy recipes from cookbooks or other websites without permission.
                    </p>
                </div>

                <div class="animate-on-scroll bg-primary/5 p-6 rounded border border-dashed border-primary/20" data-delay="0.4s">
                    <h3 class="font-medium text-primary mb-3">Keep it food-related</h3>
                    <p class="text-sm text-text/70">
                        This is a cooking community. Posts should be about recipes, cooking tips, 
                        ingredients, or food culture. Save the political debates for other platforms.
                    </p>
                </div>
            </div>
        </div>

        {{-- Content & Sharing --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">Content & Sharing</h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="animate-on-scroll bg-white/50 p-4 rounded border border-dashed border-primary/20" data-delay="0.2s">
                    <h3 class="font-medium text-primary mb-3">Your recipes, your rights</h3>
                    <p class="text-sm text-text/70">
                        You keep ownership of recipes you share. We just get permission to display them 
                        on the platform and let other members cook from them.
                    </p>
                </div>
                
                <div class="animate-on-scroll bg-white/50 p-4 rounded border border-dashed border-primary/20" data-delay="0.3s">
                    <h3 class="font-medium text-primary mb-3">Community sharing</h3>
                    <p class="text-sm text-text/70">
                        When you post here, other members can save, share, and cook your recipes. 
                        That's the whole point—spreading good food around.
                    </p>
                </div>
            </div>

            <div class="animate-on-scroll mt-6 bg-secondary/10 p-4 border-l-4 border-secondary" data-delay="0.4s">
                <p class="text-sm text-text/70">
                    <strong>Copyright issues?</strong> If someone shares your content without permission, 
                    let us know and we'll sort it out quickly.
                </p>
            </div>
        </div>

        {{-- Account Responsibilities --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">Account Responsibilities</h2>
            
            <div class="animate-on-scroll space-y-4 text-sm text-text/70" data-delay="0.2s">
                <div class="bg-primary/5 p-4 rounded border border-dashed border-primary/20">
                    <p><strong>Keep your account secure:</strong> Don't share your password or let others use your account.</p>
                </div>
                
                <div class="bg-primary/5 p-4 rounded border border-dashed border-primary/20">
                    <p><strong>One account per person:</strong> We don't allow multiple accounts or fake profiles.</p>
                </div>
                
                <div class="bg-primary/5 p-4 rounded border border-dashed border-primary/20">
                    <p><strong>Accurate information:</strong> Use your real name and keep your profile info up to date.</p>
                </div>
            </div>
        </div>

        {{-- Safety & Liability --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">Safety & Liability</h2>
            
            <div class="animate-on-scroll bg-yellow-50 border border-yellow-200 p-6 rounded" data-delay="0.2s">
                <h3 class="font-medium text-yellow-800 mb-3">⚠️ Important Food Safety Notice</h3>
                <div class="text-sm text-yellow-700 space-y-2">
                    <p>
                        Recipes are shared by community members based on their experience. 
                        Always use your judgment when it comes to food safety.
                    </p>
                    <ul class="mt-2 space-y-1 ml-4">
                        <li>• Check expiration dates and ingredient freshness</li>
                        <li>• Follow proper cooking temperatures and food handling</li>
                        <li>• Be aware of allergies and dietary restrictions</li>
                        <li>• When in doubt, don't risk it</li>
                    </ul>
                </div>
            </div>

            <div class="animate-on-scroll mt-6 text-sm text-text/60" data-delay="0.3s">
                <p>
                    We're not responsible for any issues that arise from following recipes on the platform. 
                    Cook safely and trust your instincts.
                </p>
            </div>
        </div>

        {{-- Platform Use --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">Platform Use</h2>
            
            <div class="animate-on-scroll space-y-4" data-delay="0.2s">
                <div class="bg-white/50 p-4 rounded border border-dashed border-primary/20">
                    <h3 class="font-medium text-primary mb-2">What's allowed</h3>
                    <p class="text-sm text-text/70">
                        Share recipes, ask questions, give feedback, participate in events, 
                        connect with other food lovers, and learn new cooking techniques.
                    </p>
                </div>
                
                <div class="bg-white/50 p-4 rounded border border-dashed border-primary/20">
                    <h3 class="font-medium text-primary mb-2">What's not allowed</h3>
                    <p class="text-sm text-text/70">
                        Spam, commercial promotion, automated posting, data scraping, 
                        or anything that disrupts the community experience.
                    </p>
                </div>
            </div>
        </div>

        {{-- Changes & Updates --}}
        <div class="mb-12">
            <h2 class="animate-on-scroll text-xl font-medium text-primary mb-6" data-delay="0.1s">Changes & Updates</h2>
            
            <div class="animate-on-scroll bg-secondary/10 p-6 rounded border border-dashed border-secondary/20" data-delay="0.2s">
                <p class="text-sm text-text/70">
                    We might update these terms occasionally as we grow and learn. 
                    If we make significant changes, we'll let you know via email or a site notification. 
                    Continuing to use the platform means you're okay with any updates.
                </p>
            </div>
        </div>

        {{-- Contact & Resolution --}}
        <div class="text-center">
            <div class="animate-on-scroll p-6 bg-primary/5 rounded border border-dashed border-primary/20" data-delay="0.1s">
                <h3 class="font-medium text-primary mb-3">Questions or Problems?</h3>
                <p class="text-text/70 text-sm mb-4">
                    If you have questions about these terms or need to report an issue, 
                    we're here to help. Let's talk it through.
                </p>
                <a href="{{ route('contact.index') }}">
                    <x-button 
                        :variant="ButtonVariant::Primary"
                        :size="ButtonSize::Medium"
                        :text="'Get in Touch'"
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