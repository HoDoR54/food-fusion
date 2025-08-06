@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;

    $primaryStyle = 'bg-primary text-white';
    $secondaryStyle = 'bg-secondary text-white';

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

<button class="{{ $styleClass }} {{ $sizeClass }} rounded transition duration-300 ease-in-out cursor-pointer hover:brightness-90">
    {{ $text }}
</button>
