@php
    use App\Enums\ButtonSize;
    use App\Enums\ButtonVariant;
@endphp

<div class="flex flex-col shadow-md h-screen min-w-[300px] bg-white/30 p-4">
    <div class="font-bold text-lg mb-6 flex gap-2 items-center text-primary">
        <img src="{{ asset('logo/logo-light.png') }}" class="h-8" alt="">
        Admin Panel
    </div>
    
    <nav class="flex-grow overflow-y-auto">
        <div class="mb-6">
            <h3 class="text-xs font-semibold text-text/70 uppercase tracking-wide mb-3 px-3">Content Management</h3>
            
            <a href="{{ route('admin.pending-recipes') }}" 
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary/10 text-text hover:text-primary transition-colors duration-200">
                <i data-lucide="chef-hat" class="w-5 h-5"></i>
                <span>Pending Recipes</span>
            </a>
            
            <a href="#" 
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary/10 text-text hover:text-primary transition-colors duration-200">
                <i data-lucide="file-text" class="w-5 h-5"></i>
                <span>Blog Posts</span>
            </a>
            
            <a href="#" 
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary/10 text-text hover:text-primary transition-colors duration-200">
                <i data-lucide="tags" class="w-5 h-5"></i>
                <span>Tags & Ingredients</span>
            </a>
            
            <a href="#" 
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary/10 text-text hover:text-primary transition-colors duration-200">
                <i data-lucide="message-square" class="w-5 h-5"></i>
                <span>Comments</span>
            </a>

            <a href="#" 
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary/10 text-text hover:text-primary transition-colors duration-200">
                <i data-lucide="thumbs-up" class="w-5 h-5"></i>
                <span>Votes & Ratings</span>
            </a>
        </div>

        <div class="mb-6">
            <h3 class="text-xs font-semibold text-text/70 uppercase tracking-wide mb-3 px-3">Events</h3>
            
            <a href="#" 
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary/10 text-text hover:text-primary transition-colors duration-200">
                <i data-lucide="calendar" class="w-5 h-5"></i>
                <span>Events</span>
            </a>
            
            <a href="#" 
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary/10 text-text hover:text-primary transition-colors duration-200">
                <i data-lucide="users" class="w-5 h-5"></i>
                <span>Event Attendees</span>
            </a>
        </div>

        <div class="mb-6">
            <h3 class="text-xs font-semibold text-text/70 uppercase tracking-wide mb-3 px-3">User Management</h3>
            
            <a href="#" 
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary/10 text-text hover:text-primary transition-colors duration-200">
                <i data-lucide="users" class="w-5 h-5"></i>
                <span>Users</span>
            </a>
            
            <a href="#" 
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary/10 text-text hover:text-primary transition-colors duration-200">
                <i data-lucide="shield-check" class="w-5 h-5"></i>
                <span>Roles & Permissions</span>
            </a>
            
            <a href="#" 
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary/10 text-text hover:text-primary transition-colors duration-200">
                <i data-lucide="activity" class="w-5 h-5"></i>
                <span>Recipe Attempts</span>
            </a>
        </div>

        <div class="mb-6">
            <h3 class="text-xs font-semibold text-text/70 uppercase tracking-wide mb-3 px-3">Communications</h3>

            <a href="#" 
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary/10 text-text hover:text-primary transition-colors duration-200">
                <i data-lucide="mail" class="w-5 h-5"></i>
                <span>Contact Forms</span>
            </a>
        </div>
    </nav>

    <div class="border-t border-text/10 pt-4">
        <div class="flex items-center gap-3 mb-3 px-3">
            <img src="{{ asset('images/default-profile.webp') }}" class="w-8 h-8 rounded-full border-2 border-dashed border-primary/20" alt="">
            <div class="flex-grow">
                <p class="text-sm font-medium text-text">{{ auth()->user()->name ?? 'Admin User' }}</p>
                <p class="text-xs text-text/60">Administrator</p>
            </div>
        </div>
        
        <div class="flex gap-2 flex-col">
            <form action="{{ route('auth.logout') }}" method="POST" class="w-full flex">
                @csrf
                <x-button class="w-full" :text="'Logout'" :variant="ButtonVariant::Secondary" :size="ButtonSize::Small" :icon="'<i data-lucide=\'external-link\' class=\'w-4 h-4\'></i>'"/>
            </form>
            <a href="{{ route('home') }}" class="w-full flex">
                <x-button class="w-full" :text="'View Site'" :variant="ButtonVariant::Primary" :size="ButtonSize::Small" :icon="'<i data-lucide=\'external-link\' class=\'w-4 h-4\'></i>'"/>
            </a>
        </div>
    </div>
</div>