@php
    use App\Enums\ButtonSize;
    use App\Enums\ButtonVariant;
    use Illuminate\Support\Facades\Auth;

    $pages = [
        'About Us' => '/about',
        'Contact' => '/contact',
        'Educational Resources' => '/educational-resources',
        'Recipes' => '/recipes',
        'Cookbook' => '/cookbook',
  ];

    $authPages = [
        'Login' => '/login',
        'Register' => '/register',
    ];

    $user = Auth::user();
@endphp

<header class="bg-secondary/20 px-6 py-4 grid grid-cols-5 w-full border-b border-dotted border-gray-900">
  <nav class="flex gap-5 justify-start w-full items-center col-span-2">
    @foreach ($pages as $name => $url)
        <a href="{{ url($url) }}" class="text-sm text-center text-primary hover:text-secondary transition duration-300 ease-in-out hover:underline">
            {{ $name }}
        </a>
    @endforeach
  </nav>

  <div class="flex items-center justify-center cursor-pointer flex-1" onclick="window.location.href='{{ url('/') }}'">
    <img src="{{ asset('logo/logo-light.png') }}" alt="Food Fusion Logo" class="h-12 w-auto">
    <span class="text-[2rem] text-primary ml-2 font-[lobster]">FoodFusion</span>
  </div>

  <div class="flex items-center justify-end gap-5 col-span-2">
    @foreach ($authPages as $name => $url)
        <a href="{{ url($url) }}" class="text-sm text-center text-primary hover:text-secondary transition duration-300 ease-in-out hover:underline">
            {{ $name }}
        </a>
    @endforeach
    <div class="h-full flex items-center justify-center border-r pr-5 text-primary hover:text-secondary text-sm border-primary">
      <a href="{{ route('me') }}" class="cursor-pointer">{{ $user->name ?? 'Guest' }}</a>
    </div>
    <x-button :variant="ButtonVariant::Primary" :size="ButtonSize::Small" :icon="'fa-solid fa-cloud-arrow-up'" :text="'Share Your Recipe'" onclick="window.location.href='{{ url('cookbook/new-post') }}'"></x-button>
  </div>
</header>