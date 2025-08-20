{{-- @php
    $title = 'Share Your Recipe';
    $breadcrumbItems = [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Create', 'url' => route('recipes.create.show')]
    ];
@endphp --}}

{{-- @extends('layout.index') --}}

{{-- @section('title', $title) --}}

{{-- @section('content') --}}
    {{-- <section class="grid col-span-1 md:grid-cols-3 w-full">
        <div class="bg-gray-100 p-4 flex flex-col items-center justify-center gap-3">
            <div class="flex flex-col p-3">
                <h2 class="text-xl font-semibold w-full text-center">How It Works</h2>
                <ul class="flex gap-2">
                    <li>
                        <div>
                            <h3 class="text-sm font-medium text-center">You Submit</h3>
                            <p class="text-xs text-text/60 text-center">Fill out the given form to share your recipe with our community.</p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <h3 class="text-sm font-medium text-center">We Review</h3>
                            {{-- TO-DO: add a static 'guidelines' route --}}
                            {{-- <p class="text-xs text-text/60 text-center">Our team reviews your submission for quality and relevance based on <a href="{{ route('home') }}" class="hover:underline">our standard guidelines</a>.</p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <h3 class="text-sm font-medium text-center">Community Enjoys</h3>
                            <p class="text-xs text-text/60 text-center">Once approved, your recipe will be shared with our community for everyone to enjoy!</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="md:col-span-2 bg-white p-4">
            <h1 class="text-2xl font-bold mb-6">{{ $title }}</h1>
            
            <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Recipe Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Recipe Title *</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                        placeholder="Enter your recipe title"
                        required
                    >
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Recipe Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                        placeholder="Describe your recipe"
                        required
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Main Image Upload -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Main Recipe Image *</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload a file</span>
                                    <input 
                                        id="image" 
                                        name="image" 
                                        type="file" 
                                        accept="image/*" 
                                        class="sr-only"
                                        onchange="previewMainImage(this)"
                                        required
                                    >
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                        </div>
                    </div>
                    <div id="main-image-preview" class="mt-4 hidden">
                        <img id="main-image-preview-img" src="" alt="Main image preview" class="max-w-xs h-auto rounded-md">
                    </div>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Additional Images Upload -->
                <div>
                    <label for="additional_images" class="block text-sm font-medium text-gray-700 mb-2">Additional Images (Optional)</label>
                    <input 
                        type="file" 
                        id="additional_images" 
                        name="additional_images[]" 
                        multiple 
                        accept="image/*"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('additional_images') border-red-500 @enderror"
                        onchange="previewAdditionalImages(this)"
                    >
                    <p class="text-xs text-gray-500 mt-1">Upload up to 5 additional images (PNG, JPG, GIF up to 5MB each)</p>
                    <div id="additional-images-preview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                    @error('additional_images')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button 
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        Create Recipe
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection --}}