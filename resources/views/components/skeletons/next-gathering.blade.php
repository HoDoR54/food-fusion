{{-- Next gathering display skeleton --}}
<div {{ $attributes->merge(['class' => 'flex items-center w-[80vw] min-h-[40vh] justify-center bg-secondary/10 rounded-xl border-primary/30 border-3 border-dashed']) }}>
    <div class="flex flex-col gap-3 p-4 items-center justify-center">
        <div class="w-32 h-8 bg-primary/30 rounded mb-2 skeleton-wave"></div>
        <div class="flex flex-col items-center gap-2">
            <div class="w-48 h-6 bg-text/20 rounded skeleton-wave"></div>
            <div class="w-24 h-4 bg-text/10 rounded skeleton-wave"></div>
        </div>
        <div class="flex flex-col items-center gap-1">
            <div class="w-40 h-4 bg-text/10 rounded skeleton-wave"></div>
            <div class="w-32 h-4 bg-text/10 rounded skeleton-wave"></div>
        </div>
        <div class="w-56 h-12 bg-text/10 rounded mt-2 skeleton-wave"></div>
        <div class="w-32 h-10 bg-primary/20 rounded mt-4 skeleton-wave"></div>
    </div>
</div>