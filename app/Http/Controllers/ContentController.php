<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ReportedContent;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::latest()->paginate(10);
        return view('contents.index', compact('contents'));
    }

    public function show(Content $content)
    {
        return view('contents.show', compact('content'));
    }

    public function reportForm(Content $content)
    {
        return view('contents.report', compact('content'));
    }

    public function reportSubmit(Request $request, Content $content)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $content->reports()->create([
            'user_id' => auth()->id(),
            'reason' => $validated['reason'],
            'status' => 'pending'
        ]);

        return redirect()->route('contents.show', $content)
            ->with('success', 'Content reported successfully.');
    }
}

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\ContentReport;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        // Inline role check
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only administrators can manage content.');
        }

        $contents = Content::with('category')->latest()->paginate(10);
        return view('admin.contents.index', compact('contents'));
    }

    public function create()
    {
        // Inline role check
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only administrators can create content.');
        }

        return view('admin.contents.create');
    }

    public function store(Request $request)
    {
        // Inline role check
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only administrators can create content.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('contents', 'public');
        }

        Content::create($validated);

        return redirect()->route('admin.contents.index')
            ->with('success', 'Content created successfully.');
    }

    public function edit(Content $content)
    {
        // Inline role check
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only administrators can edit content.');
        }

        return view('admin.contents.edit', compact('content'));
    }

    public function update(Request $request, Content $content)
    {
        // Inline role check
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only administrators can update content.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('contents', 'public');
        }

        $content->update($validated);

        return redirect()->route('admin.contents.index')
            ->with('success', 'Content updated successfully.');
    }

    public function destroy(Content $content)
    {
        // Inline role check
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only administrators can delete content.');
        }

        $content->delete();

        return redirect()->route('admin.contents.index')
            ->with('success', 'Content deleted successfully.');
    }

    public function reportedIndex()
    {
        // Inline role check
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only administrators can view reported content.');
        }

        $reports = ContentReport::with(['content', 'user'])->latest()->paginate(10);
        return view('admin.contents.reported', compact('reports'));
    }

    public function reviewReport(ContentReport $report)
    {
        // Inline role check
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only administrators can review reports.');
        }

        return view('admin.contents.review-report', compact('report'));
    }

    public function resolveReport(ContentReport $report)
    {
        // Inline role check
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only administrators can resolve reports.');
        }

        $report->update(['status' => 'resolved']);
        $report->content->update(['is_active' => false]);

        return redirect()->route('admin.contents.reported')
            ->with('success', 'Report resolved successfully.');
    }

    public function rejectReport(ContentReport $report)
    {
        // Inline role check
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only administrators can reject reports.');
        }

        $report->update(['status' => 'rejected']);

        return redirect()->route('admin.contents.reported')
            ->with('success', 'Report rejected successfully.');
    }
}