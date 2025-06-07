<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Session - Mentora</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .input-focus {
            transition: all 0.3s ease;
        }
        
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .floating-label {
            position: relative;
        }
        
        .floating-label input:focus + label,
        .floating-label input:not(:placeholder-shown) + label,
        .floating-label textarea:focus + label,
        .floating-label textarea:not(:placeholder-shown) + label,
        .floating-label select:focus + label {
            transform: translateY(-1.5rem) scale(0.75);
            color: #667eea;
        }
        
        .floating-label label {
            position: absolute;
            left: 0.75rem;
            top: 0.75rem;
            transition: all 0.3s ease;
            pointer-events: none;
            background: white;
            padding: 0 0.25rem;
        }
        
        .upload-area {
            border: 2px dashed #cbd5e0;
            transition: all 0.3s ease;
        }
        
        .upload-area:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }
        
        .upload-area.drag-over {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .card-shadow {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="min-h-screen gradient-bg">
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4">
            <!-- Back Button -->
            <div class="mb-8">
                <a href="#" class="inline-flex items-center text-white hover:text-gray-200 transition-colors duration-200 group">
                    <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform duration-200"></i>
                    <span class="text-sm font-medium">Back to Session</span>
                </a>
            </div>

            <!-- Main Card -->
            <div class="glass-effect rounded-2xl p-8 card-shadow">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="inline-block p-4 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mb-4 animate-float">
                        <i class="fas fa-plus text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Create New Session</h2>
                    <p class="text-gray-600">Add a new session to your Mentora portfolio and start earning</p>
                </div>

                <!-- Form -->
                <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- Service Title -->
                    <div class="floating-label">
                        <input type="text" name="title" value="{{ old('title') }}" placeholder=" "
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none input-focus transition-all duration-300" required>
                        <label class="text-gray-600 font-medium">Session Title</label>
                        @error('title') 
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p> 
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-tags mr-2 text-blue-500"></i>
                            Category
                        </label>
                        <select name="category_id" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none input-focus transition-all duration-300 bg-white" required>
                            <option value="">Select category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') 
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p> 
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="floating-label">
                        <textarea name="description" rows="4" placeholder=" "
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none input-focus transition-all duration-300 resize-none" required>{{ old('description') }}</textarea>
                        <label class="text-gray-600 font-medium">Description</label>
                        @error('description') 
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p> 
                        @enderror
                    </div>

                    <!-- Price and Duration -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="floating-label">
                            <input type="number" name="price" value="{{ old('price') }}" min="1" step="0.01" placeholder=" "
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none input-focus transition-all duration-300" required>
                            <label class="text-gray-600 font-medium">
                                <i class="fas fa-rupiah-sign mr-1"></i>
                                Price (Rp.)
                            </label>
                            @error('price') 
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p> 
                            @enderror
                        </div>
                        <div class="floating-label">
                            <input type="number" name="duration_days" value="{{ old('duration_days') }}" min="1" placeholder=" "
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none input-focus transition-all duration-300" required>
                            <label class="text-gray-600 font-medium">
                                <i class="fas fa-clock mr-1"></i>
                                Session Period (hours)
                            </label>
                            @error('duration_days') 
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p> 
                            @enderror
                        </div>
                    </div>

                    <!-- Thumbnail Upload -->
                    <div class="space-y-4">
                        <label class="block text-gray-700 font-semibold text-lg">
                            <i class="fas fa-image mr-2 text-blue-500"></i>
                            Thumbnail Image
                        </label>
                        <div class="upload-area rounded-xl p-6 text-center">
                            <input type="file" name="thumbnail" accept="image/*" class="hidden" id="thumbnail-input" required>
                            <label for="thumbnail-input" class="cursor-pointer">
                                <div class="space-y-3">
                                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto">
                                        <i class="fas fa-cloud-upload-alt text-blue-500 text-2xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 font-medium">Click to upload thumbnail</p>
                                        <p class="text-sm text-gray-400">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('thumbnail') 
                            <p class="text-red-500 text-sm flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p> 
                        @enderror
                        <div id="thumbnail-preview" class="hidden">
                            <div class="relative inline-block">
                                <img src="" alt="Preview" class="w-32 h-32 object-cover rounded-xl shadow-lg">
                                <div class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full w-6 h-6 flex items-center justify-center">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery Upload -->
                    <div class="space-y-4">
                        <label class="block text-gray-700 font-semibold text-lg">
                            <i class="fas fa-images mr-2 text-purple-500"></i>
                            Gallery Images
                            <span class="text-sm text-gray-500 font-normal">(Optional)</span>
                        </label>
                        <div class="upload-area rounded-xl p-6 text-center">
                            <input type="file" name="gallery[]" multiple accept="image/*" class="hidden" id="gallery-input">
                            <label for="gallery-input" class="cursor-pointer">
                                <div class="space-y-3">
                                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto">
                                        <i class="fas fa-images text-purple-500 text-2xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 font-medium">Click to upload gallery images</p>
                                        <p class="text-sm text-gray-400">Multiple images allowed</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('gallery') 
                            <p class="text-red-500 text-sm flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p> 
                        @enderror
                        <div id="gallery-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center pt-6">
                        <button type="submit" class="group relative px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <span class="flex items-center">
                                <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                                Create Session
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Thumbnail preview
        document.getElementById('thumbnail-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('thumbnail-preview');
                    preview.querySelector('img').src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // Gallery preview
        document.getElementById('gallery-input').addEventListener('change', function(e) {
            const container = document.getElementById('gallery-preview');
            container.innerHTML = '';
            [...e.target.files].forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-24 object-cover rounded-xl shadow-md group-hover:shadow-lg transition-shadow duration-300">
                        <div class="absolute -top-2 -right-2 bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold">
                            ${index + 1}
                        </div>
                    `;
                    container.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        });

        // Drag and drop functionality
        const uploadAreas = document.querySelectorAll('.upload-area');
        uploadAreas.forEach(area => {
            area.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('drag-over');
            });

            area.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('drag-over');
            });

            area.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('drag-over');
                
                const input = this.querySelector('input[type="file"]');
                const files = e.dataTransfer.files;
                
                if (input && files.length > 0) {
                    input.files = files;
                    input.dispatchEvent(new Event('change'));
                }
            });
        });
    </script>
</body>
</html>