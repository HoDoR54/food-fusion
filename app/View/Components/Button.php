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
    public string $text;
    public ButtonSize $size;

    public function __construct(ButtonVariant $variant = ButtonVariant::Primary, string $text = 'Click me!', ButtonSize $size = ButtonSize::Medium)
    {
        $this->variant = $variant;
        $this->text = $text;
        $this->size = $size;
    }

    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
