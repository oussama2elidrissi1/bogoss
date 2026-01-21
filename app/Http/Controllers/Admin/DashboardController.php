<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Inventory;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $totalRevenue = Booking::sum('price');
        $totalBookings = Booking::count();
        $totalClients = Client::count();
        $totalServices = Service::count();
        $lowStockItems = Inventory::where('status', 'low-stock')
            ->orWhere('status', 'critical')
            ->count();

        $recentBookings = Booking::with(['client', 'service', 'staff'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalBookings',
            'totalClients',
            'totalServices',
            'lowStockItems',
            'recentBookings'
        ));
    }
}
