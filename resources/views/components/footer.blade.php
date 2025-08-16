{{-- TO-DO: Add Real links --}}
<footer class="flex flex-col border-t-2 border-dashed border-primary/30">
    <div class="bg-primary/5 px-6 py-12">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            {{-- About Section --}}
            <div class="space-y-4">
                <h3 class="font-bold text-primary text-xl border-b border-dashed border-primary/30 pb-2">
                    About FoodFusion
                </h3>
                <p class="text-sm text-primary/80 leading-relaxed">
                    A community-driven platform where food lovers share recipes, learn together, and celebrate diverse
                    culinary traditions.
                </p>
                <div class="bg-secondary/10 p-3 border border-dashed border-secondary/30">
                    <p class="text-xs text-primary/70">
                        <strong>3</strong> community members
                        <br />
                        <strong>20</strong> recipes shared
                        <br />
                        <strong>0</strong> events hosted
                    </p>
                </div>
            </div>

            {{-- Explore Section --}}
            <div class="space-y-4">
                <h3 class="font-bold text-primary text-xl border-b border-dashed border-primary/30 pb-2">
                    Explore
                </h3>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="{{ route('recipes.index') }}" class="text-primary/80 hover:text-secondary hover:underline">
                            Recipe Collection
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('blogs.index') }}" class="text-primary/80 hover:text-secondary hover:underline">
                            Community Cookbook
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('events.index') }}" class="text-primary/80 hover:text-secondary hover:underline">
                            Upcoming Events
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('edu.index') }}" class="text-primary/80 hover:text-secondary hover:underline">
                            Educational Resources
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Community Section --}}
            <div class="space-y-4">
                <h3 class="font-bold text-primary text-xl border-b border-dashed border-primary/30 pb-2">
                    Community
                </h3>
                <ul class="space-y-2 text-sm">
                    <li>
                        {{-- TO-DO: get discord server link from config --}}
                        <a href="{{ route('home') }}" class="text-primary/80 hover:text-secondary hover:underline">
                            Join Our Discord
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}" class="text-primary/80 hover:text-secondary hover:underline">
                            Volunteer Opportunities
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}" class="text-primary/80 hover:text-secondary hover:underline">
                            Host an Event
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('blogs.create') }}" class="text-primary/80 hover:text-secondary hover:underline">
                            Share Your Recipe
                        </a>
                    </li>
                </ul>

                <div class="bg-secondary/10 p-3 border border-dashed border-primary/20">
                    <p class="text-xs text-primary/70 mb-2">Connect with us:</p>
                    <div class="flex space-x-3">
                        <a href="https://www.facebook.com" target="_blank" class="text-primary/60 hover:text-secondary cursor-pointer">
                            <i data-lucide="facebook"></i>
                        </a>
                        <a href="https://www.instagram.com" target="_blank" class="text-primary/60 hover:text-secondary cursor-pointer">
                            <i data-lucide="instagram"></i>
                        </a>
                        <a href="https://www.twitter.com" target="_blank" class="text-primary/60 hover:text-secondary cursor-pointer">
                            <i data-lucide="twitter"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Contact --}}
            <div class="space-y-4">
                <h3 class="font-bold text-primary text-xl border-b border-dashed border-primary/30 pb-2">
                    Stay Connected
                </h3>

                <div class="text-sm space-y-1">
                    <p class="text-primary/80">
                        <strong>Contact:</strong>
                    </p>
                    <p class="text-primary/60">hello@foodfusion.community</p>
                    <p class="text-primary/60">Community Kitchen Hours:</p>
                    <p class="text-primary/60">Tue-Sun, 10am-8pm</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-primary/80 px-6 py-4">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div class="flex items-center space-x-6">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('logo/logo-dark.png') }}" alt="Food Fusion Logo" class="h-8 w-auto" />
                    <span class="text-lg text-white ml-2 font-lobster">FoodFusion</span>
                </a>
                <div class="hidden md:flex space-x-4 text-sm">
                    <a href="{{ route('about') }}" class="text-white/80 hover:text-secondary hover:underline">
                        About Us
                    </a>
                    <a href="{{ route('contact') }}" class="text-white/80 hover:text-secondary hover:underline">
                        Contact
                    </a>
                    <a href="{{ route('home') }}" class="text-white/80 hover:text-secondary hover:underline">
                        Support
                    </a>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-6 text-sm">
                <div class="flex space-x-4">
                    <a href="{{ route('home') }}" class="text-white/80 hover:text-secondary hover:underline">
                        Privacy Policy
                    </a>
                    <a href="{{ route('home') }}" class="text-white/80 hover:text-secondary hover:underline">
                        Terms of Use
                    </a>
                    <a href="{{ route('home') }}" class="text-white/80 hover:text-secondary hover:underline">
                        Cookie Policy
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center px-6 py-3 bg-secondary/15 text-sm text-primary">
        <p>&copy; {{ date('Y') }} FoodFusion. Copyright? We don't do that here.</p>
        <p>Designed and developed by Hpone Tauk Nyi.</p>
    </div>
</footer>
