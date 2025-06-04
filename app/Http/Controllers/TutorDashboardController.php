<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorDashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'tutor') {
            abort(403, 'Unauthorized');
        }
        return view('tutor.dashboard');
    }
}
