@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;
@endphp

<div class="carousel w-full rounded-lg overflow-hidden" 
     data-slides-visible="{{ $slidesVisible }}" 
     data-auto-play="{{ $autoPlay ? 'true' : 'false' }}" 
     data-auto-play-interval="{{ $autoPlayInterval }}">
    <div class="relative px-4 pb-8">
        <div class="flex justify-between items-center w-full">
            <div class="mb-3 flex flex-col items-start justify-center gap-2">
                <h2 class="text-text text-3xl font-semibold">{{ $title }}</h2>
                @if($description)
                    <p class="text-gray-600">{{ $description }}</p>
                @endif
            </div>
            @if($showSeeAll)
                <div class="flex items-center justify-center gap-2 hover:underline hover:text-secondary cursor-pointer">
                    @if($seeAllUrl)
                        <a href="{{ $seeAllUrl }}" class="flex items-center gap-2">
                            See all
                            <i data-lucide="arrow-right"></i>
                        </a>
                    @else
                        See all
                        <i data-lucide="arrow-right"></i>
                    @endif
                </div>
            @endif
        </div>
        

        <div class="relative overflow-hidden rounded-lg">
            <div class="carousel-track flex transition-transform duration-500 ease-in-out">
                @forelse($items as $index => $item)
                    <div class="carousel-slide p-2 flex-shrink-0">
                        <div class="slide-content relative group overflow-hidden rounded border-primary border-dotted border-2 transition-all duration-300 hover:scale-[102%] cursor-pointer aspect-[3/4]">
                            <div class="absolute top-0 left-0 right-0 bottom-0 bg-gradient-to-t group-hover:via-black from-black via-secondary/30 to-secondary/40 opacity-50 z-10"></div>
                            <img src="{{ asset('images/' . $item['image']) }}" 
                                 alt="{{ $item['alt'] ?? $item['title'] ?? 'Carousel item' }}" 
                                 class="w-full h-full contrast-[90%] saturate-[50%] brightness-125 object-cover transition-all duration-300 group-hover:scale-110 ease-in-out">
                            <div class="hidden group-hover:block absolute bottom-0 left-0 right-0 p-4 text-white z-20">
                                <h3 class="text-lg font-semibold">{{ $item['title'] ?? 'Item Title' }}</h3>
                                <p class="text-sm line-clamp-2 text-gray-300">
                                    {{ $item['description'] ?? 'Item description' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="carousel-slide p-2 flex-shrink-0">
                        <div class="slide-content relative overflow-hidden rounded border-primary border-dotted border-2 aspect-[3/4] flex items-center justify-center bg-gray-100">
                            <p class="text-gray-500">No items to display</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        
        @if(count($items) > 1)
            <div class="flex justify-center items-center mt-6 px-4 gap-5">
                <div class="carousel-prev">
                    <x-button :variant="ButtonVariant::Primary" 
                              :size="ButtonSize::Small" 
                              :icon="'<i data-lucide=\'chevron-left\'></i>'"
                    />
                </div>

                <div class="carousel-indicators flex space-x-3">
                    @for($i = 0; $i < $getIndicatorCount(); $i++)
                        <button class="carousel-indicator w-3 h-3 rounded-full bg-secondary/50 border-2 border-primary cursor-pointer transition-all duration-200 hover:bg-secondary hover:scale-110 {{ $i === 0 ? 'active bg-primary scale-125 shadow-md' : '' }}" 
                                aria-label="Go to slide {{ $i + 1 }}"></button>
                    @endfor
                </div>
                
                <div class="carousel-next">
                    <x-button :variant="ButtonVariant::Primary" 
                              :size="ButtonSize::Small" 
                              :icon="'<i data-lucide=\'chevron-right\'></i>'"
                    />
                </div>
            </div>
        @endif
    </div>
</div>
                            