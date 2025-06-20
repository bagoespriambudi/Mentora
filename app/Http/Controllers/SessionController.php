<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index()
    {
        // List all sessions for the current tutor from the services table
        if (auth()->user()->role !== 'tutor') abort(403);
        $sessions = \App\Models\Service::where('tutor_id', auth()->id())->latest()->paginate(10);
        $categories = \App\Models\Category::where('is_active', true)->orderBy('name')->get();
        return view('sessions.manage', compact('sessions', 'categories'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'tutor') abort(403);
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('sessions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'tutor') abort(403);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'boolean',
        ]);
        $validated['tutor_id'] = auth()->id();
        $validated['is_published'] = $request->has('is_published');
        Session::create($validated);
        return redirect()->route('sessions.manage')->with('success', 'Session created successfully!');
    }

    public function edit(Session $session)
    {
        if (auth()->user()->role !== 'tutor' || $session->tutor_id !== auth()->id()) abort(403);
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('sessions.edit', compact('session', 'categories'));
    }

    public function update(Request $request, Session $session)
    {
        if (auth()->user()->role !== 'tutor' || $session->tutor_id !== auth()->id()) abort(403);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'boolean'
        ]);
        $session->update($validated);
        return redirect()->route('sessions.manage')->with('success', 'Session updated successfully!');
    }

    public function destroy(Session $session)
    {
        if (auth()->user()->role !== 'tutor' || $session->tutor_id !== auth()->id()) abort(403);
        $session->delete();
        return redirect()->route('sessions.manage')->with('success', 'Session deleted successfully!');
    }
} 