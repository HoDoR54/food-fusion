@php
    use App\Enums\ButtonSize;
    use App\Enums\ButtonVariant;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;

    $pages = [
        'About Us' => 'about',
        'Contact' => 'contact.index',
        'Events' => 'events.index',
        'Recipes' => 'recipes.index',
        'Community Cookbook' => 'blogs.index',
  ];

    $authPages = [
        'Login' => '/login',
        'Register' => '/register',
    ];

    $user = Auth::user();
    $isAdmin = $user && $user->isAdmin();
@endphp

<header class="bg-primary/80 px-6 py-4 grid grid-cols-5 w-full border-b-2 border-dashed border-background">
  <nav class="flex gap-5 justify-start w-full items-center col-span-2">
    @foreach ($pages as $name => $url)
        <a href="{{ route($url) }}" class="text-sm text-center text-white hover:text-secondary transition duration-300 ease-in-out hover:underline">
            {{ $name }}
        </a>
    @endforeach
  </nav>

  <div class="flex items-center justify-center cursor-pointer flex-1" onclick="window.location.href='{{ route('home') }}'">
  <img src="{{ asset('logo/logo-dark.png') }}" alt="Food Fusion Logo" class="h-10 w-auto">
    <span class="text-[1.4rem] text-white ml-2 font-[lobster]">FoodFusion</span>
  </div>

  <div class="flex items-center justify-end gap-5 col-span-2">
    <div class="flex items-center justify-center border-r pr-5 border-white gap-3 h-full">
      @if ($user)
          <div class="relative group flex items-center justify-center gap-3">
              <a href="{{ route('users.show', ['username' => $user->getUsername()]) }}" class="flex items-center gap-3">
                  <span class="cursor-pointer font-medium text-sm group-hover:text-secondary text-white transition duration-300 ease-in-out group-hover:underline">
                      {{ $user->name ?? 'Guest' }}
                  </span>
                  <img src="{{ $user->profilePicUrl ?? asset('images/default-profile.webp') }}" 
                      alt="Profile Picture" 
                      class="h-8 w-8 rounded-full cursor-pointer border-2 border-background border-dashed">
              </a>

              <ul class="absolute top-[70%] left-0 mt-2 hidden z-30 group-hover:block bg-background rounded shadow">
                  <li class="hover:bg-primary/10">
                      <a href="{{ route('users.show', ['username' => $user->getUsername()]) }}"
                        class="flex gap-2 px-4 py-2 items-center justify-center text-sm text-text hover:text-text/90 hover:underline transition">
                        <i data-lucide="bookmark-check" class="w-4 h-4"></i>  
                        Saved Items
                      </a>
                  </li>
                  <li class="hover:bg-primary/10">
                      <a href="{{ route('users.show', ['username' => $user->getUsername()]) }}"
                        class="flex gap-2 px-4 py-2 items-center justify-center text-sm text-text hover:text-text/90 hover:underline transition">
                        <i data-lucide="bell" class="w-4 h-4"></i>  
                        Notifications
                      </a>
                  </li>
                  <li class="hover:bg-primary/10">
                      <a href="{{ route('users.show', ['username' => $user->getUsername()]) }}"
                        class="flex gap-2 px-4 py-2 items-center justify-center text-sm text-text hover:text-text/90 hover:underline transition">
                        <i data-lucide="log-out" class="w-4 h-4"></i>  
                        Log Out
                      </a>
                  </li>

                  @if ($isAdmin)
                      <li class="hover:bg-primary/10">
                          <a href="{{ route('admin.index') }}"
                            class="flex gap-2 px-4 py-2 items-center justify-center text-sm text-text hover:text-text/90 hover:underline transition">
                            <i data-lucide="shield" class="w-4 h-4"></i>  
                             Dashboard
                          </a>
                      </li>
                  @endif
              </ul>
          </div>
      @else
        <a 
          type="button" 
          href="{{ route('auth.login.show') }}"
          class="text-sm text-center text-white hover:text-secondary transition duration-300 ease-in-out hover:underline bg-transparent border-none cursor-pointer"
        >
          Login
        </a>
        <a 
          type="button" 
          href="{{ route('auth.register.show') }}"
          class="text-sm text-center text-white hover:text-secondary transition duration-300 ease-in-out hover:underline bg-transparent border-none cursor-pointer"
        >
          Register
        </a>
      @endif
    </div>
    <a href="{{ route('recipes.create.show') }}">
        <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Small" :icon="'<i class=\'fa-solid fa-cloud-arrow-up\'></i>'" :text="'Share Your Recipe'"></x-button>
    </a>
  </div>
</header>