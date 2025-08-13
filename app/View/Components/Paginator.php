<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Paginator extends Component
{
    public int $currentPage;
    public int $totalPages;
    public int $totalItems;
    public bool $hasPrev;
    public bool $hasNext;

    public function __construct(int $currentPage, int $totalPages, int $totalItems, bool $hasPrev, bool $hasNext)
    {
        $this->currentPage = $currentPage;
        $this->totalPages = $totalPages;
        $this->totalItems = $totalItems;
        $this->hasPrev = $hasPrev;
        $this->hasNext = $hasNext;
    }
    

    public function render(): View|Closure|string
    {
        return view('components.paginator');
    }
}
