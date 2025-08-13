@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;

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

<div class="w-full flex items-center justify-center gap-5" 
     data-paginator="true" 
     data-total-pages="{{ $totalPages }}"
     data-current-page="{{ $currentPage }}"
     data-page-name="{{ $pageName }}"
     data-preserve-params="{{ implode(',', $preserveParams) }}">
    {{-- Prev --}}
    <a href="{{ $hasPrev ? $buildUrl($currentPage - 1) : '#' }}"
       class="{{ !$hasPrev ? 'pointer-events-none opacity-50' : '' }}">
        <x-button 
            :variant="ButtonVariant::Primary"
            :size="ButtonSize::Small"
            :icon="'<i data-lucide=\'chevron-left\'></i>'"
            class="paginator-prev"
            :disabled="!$hasPrev"
        />
    </a>

    <ul class="flex items-center gap-2">
        {{-- First --}}
        @if($showStartEllipsis)
            <li>
                <a href="{{ $buildUrl(1) }}">
                    <x-button 
                        :variant="ButtonVariant::Secondary"
                        :size="ButtonSize::Small"
                        :text="1"
                        class="{{ $currentPage === 1 ? '!bg-secondary/70 !text-white' : '' }}"
                    />
                </a>
            </li>
            <li><span class="px-2 py-1 text-gray-500">...</span></li>
        @endif

        {{-- Range --}}
        @foreach (range($startPage, $endPage) as $x)
            <li>
                <a href="{{ $buildUrl($x) }}">
                    <x-button 
                        :variant="ButtonVariant::Secondary"
                        :size="ButtonSize::Small"
                        :text="$x"
                        class="{{ intval($x) == $currentPage ? '!bg-secondary/70 !text-white' : '' }}"
                    />
                </a>
            </li>
        @endforeach

        {{-- Last --}}
        @if($showEndEllipsis)
            <li><span class="px-2 py-1 text-gray-500">...</span></li>
            <li>
                <a href="{{ $buildUrl($totalPages) }}">
                    <x-button 
                        :variant="ButtonVariant::Secondary"
                        :size="ButtonSize::Small"
                        :text="$totalPages"
                        class="{{ $currentPage === $totalPages ? '!bg-secondary/70 !text-white' : '' }}"
                    />
                </a>
            </li>
        @endif
    </ul>

    {{-- Next --}}
    <a href="{{ $hasNext ? $buildUrl($currentPage + 1) : '#' }}"
       class="{{ !$hasNext ? 'pointer-events-none opacity-50' : '' }}">
        <x-button 
            :variant="ButtonVariant::Primary"
            :size="ButtonSize::Small"
            :icon="'<i data-lucide=\'chevron-right\'></i>'"
            class="paginator-next"
            :disabled="!$hasNext"
        />
    </a>
</div>
