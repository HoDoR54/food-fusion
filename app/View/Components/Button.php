<?php

namespace App\View\Components;

use App\Enums\ButtonVariant;
use App\Enums\ButtonSize;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public ButtonVariant $variant;
    public string|null $text;
    public ButtonSize $size;
    public string|null $icon;

    public function __construct(string|null $icon = null, ButtonVariant $variant = ButtonVariant::Primary, string|null $text = null, ButtonSize $size = ButtonSize::Medium)
    {
        $this->variant = $variant;
        $this->text = $text;
        $this->size = $size;
        $this->icon = $icon;
    }

    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
