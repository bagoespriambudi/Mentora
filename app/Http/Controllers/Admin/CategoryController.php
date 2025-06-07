<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
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
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
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