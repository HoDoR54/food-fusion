@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;
@endphp

<div class="carousel w-full rounded-lg overflow-hidden">
    <div class="relative px-4 pb-8">
        <div class="relative overflow-hidden rounded-lg">
            <div class="carousel-track flex transition-transform duration-500 ease-in-out">
                @for($i = 1; $i <= 8; $i++)
                    <div class="carousel-slide p-2 flex-shrink-0">
                        <div class="slide-content relative group overflow-hidden rounded border-primary border-dotted border-2 transition-all duration-300 hover:scale-[102%] cursor-pointer aspect-[3/4]">
                            <div class="absolute top-0 left-0 right-0 bottom-0 bg-gradient-to-t from-primary to-secondary/10 opacity-50 z-10"></div>
                            <img src="{{ asset('images/recipes/' . $i . '.jpg') }}" 
                                 alt="Recipe {{ $i }}" 
                                 class="w-full h-full contrast-[90%] saturate-[75%] brightness-125 object-cover transition-all duration-300 group-hover:scale-110 ease-in-out">
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        
        <div class="flex justify-center items-center mt-6 px-4 gap-5">
            <div class="carousel-prev">
                <x-button :variant="ButtonVariant::Primary" 
                          :size="ButtonSize::Small" 
                          :icon="'<i data-lucide=\'chevron-left\'></i>'"
                          class="rounded-3xl" />
            </div>

            <div class="carousel-indicators flex space-x-3">
                @for($i = 1; $i <= (8 - 4); $i++)
                    <button class="carousel-indicator w-3 h-3 rounded-full bg-secondary/50 border-2 border-primary cursor-pointer transition-all duration-200 hover:bg-secondary hover:scale-110 {{ $i === 1 ? 'active bg-primary scale-125 shadow-md' : '' }}" 
                            aria-label="Go to slide {{ $i }}"></button>
                @endfor
            </div>
            
            <div class="carousel-next">
                <x-button :variant="ButtonVariant::Primary" 
                          :size="ButtonSize::Small" 
                          :icon="'<i data-lucide=\'chevron-right\'></i>'"
                          class="rounded-3xl" />
            </div>
        </div>
    </div>
</div>
                            