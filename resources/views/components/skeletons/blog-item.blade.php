{{-- Blog list item skeleton --}}
<div {{ $attributes->merge(['class' => 'border-l-8 border-dashed border-primary/10 pl-6 pr-4 py-4 bg-white/40 rounded-r-lg']) }}>
    <div class="flex justify-between items-center w-full">
        <div class="flex items-center gap-4 w-full">
            <div class="w-16 h-16 rounded-full bg-primary/20 skeleton-pulse"></div>
            <div class="flex-1">
                <div class="w-3/4 h-6 bg-text/20 rounded mb-2 skeleton-wave"></div>
                <div class="w-1/2 h-4 bg-primary/10 rounded mb-2 skeleton-wave"></div>
                <div class="w-1/3 h-4 bg-text/10 rounded skeleton-wave"></div>
            </div>
        </div>
        <div class="text-right">
            <div class="w-16 h-5 bg-primary/20 rounded skeleton-wave"></div>
        </div>
    </div>
</div>