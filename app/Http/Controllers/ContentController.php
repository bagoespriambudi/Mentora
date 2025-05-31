<?php

namespace App\Http\Controllers;

use App\Models\Content;

class ContentController extends Controller
{
    public function index()
    {
        $content = [
            'faqs' => Content::where('type', 'faq')->where('is_active', true)->orderBy('order')->get(),
            'guides' => Content::where('type', 'guide')->where('is_active', true)->orderBy('order')->get(),
            'policies' => Content::where('type', 'policy')->where('is_active', true)->orderBy('order')->get(),
        ];

        return view('content.index', compact('content'));
    }
}