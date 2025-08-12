@php
    use App\Enums\ButtonSize;
    use App\Enums\ButtonVariant;
@endphp

<form class="flex items-center gap-3 md:min-w-[600px]" action="{{ route('recipes.index', ['search_term' => '']) }}" method="GET">
    <input type="text" name="search_term" required placeholder="Search recipes..." class="bg-secondary/15 border border-gray-300 px-4 py-2 focus:outline-2 focus:outline-primary rounded w-full" />
    <x-button
        type="submit"
        class="w-auto"
        :text="'Search'"
        :variant="ButtonVariant::Primary"
        :size="ButtonSize::Medium"
    />
</form>
