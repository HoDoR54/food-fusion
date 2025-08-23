@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;
@endphp

<div class="border-2 border-dashed border-primary/30 bg-white/60 rounded-2xl">
    <div class="border-b border-dashed border-primary/20 p-6">
        <h2 class="text-xl font-bold text-primary">Recipe Details</h2>
    </div>

    <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data"
        class="p-6 flex flex-col gap-6">
        @csrf

        <div class="grid md:grid-cols-2 gap-6">
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <label for="name" class="block text-sm text-text/60">Recipe Name</label>
                    <input type="text" id="name" name="name" required placeholder="e.g. Grandmother's Chicken Soup"
                        class="border border-dashed border-primary/30 bg-secondary/15 px-4 py-2 rounded-lg focus:outline-2 focus:outline-primary w-full" />
                </div>
                
                <div class="flex flex-col gap-2">
                    <label for="description" class="block text-sm text-text/60">Description</label>
                    <textarea id="description" name="description" required
                        placeholder="Tell us about this recipe - its story, what makes it special, or any tips for success..."
                        class="border border-dashed border-primary/30 bg-secondary/15 resize-none px-4 py-2 rounded-lg focus:outline-2 focus:outline-primary w-full min-h-[100px]"
                        rows="4"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="servings" class="text-sm text-text/60 flex items-center gap-2">
                            <i data-lucide="users" class="w-4 h-4"></i>
                            Servings
                        </label>
                        <input type="number" id="servings" name="servings" required min="1" max="20" placeholder="4"
                            class="border border-dashed border-primary/30 bg-secondary/15 px-4 py-2 rounded-lg focus:outline-2 focus:outline-primary w-full" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="difficulty" class="block text-sm text-text/60">Difficulty Level</label>
                        <div class="relative">
                            <select
                                id="difficulty"
                                name="difficulty"
                                required
                                class="border border-dashed border-primary/30 bg-secondary/15 px-4 pr-10 py-2 focus:outline-2 focus:outline-primary rounded-lg w-full appearance-none cursor-pointer text-text"
                            >
                                <option value="" disabled selected>Select difficulty</option>
                                <option value="easy">🟢 Easy</option>
                                <option value="medium">🟡 Medium</option>
                                <option value="hard">🔴 Hard</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col gap-2">
                <label class="block text-sm text-text/60">Recipe Photo</label>
                <div id="image-preview-container" class="hidden relative flex-1">
                    <img id="image-preview" src="#"
                        alt="Image Preview"
                        class="w-full h-[200px] object-cover rounded-lg border border-dashed border-primary/30" />
                    <button type="button" id="remove-image" 
                        class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center transition cursor-pointer">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>

                <label id="image-label" for="image"
                    class="flex flex-col flex-1 items-center justify-center gap-3 border border-dashed border-primary/30 rounded-lg bg-primary/10 hover:bg-primary/20 transition cursor-pointer w-full h-[200px]">
                    <i data-lucide="image" class="w-10 h-10 text-gray-500"></i>
                    <span class="text-sm text-gray-500">Click to upload or drag & drop</span>
                    <span class="text-xs text-gray-400">PNG, JPG, JPEG • Max 5MB</span>
                </label>

                <input type="file" id="image" name="image" accept="image/*" class="hidden" />
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <label class="block text-sm text-text/60">Ingredients</label>
            <div id="ingredients-container" class="flex flex-col gap-3">
                <!-- Ingredients will be added here dynamically -->
            </div>
            <button type="button" id="add-ingredient" 
                class="border border-dashed border-secondary text-secondary hover:bg-secondary/10 bg-transparent px-4 py-2 rounded-lg transition flex items-center gap-2 w-fit cursor-pointer">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Add Ingredient
            </button>
        </div>

        <div class="flex flex-col gap-4">
            <label class="block text-sm text-text/60">Cooking Steps</label>
            <div id="steps-container" class="flex flex-col gap-4">
                <!-- Steps will be added here dynamically -->
            </div>
            <button type="button" id="add-step" 
                class="border border-dashed border-secondary text-secondary hover:bg-secondary/10 bg-transparent px-4 py-2 rounded-lg transition flex items-center gap-2 w-fit cursor-pointer">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Add Step
            </button>
        </div>

        <!-- Tags Section -->
        <div class="flex flex-col gap-4">
            <label class="block text-sm text-text/60">Tags</label>
            <div id="tags-container" class="flex flex-col gap-3">
                <!-- Tags will be added here dynamically -->
            </div>
            <button type="button" id="add-tag" 
                class="border border-dashed border-secondary text-secondary hover:bg-secondary/10 bg-transparent px-4 py-2 rounded-lg transition flex items-center gap-2 w-fit cursor-pointer">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Add Tag
            </button>
        </div>

        <div class="pt-6 border-t border-dashed border-primary/30">
            <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white py-3 px-8 rounded-lg transition font-semibold flex items-center justify-center gap-2 cursor-pointer">
                <i data-lucide="upload" class="w-5 h-5"></i>
                Submit Recipe for Review
            </button>
            <p class="text-sm text-text/60 text-center mt-3">
                By submitting, you agree to share this recipe with our community under our sharing guidelines.
            </p>
        </div>
    </form>
</div>
