{{-- Generic skeleton card component --}}
@props(['height' => 'h-80'])

<div {{ $attributes->merge(['class' => "bg-white/60 border-2 border-dashed border-primary/20 rounded-lg p-6 $height flex flex-col justify-between"]) }}>
    <div>
        <div class="w-16 h-4 bg-primary/20 rounded mb-3 skeleton-wave"></div>
        <div class="w-full h-6 bg-text/20 rounded mb-3 skeleton-wave"></div>
        <div class="w-3/4 h-4 bg-text/10 rounded mb-4 skeleton-wave"></div>
        <div class="w-full h-20 bg-text/10 rounded skeleton-wave"></div>
    </div>
    <div class="flex justify-between items-center mt-4">
        <div class="w-20 h-4 bg-secondary/30 rounded skeleton-wave"></div>
        <div class="w-24 h-8 bg-primary/20 rounded skeleton-wave"></div>
    </div>
</div>