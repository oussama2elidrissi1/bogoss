<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $totalRevenue = Booking::sum('price');
        $totalBookings = Booking::count();
        $totalClients = Client::count();
        $totalServices = Service::count();
        $averageBookingValue = $totalBookings > 0 ? round($totalRevenue / $totalBookings, 2) : 0;
        $activeStaff = Staff::count();

        $recentBookings = Booking::orderBy('created_at', 'desc')->limit(5)->get();

        $topServices = Booking::select('service', DB::raw('count(*) as count'))
            ->groupBy('service')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        return view('admin.analytics', [
            'totalRevenue' => $totalRevenue,
            'totalBookings' => $totalBookings,
            'totalClients' => $totalClients,
            'totalServices' => $totalServices,
            'averageBookingValue' => $averageBookingValue,
            'activeStaff' => $activeStaff,
            'recentBookings' => $recentBookings,
            'topServices' => $topServices,
        ]);
    }
}
