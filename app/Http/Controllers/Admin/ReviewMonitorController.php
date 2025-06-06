<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewMonitorController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $reviews = Review::with(['tutee', 'tutor', 'session'])->latest()->paginate(30);
        return view('admin.reviews.index', compact('reviews'));
    }
} 