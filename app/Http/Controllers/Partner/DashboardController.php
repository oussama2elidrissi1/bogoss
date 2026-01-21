<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'partner']);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $partner = $user->partners()->first();

        if (!$partner) {
            return redirect()->route('login')->with('error', 'Partner account not linked.');
        }

        $start = $request->get('from');
        $end = $request->get('to');

        $bookingsQuery = Booking::where('partner_id', $partner->id)->orderBy('date', 'desc');
        if ($start) {
            $bookingsQuery->whereDate('date', '>=', $start);
        }
        if ($end) {
            $bookingsQuery->whereDate('date', '<=', $end);
        }

        $bookings = $bookingsQuery->get();

        $totalCommission = $bookings->sum('commission_amount');
        $totalBookings = $bookings->count();

        return view('partner.dashboard', [
            'partner' => $partner,
            'bookings' => $bookings,
            'totalCommission' => $totalCommission,
            'totalBookings' => $totalBookings,
            'from' => $start,
            'to' => $end,
        ]);
    }

    public function createBooking()
    {
        $user = Auth::user();
        $partner = $user->partners()->first();
        $services = Service::where('available', true)->orderBy('name')->get();
        $staff = Staff::orderBy('name')->get();

        return view('partner.bookings-create', compact('partner', 'services', 'staff'));
    }

    public function storeBooking(Request $request)
    {
        $user = Auth::user();
        $partner = $user->partners()->first();

        if (!$partner) {
            return redirect()->route('partner.dashboard')->with('error', 'Partner account not linked.');
        }

        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'nullable|email',
            'client_phone' => 'nullable|string',
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'nullable|exists:staff,id',
            'date' => 'required|date',
            'time' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $service = Service::find($validated['service_id']);
        $staffMember = $validated['staff_id'] ? Staff::find($validated['staff_id']) : null;

        $client = Client::firstOrCreate(
            ['email' => $validated['client_email'] ?: 'partner-client-'.uniqid().'@example.com'],
            [
                'name' => $validated['client_name'],
                'phone' => $validated['client_phone'] ?? 'N/A',
                'join_date' => now()->toDateString(),
            ]
        );

        $commissionRate = $partner->commission_rate;
        $commissionAmount = round(($service->price * $commissionRate) / 100, 2);
        $staffPayoutPercent = 0;
        $staffPayoutAmount = 0;
        if ($staffMember) {
            $staffPayoutPercent = $service->staff()
                ->where('staff_id', $staffMember->id)
                ->first()
                ?->pivot
                ?->payout_percentage ?? 0;
            $staffPayoutAmount = round(($service->price * $staffPayoutPercent) / 100, 2);
        }

        Booking::create([
            'client_id' => $client->id,
            'client_name' => $client->name,
            'service_id' => $service->id,
            'service' => $service->name,
            'staff_id' => $staffMember?->id,
            'staff_name' => $staffMember?->name,
            'date' => $validated['date'],
            'time' => $validated['time'],
            'duration' => $service->duration,
            'price' => $service->price,
            'status' => 'pending',
            'notes' => $validated['notes'],
            'partner_id' => $partner->id,
            'partner_name' => $partner->name,
            'commission_rate' => $commissionRate,
            'commission_amount' => $commissionAmount,
            'staff_payout_percentage' => $staffPayoutPercent,
            'staff_payout_amount' => $staffPayoutAmount,
        ]);

        return redirect()->route('partner.dashboard')->with('success', 'Booking created successfully.');
    }
}
