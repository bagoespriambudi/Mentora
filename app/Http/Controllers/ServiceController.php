<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('tutor')->latest()->paginate(10);
        return view('services.index', compact('services'));
    }

    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    public function manage()
    {
        // Inline role check
        if (auth()->user()->role !== 'tutor') {
            abort(403, 'Only tutors can manage services.');
        }

        $services = Service::where('tutor_id', auth()->id())->latest()->paginate(10);
        return view('services.manage', compact('services'));
    }

    public function create()
    {
        if (!auth()->check() || auth()->user()->role !== 'tutor') {
            return view('services.create', [
                'categories' => [],
                'error' => 'Only tutors can access this page.'
            ]);
        }
        $categories = Category::where('is_active', true)->get();
        return view('services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'tutor') {
            return redirect()->route('services.create')->with('error', 'Only tutors can create services.');
        }

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
        $validated['tutor_id'] = auth()->id();
        $validated['is_active'] = true;

        Service::create($validated);

        return redirect('/sessions/create')->with('success', 'Service created successfully!');
    }

    public function edit(Service $service)
    {
        // Inline role check
        if (auth()->user()->role !== 'tutor' || $service->tutor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::where('is_active', true)->get();
        return view('services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        // Inline role check
        if (auth()->user()->role !== 'tutor' || $service->tutor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
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

    public function destroy(Service $service)
    {
        // Inline role check
        if (auth()->user()->role !== 'tutor' || $service->tutor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $service->delete();

        return redirect()->route('services.manage')
            ->with('success', 'Service deleted successfully.');
    }
}

