<?php

namespace App\View\Components;

use App\Enums\ButtonSize;
use App\Enums\ButtonVariant;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public ButtonVariant $variant;

    public ?string $text;

    public ButtonSize $size;

    public ?string $icon;

    public function __construct(?string $icon = null, ButtonVariant $variant = ButtonVariant::Primary, ?string $text = null, ButtonSize $size = ButtonSize::Medium)
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
