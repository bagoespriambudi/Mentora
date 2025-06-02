<?php

namespace App\Http\Controllers;

use App\Models\Content;

class ContentController extends Controller
{
    public function index()
    {
        $content = [
            'faqs' => Faq::all(),
            'guides' => Guide::all(),
            'policies' => Policy::all(),
        ];

        return view('welcome', compact('content'));
    }
}