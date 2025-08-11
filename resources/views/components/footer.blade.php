<footer class="flex flex-col">
    <div class="bg-primary/90 grid grid-cols-5 text-white px-3 py-5">
        <div class="col-span-2 flex items-start justify-center flex-col text-left">
            <ul>
                <li class="flex flex-col text-sm">
                    <a href="{{ route('home') }}" class="hover:text-secondary hover:underline">FAQs</a>
                    <a href="{{ route('home') }}" class="hover:text-secondary hover:underline">Privacy Policy</a>
                    <a href="{{ route('home') }}" class="hover:text-secondary hover:underline">Cookie Policy</a>
                </li>
            </ul>
        </div>
        <div class="col-span-1 flex items-center justify-center flex-col">
            <a href="{{ route('home') }}" class="flex items-center justify-center">
                <img src="{{ asset('logo/logo-dark.png') }}" alt="Food Fusion Logo" class="h-10 w-auto">
                <span class="text-[1.4rem] text-white ml-2 font-[lobster]">FoodFusion</span>
            </a>
            <p class="text-xs text-white mt-1">Your favorite community-driven food platform.</p>
        </div>
        <div class="col-span-2 flex flex-col items-end justify-center text-right">
            <ul>
                <li class="flex flex-col text-sm">
                    <a href="{{ route('home') }}" class="hover:text-secondary hover:underline">FAQs</a>
                    <a href="{{ route('home') }}" class="hover:text-secondary hover:underline">Privacy Policy</a>
                    <a href="{{ route('home') }}" class="hover:text-secondary hover:underline">Cookie Policy</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="flex justify-between items-center px-3 py-2 bg-secondary/15 text-sm text-primary">
        <p>&copy; no copy right claimed actually.</p>
        <p>Designed and developed by Hpone Tauk Nyi.</p>
    </div>
</footer>