@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;

    $primaryStyle = 'bg-primary text-white border border-primary';
    $secondaryStyle = 'text-text bg-background border border-primary border-dotted';

    $sizeSm = 'px-3 py-1 text-sm';
    $sizeMd = 'px-4 py-2 text-md';
    $sizeLg = 'px-5 py-3 text-lg';

    $sizeClass = match ($size->value ?? ButtonSize::Medium->value) {
        ButtonSize::Small->value => $sizeSm,
        ButtonSize::Large->value => $sizeLg,
        default => $sizeMd,
    };

    $styleClass = ($variant ?? ButtonVariant::Primary) === ButtonVariant::Primary
        ? $primaryStyle
        : $secondaryStyle;
@endphp

<button {{ $attributes->merge(['class' => "$styleClass $sizeClass shadow hover:brightness-90 rounded transition duration-300 ease-in-out box-border cursor-pointer"]) }}>
    {{ $text }}
</button>
