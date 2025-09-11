{{-- Modern loading state component --}}
@props([
    'title' => 'Loading...',
    'subtitle' => 'Please wait while we fetch the latest content',
    'icon' => 'loader-2'
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center py-12 px-6']) }}>
    <div class="relative">
        <i data-lucide="{{ $icon }}" class="w-12 h-12 text-primary animate-spin mb-4"></i>
        <div class="absolute inset-0 w-12 h-12 border-2 border-primary/20 border-t-primary rounded-full animate-spin"></div>
    </div>
    <h3 class="text-lg font-semibold text-text mb-2">{{ $title }}</h3>
    <p class="text-text/60 text-center max-w-md">{{ $subtitle }}</p>
</div>