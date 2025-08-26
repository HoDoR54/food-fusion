@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;
@endphp

<div class="border-2 border-dashed border-primary/30 bg-white rounded-xl max-w-lg mx-auto min-w-[400px]">
    <!-- Header with close button -->
    <div class="flex items-center justify-between border-b border-dashed border-primary/20 p-4">
            <h2 class="text-lg font-bold text-primary">Share Your Attempt</h2>
            <i data-lucide="x" class="stroke-2 w-[1.5rem] h-[1.5rem] text-primary hover:text-secondary cursor-pointer" data-action="close-popup"></i>
    </div>

        <form method="POST" enctype="multipart/form-data" class="p-4 flex flex-col gap-4 w-full">
            @csrf

            <div class="flex flex-col gap-4 md:flex-row md:gap-4">
                <!-- Photo Upload Section -->
                <div class="flex flex-col gap-2 md:w-1/3">
                    <label class="block text-sm text-text/60 font-medium">
                        <i data-lucide="camera" class="w-4 h-4 inline mr-1"></i>
                        Photo
                    </label>
                    
                    <div id="attempt-image-preview-container" class="hidden relative">
                        <img id="attempt-image-preview" src="#"
                            alt="Attempt Image Preview"
                            class="w-full h-24 object-cover rounded-lg border border-dashed border-primary/30" />
                        <button type="button" id="remove-attempt-image" 
                            class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center transition cursor-pointer">
                            <i data-lucide="x" class="w-3 h-3"></i>
                        </button>
                    </div>

                    <label id="attempt-image-label" for="image_file"
                        class="flex flex-col items-center justify-center gap-2 border border-dashed border-primary/30 rounded-lg bg-primary/10 hover:bg-primary/20 transition cursor-pointer w-full h-24">
                        <i data-lucide="camera" class="w-6 h-6 text-gray-500"></i>
                        <span class="text-xs text-gray-500">Upload photo</span>
                    </label>

                    <input type="file" id="image_file" name="image_file" accept="image/*" class="hidden" />
                </div>

                <!-- Notes Section -->
                <div class="flex flex-col gap-2 md:w-2/3">
                    <label for="notes" class="block text-sm text-text/60 font-medium">
                        <i data-lucide="edit-3" class="w-4 h-4 inline mr-1"></i>
                        How did it go?
                    </label>
                    <textarea 
                        id="notes" 
                        name="notes" 
                        placeholder="Share your experience, modifications, or tips..."
                        class="border border-dashed border-primary/30 bg-secondary/15 resize-none px-3 py-2 rounded-lg focus:outline-2 focus:outline-primary w-full h-40 text-sm"
                        rows="6"></textarea>
                </div>
            </div>

            <div class="flex gap-2 pt-2">
                <button 
                    type="submit" 
                    class="flex-1 bg-primary hover:bg-primary/90 text-white py-2 px-4 rounded-lg transition text-sm font-semibold flex items-center justify-center gap-1">
                    <i data-lucide="upload" class="w-4 h-4"></i>
                    Share
                </button>
            </div>
        </form>
</div>