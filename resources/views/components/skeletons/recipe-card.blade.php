{{-- Recipe card skeleton --}}
@props(['showImage' => true])

<div {{ $attributes->merge(['class' => 'bg-white/60 border-2 border-dashed border-primary/20 rounded-lg overflow-hidden']) }}>
    @if($showImage)
        <div class="aspect-video bg-secondary/10 flex items-center justify-center skeleton-wave">
            <div class="w-24 h-16 bg-primary/20 rounded skeleton-pulse"></div>
        </div>
    @endif
    <div class="p-4">
        <div class="w-3/4 h-6 bg-text/20 rounded mb-2 skeleton-wave"></div>
        <div class="w-1/2 h-4 bg-text/10 rounded mb-3 skeleton-wave"></div>
        <div class="flex justify-between items-center">
            <div class="w-16 h-4 bg-secondary/30 rounded skeleton-wave"></div>
            <div class="w-20 h-4 bg-primary/20 rounded skeleton-wave"></div>
        </div>
        <div class="flex gap-2 mt-3">
            <div class="w-12 h-5 bg-primary/10 rounded-full skeleton-wave"></div>
            <div class="w-16 h-5 bg-secondary/10 rounded-full skeleton-wave"></div>
        </div>
    </div>
</div>