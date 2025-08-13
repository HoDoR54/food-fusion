@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;

    $maxButtons = 3;
    $halfButtons = floor($maxButtons / 2);

    if ($totalPages <= $maxButtons) {
        $startPage = 1;
        $endPage = $totalPages;
    } else {
        if ($currentPage <= $halfButtons + 1) {
            $startPage = 1;
            $endPage = $maxButtons;
        } elseif ($currentPage >= $totalPages - $halfButtons) {
            $startPage = $totalPages - $maxButtons + 1;
            $endPage = $totalPages;
        } else {
            $startPage = $currentPage - $halfButtons;
            $endPage = $currentPage + $halfButtons;
        }
    }

    $showStartEllipsis = $startPage > 1;
    $showEndEllipsis = $endPage < $totalPages;
@endphp

<div class="w-full flex items-center justify-center gap-5">
    {{-- Prev --}}
    <x-button 
        :variant="ButtonVariant::Primary"
        :size="ButtonSize::Small"
        :icon="'<i data-lucide=\'chevron-left\'></i>'"
        id="prev-button"
        class="{{ !$hasPrev ? 'opacity-50 pointer-events-none' : '' }}"
        :disabled="!$hasPrev"
    />

    <ul class="flex items-center gap-2">
        {{-- First --}}
        @if($showStartEllipsis)
            <li>
                <x-button 
                    :variant="ButtonVariant::Secondary"
                    :size="ButtonSize::Small"
                    :text="1"
                    class="{{ $currentPage === 1 ? '!bg-secondary/70 !text-white' : '' }}"
                    data-page="1"
                />
            </li>
            <li><span class="px-2 py-1 text-gray-500">...</span></li>
        @endif

        {{-- Range --}}
        @foreach (range($startPage, $endPage) as $x)
            <li>
                <x-button 
                    :variant="ButtonVariant::Secondary"
                    :size="ButtonSize::Small"
                    :text="$x"
                    class="{{ floor($x) == $currentPage ? '!bg-secondary/70 !text-white' : '' }}"
                    data-page="{{ $x }}"
                />
            </li>
        @endforeach


        {{-- Last --}}
        @if($showEndEllipsis)
            <li><span class="px-2 py-1 text-gray-500">...</span></li>
            <li>
                <x-button 
                    :variant="ButtonVariant::Secondary"
                    :size="ButtonSize::Small"
                    :text="$totalPages"
                    class="{{ $currentPage === $totalPages ? '!bg-secondary/70 !text-white' : '' }}"
                    data-page="{{ $totalPages }}"
                />
            </li>
        @endif
    </ul>

    {{-- Next --}}
    <x-button 
        :variant="ButtonVariant::Primary"
        :size="ButtonSize::Small"
        :icon="'<i data-lucide=\'chevron-right\'></i>'"
        id="next-button"
        class="{{ !$hasNext ? 'opacity-50 pointer-events-none' : '' }}"
        data-total-pages="{{ $totalPages }}"
        :disabled="!$hasNext"
    />
</div>
