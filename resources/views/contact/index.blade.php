@php
    $title = 'Contact Us';
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Contact Us']
    ];
@endphp

@extends('layout.index')

@section('title', $title)

@section('content')
    <section class="flex w-full gap-5 p-5 pb-12">
        <div class="animate-fade-in-left w-[60%] px-5" data-delay="0.1s">
            @include('contact.contact-form')
        </div>
        <div class="animate-fade-in-right flex flex-col w-[40%]" id="contact-form-section" data-delay="0.2s">
            <div class="rounded-lg p-6 bg-primary/5 border border-dashed border-primary/20">
                <div class="mb-6">
                    <h1 class="text-lg font-bold text-primary flex items-center gap-2 mb-4">
                        <i data-lucide="help-circle"></i>
                        How We Handle Messages
                    </h1>
                </div>
                
                <div class="space-y-4">
                    <p class="text-text leading-relaxed text-sm">
                        We appreciate you reaching out! Here’s how we handle your contact form submissions:
                    </p>

                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="animate-on-scroll text-center p-4 border border-dashed border-secondary/40 rounded-lg bg-secondary/10" data-delay="0.3s">
                            <div class="w-8 h-8 bg-secondary text-white rounded-full flex items-center justify-center mx-auto mb-2 font-semibold">
                                1
                            </div>
                            <h3 class="font-semibold text-primary mb-2">You Submit</h3>
                            <p class="text-xs text-text/60">
                                Fill in the subject, type, and your message. You may choose to remain anonymous.
                            </p>
                        </div>

                        <div class="animate-on-scroll text-center p-4 border border-dashed border-primary/40 rounded-lg bg-primary/10" data-delay="0.4s">
                            <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-2 font-semibold">
                                2
                            </div>
                            <h3 class="font-semibold text-primary mb-2">We Review</h3>
                            <p class="text-xs text-text/60">
                                Our team reviews your submission to ensure it’s directed to the right department.
                            </p>
                        </div>

                        <div class="animate-on-scroll text-center p-4 border border-dashed border-secondary/40 rounded-lg bg-secondary/10" data-delay="0.5s">
                            <div class="w-8 h-8 bg-secondary text-white rounded-full flex items-center justify-center mx-auto mb-2 font-semibold">
                                3
                            </div>
                            <h3 class="font-semibold text-primary mb-2">We Respond</h3>
                            <p class="text-xs text-text/60">
                                You’ll receive a response (if not anonymous) or your feedback will be recorded internally.
                            </p>
                        </div>
                    </div>

                    <div class="animate-on-scroll bg-primary/5 p-4 rounded-lg border border-dashed border-primary/20" data-delay="0.6s">
                        <p class="text-xs text-text/60">
                            <strong>Note:</strong> Response times vary, but we usually reply within 2–5 business days. Anonymous submissions are recorded but may not receive direct replies.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
