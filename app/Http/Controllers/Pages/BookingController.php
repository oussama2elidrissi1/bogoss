<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category', 'All');
        $serviceId = $request->get('service_id');
        $date = $request->get('date', now()->toDateString());

        $selectedDate = Carbon::parse($date);

        $servicesQuery = Service::query()->where('available', true);
        if ($category !== 'All') {
            $servicesQuery->where('category', $category);
        }

        $services = $servicesQuery->orderBy('name')->get();
        $categories = Service::query()->select('category')->distinct()->orderBy('category')->pluck('category');

        $selectedService = null;
        if ($serviceId) {
            $selectedService = Service::where('available', true)->find($serviceId);
        }

        $dateBookings = Booking::whereDate('date', $selectedDate)->orderBy('time')->get();

        $dayName = $selectedDate->format('l');
        $availableStaff = Staff::all()->filter(function ($staff) use ($dayName) {
            $availability = is_array($staff->availability) ? $staff->availability : json_decode($staff->availability ?? '[]', true);
            return in_array($dayName, $availability ?? [], true);
        });

        $timeSlots = [
            '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
            '12:00', '12:30', '14:00', '14:30', '15:00', '15:30',
            '16:00', '16:30', '17:00', '17:30', '18:00', '18:30',
        ];

        return view('pages.booking', [
            'services' => $services,
            'categories' => $categories,
            'selectedCategory' => $category,
            'selectedService' => $selectedService,
            'selectedDate' => $selectedDate,
            'dateBookings' => $dateBookings,
            'availableStaff' => $availableStaff,
            'timeSlots' => $timeSlots,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => ['nullable', 'exists:services,id'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['exists:services,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required'],
            'staff_id' => ['nullable', 'exists:staff,id'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $serviceIds = $request->input('service_ids', []);
        if (empty($serviceIds) && $request->filled('service_id')) {
            $serviceIds = [$request->service_id];
        }
        if (empty($serviceIds)) {
            return back()->withErrors(['service_ids' => 'Please select at least one service.']);
        }

        $services = Service::whereIn('id', $serviceIds)->get();
        if ($services->count() !== count($serviceIds)) {
            return back()->withErrors(['service_ids' => 'Some selected services are invalid.']);
        }

        $staff = $request->staff_id ? Staff::find($request->staff_id) : null;
        $user = Auth::user();
        $client = Client::firstOrCreate(
            ['email' => $user->email],
            [
                'name' => $user->name,
                'phone' => $user->phone ?? 'N/A',
                'join_date' => now()->toDateString(),
            ]
        );

        foreach ($services as $service) {
            $staffPayoutPercent = 0;
            $staffPayoutAmount = 0;
            if ($staff) {
                $staffPayoutPercent = $service->staff()
                    ->where('staff_id', $staff->id)
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
                'staff_id' => $staff?->id,
                'staff_name' => $staff?->name,
                'date' => $request->date,
                'time' => $request->time,
                'duration' => $service->duration,
                'price' => $service->price,
                'status' => 'pending',
                'notes' => $request->notes,
                'staff_payout_percentage' => $staffPayoutPercent,
                'staff_payout_amount' => $staffPayoutAmount,
            ]);
        }

        return redirect()->route('booking', [
            'date' => $request->date,
        ])->with('success', 'Booking request submitted successfully.');
    }
}
