<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Driver;
use App\Models\Booking;
use App\Models\Location;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques de base
        $driversCount = Driver::count();
        $passengersCount = User::where('role', 'passenger')->count();
        $todayBookingsCount = Booking::whereDate('created_at', today())->count();
        $totalRevenue = Booking::where('status', 'completed')->sum('amount');

        // Réservations récentes
        $recentBookings = Booking::with(['user', 'driver.user', 'location'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Avis récents
        $recentReviews = Review::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Destinations populaires
        $popularLocations = Location::withCount('bookings')
            ->withAvg('bookings as average_price', 'amount')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'driversCount',
            'passengersCount',
            'todayBookingsCount',
            'totalRevenue',
            'recentBookings',
            'recentReviews',
            'popularLocations'
        ));
    }
}
