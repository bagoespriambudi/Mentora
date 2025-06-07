<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'tutee') {
            abort(403, 'Unauthorized');
        }
        // Get all bookings for this tutee that are not cancelled or completed and not yet paid
        $outstandingBookings = Booking::where('tutee_id', $user->id)
            ->whereNull('payment_id')
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->with('session')
            ->get();
        $outstandingBalance = $outstandingBookings->sum(function ($booking) {
            return $booking->session ? $booking->session->price : 0;
        });
        return view('dashboard', compact('outstandingBalance'));
    }
} 