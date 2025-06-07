<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\ReportedContent;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    // List all contents
    public function index()
    {
        $contents = Content::latest()->paginate(20);
        return view('Admin.contents.index', compact('contents'));
    }

    // Show create form
    public function create()
    {
        return view('Admin.contents.create');
    }

    // Store new content
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        Content::create($validated);
        return redirect()->route('admin.contents.index')->with('success', 'Content created!');
    }

    // Show edit form
    public function edit(Content $content)
    {
        return view('Admin.contents.edit', compact('content'));
    }

    // Update content
    public function update(Request $request, Content $content)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        $content->update($validated);
        return redirect()->route('admin.contents.index')->with('success', 'Content updated!');
    }

    // Delete content
    public function destroy(Content $content)
    {
        $content->delete();
        return redirect()->route('admin.contents.index')->with('success', 'Content deleted!');
    }

    // List reported contents
    public function reportedIndex()
    {
        $reports = ReportedContent::with(['content', 'reporter'])->latest()->paginate(20);
        return view('Admin.contents.reported', compact('reports'));
    }

    // Review a report (show details)
    public function reviewReport(ReportedContent $report)
    {
        return view('Admin.contents.review_report', compact('report'));
    }

    // Resolve a report
    public function resolveReport(Request $request, ReportedContent $report)
    {
        $report->update([
            'status' => 'resolved',
            'admin_notes' => $request->admin_notes,
        ]);
        return redirect()->route('admin.contents.reported')->with('success', 'Report resolved.');
    }

    // Reject a report
    public function rejectReport(Request $request, ReportedContent $report)
    {
        $report->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);
        return redirect()->route('admin.contents.reported')->with('success', 'Report rejected.');
    }
} 