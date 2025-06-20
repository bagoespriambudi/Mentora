<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Redirect users to their appropriate dashboards based on role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            
            case 'tutor':
                return redirect()->route('tutor.dashboard');
            
            case 'tutee':
                return $this->tuteeDashboard();
            
            default:
                abort(403, 'Unauthorized role');
        }
    }
    
    private function tuteeDashboard()
    {
        $user = Auth::user();
        
        // Get all bookings for this tutee that are not cancelled or completed and not yet paid
        $outstandingBookings = Booking::where('tutee_id', $user->id)
            ->whereNull('payment_id')
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->with('session')
            ->get();
        $outstandingBalance = $outstandingBookings->sum(function ($booking) {
            return $booking->session ? $booking->session->price : 0;
        });

        // Get order statistics
        $orders = Order::where('client_id', $user->id)->with(['service', 'payments']);
        $totalOrders = $orders->count();
        $pendingOrders = $orders->where('status', 'pending')->count();
        $recentOrders = $orders->latest('order_date')->take(3)->get();
        $unpaidOrders = $orders->get()->filter(function ($order) {
            return !$order->isPaid() && !$order->hasPendingPayment() && $order->status !== 'cancelled';
        });

        return view('dashboard', compact(
            'outstandingBalance', 
            'totalOrders', 
            'pendingOrders', 
            'recentOrders', 
            'unpaidOrders'
        ));
    }
} 