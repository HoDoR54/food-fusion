<nav aria-label="breadcrumb" class="w-full flex p-5">
    <ol class="flex text-sm text-gray-600 items-center gap-3">
        @foreach ($items as $item)
            @if (!$loop->last)
                <li class="flex items-center gap-2">
                    <a href="{{ $item['url'] }}" class="hover:underline hover:text-gray-800">{{ $item['label'] }}</a>
                    <span>></span>
                </li>
            @else
                <li class="text-gray-800">{{ $item['label'] }}</li>
            @endif
        @endforeach
    </ol>
</nav>
