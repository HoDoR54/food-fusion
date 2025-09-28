@php
    use App\Enums\ButtonSize;
    use App\Enums\ButtonVariant;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;

    $pages = [
        'About Us' => ['route' => 'about', 'icon' => 'info'],
        'Contact' => ['route' => 'contact.index', 'icon' => 'mail'],
        'Recipes' => ['route' => 'recipes.index', 'icon' => 'chef-hat'],
        'Community Cookbook' => ['route' => 'blogs.index', 'icon' => 'book-open'],
        'Resources' => ['route' => 'resources.index', 'icon' => 'library'],
  ];

    $authPages = [
        'Login' => '/login',
        'Register' => '/register',
    ];

    $user = Auth::user();
    $isAdmin = $user && $user->isAdmin();
@endphp

<header class="bg-primary px-4 sm:px-6 py-3 w-full border-b border-white/20">
  <div class="flex items-center justify-between lg:hidden">
    <div class="flex items-center cursor-pointer" onclick="window.location.href='{{ route('home') }}'">
      <img src="{{ asset('logo/logo-dark.png') }}" alt="Food Fusion Logo" class="h-8 w-auto">
      <span class="text-lg text-white ml-2 font-[lobster]">FoodFusion</span>
    </div>
    
    <button onclick="toggleMobileMenu()" class="text-white p-2">
      <i data-lucide="menu" class="w-6 h-6" id="menu-icon"></i>
    </button>
  </div>

  <div class="hidden lg:grid lg:grid-cols-5 w-full">
    <nav class="flex gap-5 justify-start w-full items-center col-span-2">
      @foreach ($pages as $name => $page)
          <a href="{{ route($page['route']) }}" class="flex lg:flex-col items-center gap-1 text-xs text-center text-white hover:text-secondary transition duration-300 ease-in-out hover:underline whitespace-nowrap">
              <i data-lucide="{{ $page['icon'] }}" class="w-4 h-4"></i>
              {{ $name }}
          </a>
      @endforeach
    </nav>

    <div class="flex items-center justify-center cursor-pointer flex-1" onclick="window.location.href='{{ route('home') }}'">
      <img src="{{ asset('logo/logo-dark.png') }}" alt="Food Fusion Logo" class="h-10 w-auto">
      <span class="text-[1.4rem] text-white ml-2 font-[lobster]">FoodFusion</span>
    </div>

    <div class="flex items-center justify-end gap-3 col-span-2">
      <div class="flex items-center justify-center border-r pr-3 border-white/20 gap-2 lg:gap-3 h-full">
        @if ($user)
            <div class="relative group flex items-center justify-center gap-2 lg:gap-3">
                <a href="{{ route('users.show', ['username' => $user->getUsername()]) }}" class="flex items-center gap-2 lg:gap-3">
                    <span class="cursor-pointer font-medium text-xs lg:text-sm group-hover:text-secondary text-white transition duration-300 ease-in-out group-hover:underline hidden sm:block">
                        {{ $user->name ?? 'Guest' }}
                    </span>
                    <img src="{{ $user->profilePicUrl ?? asset('images/default-profile.webp') }}" 
                        alt="Profile Picture" 
                        class="h-6 w-6 lg:h-8 lg:w-8 rounded-full cursor-pointer border-2 border-white/20">
                </a>

                <ul class="absolute top-[70%] right-0 lg:left-0 mt-2 hidden z-30 group-hover:block bg-background rounded shadow border border-text/20 min-w-40">
                    <li class="hover:bg-primary/10">
                        <a href="{{ route('users.show', ['username' => $user->getUsername()]) }}"
                          class="flex gap-2 px-4 py-2 items-center text-sm text-text hover:text-primary hover:underline transition">
                          <i data-lucide="bookmark-check" class="w-4 h-4"></i>  
                          Saved Items
                        </a>
                    </li>
                    <li class="hover:bg-primary/10">
                        <a href="{{ route('users.show', ['username' => $user->getUsername()]) }}"
                          class="flex gap-2 px-4 py-2 items-center text-sm text-text hover:text-primary hover:underline transition">
                          <i data-lucide="bell" class="w-4 h-4"></i>  
                          Notifications
                        </a>
                    </li>
                    <li class="hover:bg-primary/10">
                        <a href="{{ route('users.show', ['username' => $user->getUsername()]) }}"
                          class="flex gap-2 px-4 py-2 items-center text-sm text-text hover:text-primary hover:underline transition">
                          <i data-lucide="log-out" class="w-4 h-4"></i>  
                          Log Out
                        </a>
                    </li>

                    @if ($isAdmin)
                        <li class="hover:bg-primary/10">
                            <a href="{{ route('admin.index') }}"
                              class="flex gap-2 px-4 py-2 items-center text-sm text-text hover:text-primary hover:underline transition">
                              <i data-lucide="shield" class="w-4 h-4"></i>  
                               Dashboard
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        @else
          <div class="flex items-center gap-2 lg:gap-3">
            <a 
              type="button" 
              href="{{ route('auth.login.show') }}"
              class="text-xs lg:text-sm text-center text-white hover:text-secondary transition duration-300 ease-in-out hover:underline bg-transparent border-none cursor-pointer"
            >
              Login
            </a>
            <a 
              type="button" 
              href="{{ route('auth.register.show') }}"
              class="text-xs lg:text-sm text-center text-white hover:text-secondary transition duration-300 ease-in-out hover:underline bg-transparent border-none cursor-pointer"
            >
              Register
            </a>
          </div>
        @endif
      </div>
      <a href="{{ route('recipes.create.show') }}">
          <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Small" :icon="'<i class=\'fa-solid fa-cloud-arrow-up\'></i>'" :text="'Share Your Recipe'"></x-button>
      </a>
    </div>
  </div>

  <div id="mobile-menu" class="lg:hidden bg-primary border-t border-white/20">
    <div class="px-4 py-4">
      <nav class="flex flex-col gap-3">
        @foreach ($pages as $name => $page)
            <a href="{{ route($page['route']) }}" class="flex items-center gap-3 text-sm text-white hover:text-secondary transition duration-300 ease-in-out hover:underline py-2 border-b border-white/10 pb-2">
                <i data-lucide="{{ $page['icon'] }}" class="w-4 h-4"></i>
                {{ $name }}
            </a>
        @endforeach
        
          @if ($user)
            <a href="{{ route('users.show', ['username' => $user->getUsername()]) }}" 
               class="flex items-center gap-3 text-sm text-white hover:text-secondary transition duration-300 ease-in-out hover:underline py-2 mb-4 border-t border-white/20 pt-3">
                <img src="{{ $user->profilePicUrl ?? asset('images/default-profile.webp') }}" 
                     alt="Profile Picture" 
                     class="h-6 w-6 rounded-full border-2 border-white/20">
                {{ $user->name ?? 'Guest' }}
            </a>
          @else
              <a href="{{ route('auth.login.show') }}"
                class="text-sm text-white hover:text-secondary transition duration-300 ease-in-out hover:underline py-2">
                Login
              </a>
              <a href="{{ route('auth.register.show') }}"
                class="text-sm text-white hover:text-secondary transition duration-300 ease-in-out hover:underline py-2">
                Register
              </a>
          @endif
          
          <div class="pt-2">
            <a href="{{ route('recipes.create.show') }}" class="block">
                <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Small" :icon="'<i class=\'fa-solid fa-cloud-arrow-up\'></i>'" :text="'Share Your Recipe'" class="w-full justify-center"></x-button>
            </a>
          </div>
      </nav>
    </div>
  </div>
</header>