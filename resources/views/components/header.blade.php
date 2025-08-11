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

<header class="bg-secondary/15 px-6 py-4 grid grid-cols-5 w-full border-b-2 border-dotted border-gray-900">
  <nav class="flex gap-5 justify-start w-full items-center col-span-2">
    @foreach ($pages as $name => $url)
        <a href="{{ url($url) }}" class="text-sm text-center text-primary hover:text-secondary transition duration-300 ease-in-out hover:underline">
            {{ $name }}
        </a>
    @endforeach
  </nav>

  <div class="flex items-center justify-center cursor-pointer flex-1" onclick="window.location.href='{{ url('/') }}'">
    <img src="{{ asset('logo/logo-light.png') }}" alt="Food Fusion Logo" class="h-8 w-auto">
    <span class="text-[1.2rem] text-primary ml-2 font-[lobster]">FoodFusion</span>
  </div>

  <div class="flex items-center justify-end gap-5 col-span-2">
    <div class="flex items-center justify-center border-r pr-5 border-primary gap-3 h-full">
      @if ($user)
        <a href="{{ route('me') }}" class="flex items-center justify-center gap-3 group">
          <span class="cursor-pointer font-medium text-sm group-hover:text-secondary text-primary transition duration-300 ease-in-out group-hover:underline">
            {{ $user->name ?? 'Guest' }}
          </span>
          <img src="{{ $user->profilePicUrl ?? asset('images/default-profile.webp') }}" alt="Profile Picture" class="h-8 w-8 rounded-full cursor-pointer border-2 border-primary/50 border-dotted">
        </a>
      @else
        @foreach ($authPages as $name => $url)
          <a href="{{ url($url) }}" class="text-sm text-center text-primary hover:text-secondary transition duration-300 ease-in-out hover:underline">
            {{ $name }}
          </a>
        @endforeach
      @endif
    </div>
    <x-button :variant="ButtonVariant::Primary" :size="ButtonSize::Small" :icon="'<i class=\'fa-solid fa-cloud-arrow-up\'></i>'" :text="'Share Your Recipe'" onclick="window.location.href='{{ url('cookbook/new-post') }}'"></x-button>
  </div>
</header>