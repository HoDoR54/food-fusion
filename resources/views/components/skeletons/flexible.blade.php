{{-- Flexible skeleton component --}}
@props([
    'lines' => [75, 50, 100, 30], // Array of widths (percentages) for skeleton lines
    'height' => 'auto',
    'showImage' => false,
    'showButton' => false,
    'imageAspect' => 'aspect-video'
])

<div {{ $attributes->merge(['class' => "animate-pulse $height"]) }}>
    @if($showImage)
        <div class="{{ $imageAspect }} bg-secondary/10 rounded mb-4 flex items-center justify-center">
            <div class="w-16 h-16 bg-primary/20 rounded"></div>
        </div>
    @endif
    
    <div class="space-y-3">
        @foreach($lines as $index => $width)
            @php
                $heightClass = $index === 0 ? 'h-6' : ($index === 1 ? 'h-5' : 'h-4');
                $bgIntensity = $index === 0 ? 'bg-text/20' : 'bg-text/10';
            @endphp
            <div class="w-{{ $width }}% {{ $heightClass }} {{ $bgIntensity }} rounded"></div>
        @endforeach
    </div>
    
    @if($showButton)
        <div class="flex justify-between items-center mt-4">
            <div class="w-20 h-4 bg-secondary/30 rounded"></div>
            <div class="w-24 h-8 bg-primary/20 rounded"></div>
        </div>
    @endif
</div>