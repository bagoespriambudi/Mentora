<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('services')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
=======
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('services')->paginate(15);
        return view('Admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('Admin.categories.create');
    }

    public function store(Request $request)
>>>>>>> origin/Aida
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
<<<<<<< HEAD
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category): View
    {
        $category->load('services');
        
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
=======
            'is_active' => 'boolean',
        ]);
        $validated['is_active'] = $request->has('is_active');
        Category::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category created!');
    }

    public function show(Category $category)
    {
        return view('Admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('Admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
>>>>>>> origin/Aida
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
<<<<<<< HEAD
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->services()->count() > 0) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Cannot delete category that has services associated with it.');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
=======
            'is_active' => 'boolean',
        ]);
        $validated['is_active'] = $request->has('is_active');
        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated!');
    }

    public function destroy(Category $category)
    {
        if ($category->services()->count() > 0) {
            return back()->with('error', 'Cannot delete category with services.');
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted!');
    }
} 
>>>>>>> origin/Aida
