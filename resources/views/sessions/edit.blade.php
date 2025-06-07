@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Edit Session</h1>
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('sessions.update', $session) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Title</label>
            <input type="text" name="title" class="w-full border rounded px-3 py-2" value="{{ old('title', $session->title) }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2" required>{{ old('description', $session->description) }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Start Time</label>
            <input type="datetime-local" name="start_time" class="w-full border rounded px-3 py-2" value="{{ old('start_time', $session->start_time ? date('Y-m-d\TH:i', strtotime($session->start_time)) : '') }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">End Time</label>
            <input type="datetime-local" name="end_time" class="w-full border rounded px-3 py-2" value="{{ old('end_time', $session->end_time ? date('Y-m-d\TH:i', strtotime($session->end_time)) : '') }}" required>
        </div>
        <div class="mb-4 flex items-center">
            <input type="checkbox" name="is_published" id="is_published" class="mr-2" {{ old('is_published', $session->is_published) ? 'checked' : '' }}>
            <label for="is_published">Publish this session</label>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Session</button>
        <a href="{{ route('sessions.manage') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
    </form>
</div>
@endsection 