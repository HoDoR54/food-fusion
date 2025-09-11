@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;
    use App\Enums\ButtonSize;
    use App\Enums\ButtonVariant;

    $currentUser = Auth::user();
    $displayUser = $profileUser ?? $currentUser;
    if ($currentUser && $displayUser && $displayUser->name === $currentUser->name) {
        $isOwnProfile = true;
    } else {
        $isOwnProfile = false;
    }

    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => ($isOwnProfile ? 'Profile' : ($displayUser?->name ?? 'User') . "'s Profile"), 'url' => '/profile'],
    ];
@endphp

@extends('layout.index')
@section('title', 'Food Fusion - ' . ($displayUser?->name ?? 'Profile'))

@section('content')
<section class="flex flex-col w-full pb-10 p-5">
    <section class="w-full grid md:grid-cols-4">
        <div class="h-screen p-5 flex flex-col items-center">
            {{-- TO-DO: Image Upload and Edit Profile --}}
            <div class="flex items-center justify-center">
                <div class="relative border-dashed mt-10">
                    <img src="{{ $displayUser?->profilePicUrl ?? asset('images/default-profile.webp') }}" 
                         alt="Profile Picture" 
                         class="h-32 w-32 object-cover rounded-full border-4 border-dashed border-primary/30">
                    @if ($isOwnProfile)
                        <div class="absolute bottom-0 right-0 bg-primary p-2 rounded-full cursor-pointer hover:bg-primary/80 transition">
                            <i data-lucide="camera" class="w-5 h-5 text-white"></i>
                        </div>
                    @endif
                </div>
            </div>
            <div class="mt-5 flex flex-col text-center items-center">
                <h2 class="text-primary text-2xl font-semibold relative">
                    {{ $displayUser?->name ?? 'Unknown User' }}
                </h2>
                {{-- TO-DO: Followers and Following Count --}}
                <p class="text-text/80 text-sm mt-1">
                    0 Followers &bull; 0 Following
                </p>
                <p class="text-text/70 text-sm mt-1">
                    Joined on {{ $displayUser?->created_at?->format('F j, Y') ?? 'Unknown' }}
                </p>
            </div>
            <div class="mt-5 w-full flex flex-col gap-3">
                <div class="w-full py-3 pl-5 cursor-pointer bg-secondary/10 relative hover:bg-primary/10 transition rounded-2xl border-b border-dashed border-text/30">
                    @if ($isOwnProfile)
                        Your Recipes
                    @else
                        Recipes
                    @endif
                    <div class="absolute top-1/2 right-5 -translate-y-1/2 flex items-center gap-3">
                        <span class="text-sm text-text/70">0</span>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-text/70"></i>
                    </div>
                </div>
                <div class="w-full py-3 pl-5 cursor-pointer bg-secondary/10 relative hover:bg-primary/10 transition rounded-2xl border-b border-dashed border-text/30">
                    @if ($isOwnProfile)
                        Your Blogs
                    @else
                        Blogs
                    @endif
                    <div class="absolute top-1/2 right-5 -translate-y-1/2 flex items-center gap-3">
                        <span class="text-sm text-text/70">0</span>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-text/70"></i>
                    </div>
                </div>
                @if($isOwnProfile) 
                    <div class="w-full py-3 pl-5 cursor-pointer bg-secondary/10 relative hover:bg-primary/10 transition rounded-2xl border-b border-dashed border-text/30">
                        Saved Items
                        <div class="absolute top-1/2 right-5 -translate-y-1/2 flex items-center gap-3">
                            <span class="text-sm text-text/70">0</span>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-text/70"></i>
                        </div>
                    </div>
                @endif
                <div class="w-full py-3 pl-5 cursor-pointer bg-secondary/10 relative hover:bg-primary/10 transition rounded-2xl border-b border-dashed border-text/30">
                    Events Participated
                    <div class="absolute top-1/2 right-5 -translate-y-1/2 flex items-center gap-3">
                        <span class="text-sm text-text/70">0</span>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-text/70"></i>
                    </div>
                </div>
                @if ($isOwnProfile)
                    <x-button 
                    :size="ButtonSize::Small" 
                    :variant="ButtonVariant::Secondary"
                    :text="'Log Out'"
                    :icon="'<i data-lucide=\'log-out\'></i>'" 
                    class="w-full py-3 rounded-2xl"/>
                @endif
            </div>
        </div>
        <div class="h-screen md:col-span-3 p-5 overflow-y-auto no-scroll">
            <div class="animate-on-scroll w-full bg-primary/10 rounded-2xl border border-primary/20 border-dashed p-6 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-800">Recent Activity</h3>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 text-sm cursor-pointer bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">All</button>
                        <button class="px-4 py-2 text-sm cursor-pointer text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition">Recipes</button>
                        <button class="px-4 py-2 text-sm cursor-pointer text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition">Blogs</button>
                    </div>
                </div>
                
                <div class="space-y-4">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="flex gap-4 p-4 bg-gray-50/50 rounded-xl border border-gray-100/50">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gray-300 rounded-xl flex items-center justify-center">
                                    <i data-lucide="chef-hat" class="w-6 h-6 text-gray-600"></i>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <p class="text-text font-medium">Placeholder</p>
                                <p class="text-text/60 text-sm mt-1">Placeholder</p>
                                <div class="flex gap-2 mt-2">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-lg">Placeholder</span>
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-lg">Placeholder</span>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <button cursor-pointer class="cursor-pointer w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                                    <i data-lucide="heart" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    @endfor
                </div>

                <div class="text-center mt-6">
                    <button class="cursor-pointer px-6 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition text-sm font-medium">
                        Load more activities
                    </button>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-4 mb-6">
                <div class="animate-on-scroll bg-primary/10 border border-primary/20 border-dashed rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-50/50 rounded-lg flex items-center justify-center">
                            <i data-lucide="chef-hat" class="w-5 h-5 text-gray-600"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-700">12</p>
                            <p class="text-text/60 text-sm">Recipes</p>
                        </div>
                    </div>
                </div>
                <div style="animation-delay: 0.1s;"  class="animate-on-scroll bg-primary/10 border border-primary/20 border-dashed rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-50/50 rounded-lg flex items-center justify-center">
                            <i data-lucide="edit-3" class="w-5 h-5 text-gray-600"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-700">8</p>
                            <p class="text-text/60 text-sm">Blog Posts</p>
                        </div>
                    </div>
                </div>
                <div style="animation-delay: 0.2s;"  class="animate-on-scroll bg-primary/10 border border-primary/20 border-dashed rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-50/50 rounded-lg flex items-center justify-center">
                            <i data-lucide="calendar-check" class="w-5 h-5 text-gray-600"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-700">5</p>
                            <p class="text-text/60 text-sm">Events</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="animate-on-scroll w-full bg-primary/10 rounded-2xl shadow-sm border border-primary/20 border-dashed p-6 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-800">Popular Content</h3>
                    <button class="text-sm text-gray-600 hover:text-gray-800 transition">View all</button>
                </div>
                
                <div class="grid md:grid-cols-2 gap-4">
                    @for ($i = 0; $i < 2; $i++)
                        <div
                            class="bg-gray-50/50 cursor-pointer rounded-xl p-4 border border-gray-100/50 hover:shadow-md transition">
                            <div class="flex gap-3">
                                <div class="w-16 h-16 bg-gray-300 rounded-lg flex items-center justify-center">
                                    <i data-lucide="chef-hat" class="w-8 h-8 text-gray-600"></i>
                                </div>
                                <div class="flex-grow">
                                    <h4 class="font-semibold text-text mb-1">Placeholder</h4>
                                    <p class="text-text/60 text-sm mb-2">Placeholder</p>
                                    <div class="flex items-center gap-3 text-xs text-text/50">
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="heart" class="w-3 h-3"></i>
                                            24
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="message-circle" class="w-3 h-3"></i>
                                            8
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="bookmark" class="w-3 h-3"></i>
                                            12
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                    
                </div>
            </div>

            <div class="animate-on-scroll w-full bg-primary/10 rounded-2xl shadow-sm border border-primary/20 border-dashed p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-800">Achievements</h3>
                    <button class="text-sm text-gray-600 hover:text-gray-800 transition">View all</button>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="flex flex-col items-center p-4 bg-gray-50/50 rounded-xl border border-gray-100">
                            <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center mb-2">
                                <i data-lucide="trophy" class="w-6 h-6 text-gray-600"></i>
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 text-center">Placeholder</h4>
                            <p class="text-xs text-gray-500 text-center mt-1">Placeholder</p>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>
</section>
    
@endsection

