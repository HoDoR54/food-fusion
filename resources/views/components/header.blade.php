@php
    use App\Enums\ButtonSize;
    use App\Enums\ButtonVariant;

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
@endphp

<header class="bg-background px-6 py-4 flex items-center w-full border-b border-dotted border-gray-900">
  <nav class="flex gap-3 justify-start items-center flex-1">
    @foreach ($pages as $name => $url)
        <a href="{{ url($url) }}" class="text-sm text-center text-text hover:text-primary transition duration-300 ease-in-out hover:underline">
            {{ $name }}
        </a>
    @endforeach
  </nav>

  <div class="flex items-center justify-center cursor-pointer flex-1" onclick="window.location.href='{{ url('home') }}'">
    <img src="{{ asset('logo/logo-light.png') }}" alt="Food Fusion Logo" class="h-8 w-auto">
    <span class="text-lg text-primary ml-2">Food Fusion</span>
  </div>

  <div class="flex-1 flex items-center justify-end gap-3">
    @foreach ($authPages as $name => $url)
        <a href="{{ url($url) }}" class="text-sm text-center text-text hover:text-primary transition duration-300 ease-in-out hover:underline">
            {{ $name }}
        </a>
    @endforeach
  </div>
</header>
