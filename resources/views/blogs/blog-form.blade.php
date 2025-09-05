<div class="border-2 border-dashed border-primary/30 bg-white/60 rounded-2xl">
    <div class="border-b border-dashed border-primary/20 p-6">
        <h2 class="text-xl font-bold text-primary">Blog Post Details</h2>
    </div>

    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data" class="p-6 flex flex-col gap-6">
        @csrf
        
        <div class="grid md:grid-cols-2 gap-6">
            <div class="flex flex-col gap-4">
                <!-- Blog Title -->
                <div class="flex flex-col gap-2">
                    <label for="title" class="block text-sm text-text/60">Blog Title</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title') }}"
                        placeholder="Give your blog post an engaging title..." 
                        class="border border-dashed border-primary/30 bg-secondary/15 px-4 py-2 rounded-lg focus:outline-2 focus:outline-primary w-full"
                        required
                    >
                    @error('title')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Blog Content -->
                <div class="flex flex-col gap-2">
                    <label for="content" class="block text-sm text-text/60">Content</label>
                    <textarea 
                        id="content" 
                        name="content" 
                        rows="8"
                        placeholder="Share your culinary story, cooking tips, or food experiences..." 
                        class="border border-dashed border-primary/30 bg-secondary/15 resize-none px-4 py-2 rounded-lg focus:outline-2 focus:outline-primary w-full min-h-[200px]"
                        required
                    >{{ old('content') }}</textarea>
                    <p class="text-xs text-text/60">Minimum 50 characters required</p>
                    @error('content')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="flex flex-col gap-2">
                <label class="block text-sm text-text/60">Featured Image</label>
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
                @error('image')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Tags Section -->
        <div class="flex flex-col gap-4">
            <label class="block text-sm text-text/60">Tags</label>
            <div id="tags-container" class="flex flex-col gap-3">
                <!-- Dynamic tag inputs will be added here -->
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
                Publish Blog Post
            </button>
            <p class="text-sm text-text/60 text-center mt-3">
                By publishing, you agree to share this blog post with our community under our sharing guidelines.
            </p>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview functionality
        const imageInput = document.getElementById('image');
        const imageLabel = document.getElementById('image-label');
        const previewContainer = document.getElementById('image-preview-container');
        const previewImage = document.getElementById('image-preview');
        const removeImageBtn = document.getElementById('remove-image');

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    imageLabel.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        removeImageBtn.addEventListener('click', function() {
            imageInput.value = '';
            previewContainer.classList.add('hidden');
            imageLabel.classList.remove('hidden');
        });

        // Tag management functionality
        let tagCounter = 0;
        const tagsContainer = document.getElementById('tags-container');
        const addTagBtn = document.getElementById('add-tag');

        function createTagInput() {
            const tagDiv = document.createElement('div');
            tagDiv.classList.add('flex', 'gap-3', 'items-start');
            tagDiv.innerHTML = `
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="tags[${tagCounter}][name]" 
                        placeholder="e.g. Cooking Tips, Italian Cuisine"
                        class="border border-dashed border-primary/30 bg-secondary/15 px-4 py-2 rounded-lg focus:outline-2 focus:outline-primary w-full"
                    >
                </div>
                <div class="w-32">
                    <select 
                        name="tags[${tagCounter}][type]" 
                        class="border border-dashed border-primary/30 bg-secondary/15 px-4 py-2 rounded-lg focus:outline-2 focus:outline-primary w-full appearance-none cursor-pointer text-text"
                    >
                        <option value="blog_topic">Topic</option>
                        <option value="blog_category">Category</option>
                    </select>
                </div>
                <button 
                    type="button" 
                    onclick="removeTag(this)" 
                    class="border border-dashed border-red-500 text-red-500 hover:bg-red-50 bg-transparent px-3 py-2 rounded-lg transition flex items-center justify-center cursor-pointer"
                >
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            `;
            tagsContainer.appendChild(tagDiv);
            tagCounter++;
            
            // Initialize Lucide icons for the new elements
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }
        
        window.removeTag = function(button) {
            button.parentElement.remove();
        };
        
        addTagBtn.addEventListener('click', createTagInput);
    });
</script>
