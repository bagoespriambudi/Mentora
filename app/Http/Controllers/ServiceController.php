<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
            'duration_days' => 'required|integer|min:1',
            'thumbnail' => 'required|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
        ]);

        // Handle thumbnail upload
        $validated['thumbnail'] = $request->file('thumbnail')->store('services/thumbnails', 'public');

        // Handle gallery uploads
        $gallery = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $gallery[] = $image->store('services/gallery', 'public');
            }
        }
        $validated['gallery'] = $gallery;

        // Add user_id and is_active
        $validated['user_id'] = Auth::id();
        $validated['is_active'] = true;

        Service::create($validated);

        return redirect()->route('services.manage')
            ->with('success', 'Service created successfully!');
    }

    public function manage()
    {
        $services = Service::where('user_id', Auth::id())
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('services.manage', compact('services'));
    }

    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    public function destroy(Service $service)
    {
        // Check if the authenticated user owns this service
        if ($service->user_id !== Auth::id()) {
            return redirect()->route('services.manage')
                ->with('error', 'Unauthorized action.');
        }

        $service->delete();

        return redirect()->route('services.manage')
            ->with('success', 'Service deleted successfully.');
    }

    public function edit(Service $service)
    {
        // Check if the authenticated user owns this service
        if ($service->user_id !== Auth::id()) {
            return redirect()->route('services.manage')
                ->with('error', 'Unauthorized action.');
        }

        $categories = Category::where('is_active', true)->get();
        return view('services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        // Check if the authenticated user owns this service
        if ($service->user_id !== Auth::id()) {
            return redirect()->route('services.manage')
                ->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
            'duration_days' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $service->update($validated);

        return redirect()->route('services.manage')
            ->with('success', 'Service updated successfully.');
    }
}
