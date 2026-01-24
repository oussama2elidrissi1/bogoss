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
        // Utiliser 'total' au lieu de 'price' (nouvelle structure)
        $totalRevenue = Booking::sum('total');
        $totalBookings = Booking::count();
        $totalClients = Client::count();
        $totalServices = Service::count();
        $lowStockItems = Inventory::where('status', 'low-stock')
            ->orWhere('status', 'critical')
            ->count();

        // Les bookings n'ont plus de relation directe avec service et staff
        // Ils ont maintenant des items
        $recentBookings = Booking::with(['client', 'items.service', 'items.staff'])
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
