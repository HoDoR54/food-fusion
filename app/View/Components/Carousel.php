<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Carousel extends Component
{
    public string $title;
    public string|null $description;
    public array $items;
    public bool $showSeeAll;
    public string|null $seeAllUrl;
    public int $slidesVisible;
    public bool $autoPlay;
    public int $autoPlayInterval;

    public function __construct(
        string $title,
        array $items = [],
        string|null $description = null,
        bool $showSeeAll = true,
        string|null $seeAllUrl = null,
        int $slidesVisible = 5,
        bool $autoPlay = true,
        int $autoPlayInterval = 2000
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->items = $items;
        $this->showSeeAll = $showSeeAll;
        $this->seeAllUrl = $seeAllUrl;
        $this->slidesVisible = $slidesVisible;
        $this->autoPlay = $autoPlay;
        $this->autoPlayInterval = $autoPlayInterval;
    }

    public function render(): View|Closure|string
    {
        return view('components.carousel');
    }

    public function getIndicatorCount(): int
    {
        return max(1, count($this->items) - $this->slidesVisible + 1);
    }
}
