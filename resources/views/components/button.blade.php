@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;

    $primaryStyle = 'bg-primary text-white border border-primary';
    $secondaryStyle = 'text-text bg-primary/20 border border-primary border-dotted';

    $sizeSm = 'text-sm';
    $sizeMd = 'text-base';
    $sizeLg = 'text-md';

    $sizeClass = match ($size->value ?? ButtonSize::Medium->value) {
        ButtonSize::Small->value => $sizeSm,
        ButtonSize::Large->value => $sizeLg,
        default => $sizeMd,
    };

    $styleClass = ($variant ?? ButtonVariant::Primary) === ButtonVariant::Primary
        ? $primaryStyle
        : $secondaryStyle;
@endphp

<button {{ $attributes->merge(['class' => "$styleClass $sizeClass px-3 py-2 flex items-center justify-center gap-3 hover:brightness-90 rounded transition duration-300 ease-in-out box-border cursor-pointer"]) }}>
    @if ($icon)
        <i class="{{ $icon }}"></i>
    @endif
    @if ($text)
        <span>{{ $text }}</span>
    @endif
</button>

