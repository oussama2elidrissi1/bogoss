<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function dashboard()
    {
        $totalRevenue = Booking::sum('price');
        $totalBookings = Booking::count();
        $totalClients = Client::count();
        $totalServices = Service::count();
        $averageBookingValue = $totalBookings > 0 ? $totalRevenue / $totalBookings : 0;
        $activeStaff = Staff::count();

        $recentBookings = Booking::with(['client', 'service', 'staff'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $serviceCounts = Booking::select('service', DB::raw('count(*) as count'))
            ->groupBy('service')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'stats' => [
                'total_revenue' => $totalRevenue,
                'total_bookings' => $totalBookings,
                'total_clients' => $totalClients,
                'total_services' => $totalServices,
                'average_booking_value' => round($averageBookingValue, 2),
                'active_staff' => $activeStaff,
            ],
            'recent_bookings' => $recentBookings,
            'top_services' => $serviceCounts,
        ]);
    }

    public function revenue(Request $request)
    {
        $query = Booking::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(price) as revenue'),
            DB::raw('COUNT(*) as bookings')
        )
        ->groupBy('date')
        ->orderBy('date', 'desc');

        if ($request->has('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->has('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        return response()->json($query->get());
    }

    public function topServices()
    {
        $services = Booking::select('service', DB::raw('count(*) as count'))
            ->groupBy('service')
            ->orderBy('count', 'desc')
            ->get();

        return response()->json($services);
    }
}
