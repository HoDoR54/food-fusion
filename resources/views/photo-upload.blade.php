@extends('layout.index')

@section('title', 'Cloudinary Photo Upload Test')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-center">Cloudinary Photo Upload Test</h1>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                
                @if(session('image_url'))
                    <div class="mt-4">
                        <p class="text-sm mb-2"><strong>Uploaded Image:</strong></p>
                        <img src="{{ session('image_url') }}" alt="Uploaded photo" class="max-w-full h-auto rounded-lg shadow-md mb-2">
                        <div class="text-xs bg-gray-100 p-2 rounded">
                            <p><strong>URL:</strong> <a href="{{ session('image_url') }}" target="_blank" class="text-blue-600 hover:underline">{{ session('image_url') }}</a></p>
                            <p><strong>Public ID:</strong> {{ session('public_id') }}</p>
                            <p><strong>Original Name:</strong> {{ session('original_name') }}</p>
                        </div>
                        
                        {{-- Delete button for testing --}}
                        <button onclick="deletePhoto('{{ session('public_id') }}')" 
                                class="mt-2 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                            Delete from Cloudinary
                        </button>
                    </div>
                @endif
            </div>
        @endif

        {{-- Error Messages --}}
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">Upload failed!</span>
                </div>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Upload Form --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Photo *
                        <span class="text-gray-500 text-xs">(JPEG, PNG, JPG, GIF - Max 10MB)</span>
                    </label>
                    
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="photo" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload a file</span>
                                    <input 
                                        id="photo" 
                                        name="photo" 
                                        type="file" 
                                        class="sr-only" 
                                        accept="image/*"
                                        required
                                        onchange="previewImage(this)"
                                    >
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                        </div>
                    </div>

                    {{-- Image Preview --}}
                    <div id="imagePreview" class="mt-4 hidden">
                        <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                        <img id="previewImg" src="" alt="Preview" class="max-w-full h-auto max-h-64 rounded-lg shadow-md">
                        <p id="fileName" class="text-xs text-gray-500 mt-1"></p>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Upload to Cloudinary
                    </button>
                    
                    <a href="{{ route('photos.create') }}" 
                       class="text-gray-600 hover:text-gray-800 text-sm underline">
                        Clear Form
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const fileName = document.getElementById('fileName');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    fileName.textContent = input.files[0].name;
                    preview.classList.remove('hidden');
                };
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.classList.add('hidden');
            }
        }

        function deletePhoto(publicId) {
            if (confirm('Are you sure you want to delete this photo from Cloudinary?')) {
                fetch(`/photo/${publicId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Photo deleted successfully!');
                        location.reload();
                    } else {
                        alert('Failed to delete photo: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the photo.');
                });
            }
        }
    </script>
@endsection