@php
    use App\Enums\ButtonSize;
    use App\Enums\ButtonVariant;

    $recipe = $res->getData();

    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Recipes', 'url' => '/recipes'],
        ['label' => $recipe->name, 'url' => '/recipes/' . $recipe->id],
    ];
@endphp

@extends('layout.index')

@section('title', $recipe->name)

@section('content')
    <section class="flex items-center justify-center pb-16">
        <section class="flex flex-col min-w-[50vw] lg:max-w-[60vw] gap-5">
            {{-- overall section --}}
            <div class="w-full grid grid-cols-3">
                <div class="flex flex-col p-3 justify-start items-start gap-2 md:col-span-2 relative">
                    <div class="absolute top-3 right-3 p-1 rounded-full flex gap-2">
                        {{-- TO-DO: implement these --}}
                        <div class="border-text/60 text-text/60 p-1 rounded border cursor-pointer hover:border-secondary hover:text-secondary">
                            <i data-lucide="share-2" class="w-4 h-4"></i>
                        </div>
                        <div class="border-text/60 text-text/60 p-1 rounded border cursor-pointer hover:border-secondary hover:text-secondary">
                            <i data-lucide="bookmark" class="w-4 h-4"></i>
                        </div>
                        <div class="border-text/60 text-text/60 p-1 rounded border cursor-pointer hover:border-secondary hover:text-secondary">
                            <i data-lucide="download" class="w-4 h-4"></i>
                        </div>
                    </div>


                    <h1 class="text-primary text-3xl font-bold">{{ $recipe->name }}</h1>
                    <div class="flex gap-2">
                        <div class="bg-secondary/20 border-2 border-primary/20 rounded-full px-2 py-1 border-dashed text-xs">Mexican</div>
                        <div class="bg-secondary/20 border-2 border-primary/20 rounded-full px-2 py-1 border-dashed text-xs">Easy</div>
                    </div>
                    <h3 class="text-primary text-sm">By <a class="font-medium hover:underline hover:text-secondary cursor-pointer">John Doe</a></h3>
                    <p class="text-text/60 text-xs">Approved by FoodFusion QA Team — 13:43, August 12, 2024</p>
                </div>
                <div class="flex justify-end items-center">
                    <img src="{{ asset('images/example-recipe.jpg') }}" alt="" class="h-40 w-auto object-cover rounded-2xl border-2 border-dashed border-primary/20">
                </div>
            </div>

            {{-- description section --}}
            <div class="flex flex-col gap-3 py-5 px-8 bg-primary/10 rounded-2xl border-dashed border-2 border-primary/20">
                <h2 class="text-primary text-xl font-semibold">About this recipe</h2>
                <p class="text-text/60">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus cum accusantium impedit? Ea, quam veritatis?
                    Nostrum, veritatis incidunt voluptate, recusandae perferendis suscipit, quis aspernatur magni commodi laboriosam quos facilis consectetur.
                    Provident iure dicta, voluptatibus sequi nisi reiciendis quae nemo dignissimos odit autem corrupti, quasi recusandae!
                </p>
            </div>

            {{-- attributes section --}}
            <div class="grid md:grid-cols-4 grid-cols-2 gap-3 min-h-32">
                <div class="flex items-center justify-center flex-col bg-white/30 rounded-2xl border-2 border-primary/20 border-dashed">
                    <i data-lucide="users" class="text-secondary mb-3"></i>
                    <span class="text-text/60">Servings</span>
                    <span class="text-text font-semibold text-xl">10</span>
                </div>
                <div class="flex items-center justify-center flex-col bg-white/30 rounded-2xl border-2 border-primary/20 border-dashed">
                    <i data-lucide="clock" class="text-secondary mb-3"></i>
                    <span class="text-text/60">Prep</span>
                    <span class="text-text font-semibold text-xl">2 hours</span>
                </div>
                <div class="flex items-center justify-center flex-col bg-white/30 rounded-2xl border-2 border-primary/20 border-dashed">
                    <i data-lucide="chef-hat" class="text-secondary mb-3"></i>
                    <span class="text-text/60">Cook</span>
                    <span class="text-text font-semibold text-xl">3 hours</span>
                </div>
                <div class="flex items-center justify-center flex-col bg-white/30 rounded-2xl border-2 border-primary/20 border-dashed">
                    <i data-lucide="flame" class="text-secondary mb-3"></i>
                    <span class="text-text/60">Difficulty</span>
                    <span class="text-text font-semibold text-xl">Easy</span>
                </div>
            </div>

            {{-- ingredients and instructions --}}
            <div class="grid md:grid-cols-3 gap-5 grid-cols-1">
                <div class=" flex flex-col gap-3">
                    <div class="border-b-3 border-dashed border-primary/20 w-full flex py-3">
                        <h1 class=" text-primary text-2xl font-semibold">Ingredients</h1>
                    </div>
                    <ul class="list-disc list-inside marker:text-secondary/60 marker:text-lg space-y-1">
                        @for ($x = 1; $x <= 3; $x++)
                            <li class="text-text/60">1 cup of flour</li>
                            <li class="text-text/60">2 eggs</li>
                            <li class="text-text/60">1/2 cup of sugar</li>
                        @endfor
                    </ul>
                </div>
                <div class="md:col-span-2 flex flex-col gap-3">
                    <div class="border-b-3 border-dashed border-primary/20 w-full flex py-3">
                        <h1 class=" text-primary text-2xl font-semibold">Instructions</h1>
                    </div>
                    <ul class="flex flex-col gap-2">
                        @for ($x = 1; $x <= 5; $x++)
                            <li>
                                <div class="border-2 border-dashed border-primary/20 rounded-lg p-4 bg-white/30">
                                    <div class="flex items-start gap-4">
                                        <!-- Step Number -->
                                        <div class="w-8 h-8 bg-secondary text-white rounded-full flex items-center justify-center font-semibold text-sm flex-shrink-0">
                                            {{ $x }}
                                        </div>
                                        <!-- Step Content -->
                                        <div>
                                            <h3 class="font-semibold text-primary mb-2">Step Title {{ $x }}</h3>
                                            <p class="text-text leading-relaxed">
                                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus laborum incidunt veritatis reprehenderit id?
                                                Nesciunt ex provident velit sapiente quis impedit optio dolor, in illum quas? Quam, placeat.
                                                Repudiandae aut omnis repellat, non excepturi ea aperiam eius placeat, amet unde laboriosam dolorum.
                                                Sequi, dolorem, provident, repellendus quia fuga laborum aperiam omnis fugit vel distinctio facilis libero.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>

            {{-- attempts section --}}
            <div class="flex flex-col gap-3">
                <div class="border-b-3 border-dashed border-primary/20 w-full flex py-3 items-center justify-between">
                    <h1 class="text-primary text-2xl font-semibold">Tried It?</h1>
                    <a class="flex items-center gap-2 hover:text-secondary hover:underline cursor-pointer">
                        See all
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <div class="grid md:grid-cols-4 gap-3">
                    @for ($x = 1; $x <= 4; $x++)
                        <div class="border-2 border-dashed border-primary/20 rounded-lg overflow-hidden bg-white/30 flex flex-col">
                            <div class="w-full py-5 flex items-center justify-center">
                                <img 
                                    src="{{ asset('images/example-recipe.jpg') }}" 
                                    alt="Attempt photo" 
                                    class="rounded-full border-primary/20 border-2 border-dashed w-24 h-24 object-cover"
                                >
                            </div>
                            <div class="py-5 px-3 flex flex-col gap-2 items-center justify-center">
                                <p class="text-sm text-text/70 text-center leading-relaxed">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius minus, maiores eveniet possimus qui harum.
                                </p>
                                <span class="text-sm font-semibold text-primary">—username{{ $x }}—</span>
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="flex items-center justify-center flex-col gap-4 py-4">
                    <p class="text-text/60 text-base">Trying this recipe this weekend?</p>
                    <x-button :variant="ButtonVariant::Secondary" :size="ButtonSize::Large" :text="'Share your attempt'" :icon="'<i data-lucide=\'camera\'></i>'"/>
                </div>
            </div>
        </section>
    </section>
@endsection
