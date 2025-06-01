<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Service | Mentora</title>
</head>
<body>
    <div style="max-width: 600px; margin: 40px auto; font-family: sans-serif;">
        <a href="{{ route('services.manage') }}">← Back to Services</a>
        <h2>Edit Service</h2>

        @if(session('success'))
            <div style="background-color: #d4edda; padding: 10px; margin-bottom: 10px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background-color: #f8d7da; padding: 10px; margin-bottom: 10px;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('services.update', $service) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 10px;">
                <label>Service Title:</label><br>
                <input type="text" name="title" value="{{ old('title', $service->title) }}" required style="width: 100%;">
                @error('title') <div style="color: red;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 10px;">
                <label>Category:</label><br>
                <select name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $service->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div style="color: red;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 10px;">
                <label>Description:</label><br>
                <textarea name="description" rows="4" required style="width: 100%;">{{ old('description', $service->description) }}</textarea>
                @error('description') <div style="color: red;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 10px;">
                <label>Price ($):</label><br>
                <input type="number" name="price" min="1" step="0.01" value="{{ old('price', $service->price) }}" required>
                @error('price') <div style="color: red;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 10px;">
                <label>Delivery Time (days):</label><br>
                <input type="number" name="duration_days" min="1" value="{{ old('duration_days', $service->duration_days) }}" required>
                @error('duration_days') <div style="color: red;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 10px;">
                <label>Thumbnail Image:</label><br>
                @if($service->thumbnail)
                    <img src="{{ Storage::url($service->thumbnail) }}" alt="Current thumbnail" style="width: 100px; height: 100px;"><br>
                    <label><input type="checkbox" name="remove_thumbnail" value="1"> Remove existing thumbnail</label><br>
                @endif
                <input type="file" name="thumbnail" accept="image/*">
                @error('thumbnail') <div style="color: red;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 10px;">
                <label>Gallery Images:</label><br>
                @if($service->gallery)
                    @foreach($service->gallery as $index => $image)
                        <div style="margin-bottom: 5px;">
                            <img src="{{ Storage::url($image) }}" alt="Gallery image" style="width: 100px; height: 100px;">
                            <label><input type="checkbox" name="removed_gallery_images[]" value="{{ $index }}"> Remove</label>
                        </div>
                    @endforeach
                @endif
                <input type="file" name="gallery[]" accept="image/*" multiple>
                @error('gallery') <div style="color: red;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 10px;">
                <label>
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                    Active
                </label>
            </div>

            <div>
                <button type="submit">Update Service</button>
            </div>
        </form>
    </div>
</body>
</html>