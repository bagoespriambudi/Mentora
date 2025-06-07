<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ReportedContent;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::latest()->paginate(12);
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
        $request->validate([
            'reason' => 'required|string|min:10',
        ]);
        ReportedContent::create([
            'content_id' => $content->id,
            'reporter_id' => auth()->id(),
            'reason' => $request->reason,
            'status' => 'pending',
        ]);
        return redirect()->route('contents.show', $content)->with('success', 'Content reported.');
    }
}