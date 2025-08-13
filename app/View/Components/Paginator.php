<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Reusable Paginator Component
 * 
 * Usage examples:
 * 
 * Basic usage:
 * <x-paginator :current-page="1" :total-pages="10" :total-items="100" :has-prev="false" :has-next="true" />
 * 
 * With custom URL and preserved parameters:
 * <x-paginator 
 *     :current-page="$page" 
 *     :total-pages="$totalPages" 
 *     :total-items="$totalItems" 
 *     :has-prev="$hasPrev" 
 *     :has-next="$hasNext"
 *     :base-url="route('custom.route')"
 *     :preserve-params="['search', 'filter', 'sort']"
 *     :max-buttons="7"
 *     page-name="p"
 * />
 */
class Paginator extends Component
{
    public int $currentPage;
    public int $totalPages;
    public int $totalItems;
    public bool $hasPrev;
    public bool $hasNext;
    public string $baseUrl;
    public array $preserveParams;
    public int $maxButtons;
    public string $pageName;

    public function __construct(
        int $currentPage, 
        int $totalPages, 
        int $totalItems, 
        bool $hasPrev, 
        bool $hasNext,
        string $baseUrl = null,
        array $preserveParams = [],
        int $maxButtons = 3,
        string $pageName = 'page'
    ) {
        $this->currentPage = $currentPage;
        $this->totalPages = $totalPages;
        $this->totalItems = $totalItems;
        $this->hasPrev = $hasPrev;
        $this->hasNext = $hasNext;
        $this->baseUrl = $baseUrl ?? request()->url();
        $this->preserveParams = $preserveParams;
        $this->maxButtons = $maxButtons;
        $this->pageName = $pageName;
    }

    public function buildUrl(int $page): string
    {
        $currentParams = request()->query();
        $filteredParams = [];
        
        foreach ($this->preserveParams as $paramName) {
            if (isset($currentParams[$paramName]) && $currentParams[$paramName] !== null && $currentParams[$paramName] !== '') {
                $filteredParams[$paramName] = $currentParams[$paramName];
            }
        }
        
        $filteredParams[$this->pageName] = $page;
        
        return $this->baseUrl . '?' . http_build_query($filteredParams);
    }
    

    public function render(): View|Closure|string
    {
        return view('components.paginator');
    }
}
