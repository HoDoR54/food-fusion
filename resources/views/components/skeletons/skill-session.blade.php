{{-- Skill sharing session skeleton --}}
<div {{ $attributes->merge(['class' => 'bg-secondary/10 border-2 border-dashed border-primary/10 rounded-lg p-5 flex flex-col justify-between h-full']) }}>
    <div>
        <div class="w-3/4 h-6 bg-text/20 rounded mb-2 skeleton-wave"></div>
        <div class="w-full h-4 bg-text/10 rounded mb-1 skeleton-wave"></div>
        <div class="w-5/6 h-4 bg-text/10 rounded skeleton-wave"></div>
    </div>
    <div class="mt-4 space-y-2">
        <div class="w-1/2 h-4 bg-secondary/30 rounded skeleton-wave"></div>
        <div class="w-2/3 h-4 bg-secondary/30 rounded skeleton-wave"></div>
    </div>
</div>