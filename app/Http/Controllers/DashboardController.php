<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        
        switch ($user->role) {
            case 'admin':
                return view('dashboard.admin');
            case 'tutor':
                return view('dashboard.tutor');
            case 'tutee':
                return view('dashboard.tutee');
            default:
                return view('dashboard.guest');
        }
    }
} 