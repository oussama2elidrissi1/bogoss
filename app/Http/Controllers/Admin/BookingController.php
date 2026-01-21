<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = Booking::with(['client', 'service', 'staff']);

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('date') && $request->date !== '') {
            $query->whereDate('date', $request->date);
        }

        $bookings = $query->orderBy('date', 'desc')->paginate(15);
        $clients = Client::all();
        $services = Service::all();
        $staff = Staff::with('services')->get();

        $agendaStart = Carbon::parse($request->get('agenda_start', now()->toDateString()));
        $agendaEnd = $agendaStart->copy()->addDays(6);
        $agendaStatus = $request->get('status', '');

        $agendaQuery = Booking::query()
            ->whereBetween('date', [$agendaStart->toDateString(), $agendaEnd->toDateString()]);

        if ($agendaStatus !== '') {
            $agendaQuery->where('status', $agendaStatus);
        }

        $agendaBookings = $agendaQuery
            ->orderBy('date')
            ->orderBy('time')
            ->get()
            ->groupBy(fn (Booking $booking) => $booking->date->toDateString());

        $agendaDays = collect(range(0, 6))->map(function ($offset) use ($agendaStart, $agendaBookings) {
            $date = $agendaStart->copy()->addDays($offset);
            $key = $date->toDateString();
            return [
                'date' => $date,
                'bookings' => $agendaBookings->get($key, collect()),
            ];
        });

        $agendaPrev = $agendaStart->copy()->subDays(7)->toDateString();
        $agendaNext = $agendaStart->copy()->addDays(7)->toDateString();

        return view('admin.bookings', compact(
            'bookings',
            'clients',
            'services',
            'staff',
            'agendaDays',
            'agendaStart',
            'agendaEnd',
            'agendaPrev',
            'agendaNext'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'nullable|exists:staff,id',
            'date' => 'required|date',
            'time' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $service = Service::find($validated['service_id']);
        $client = Client::find($validated['client_id']);

        $validated['client_name'] = $client->name;
        $validated['service'] = $service->name;
        $validated['duration'] = $service->duration;
        $validated['price'] = $service->price;
        $validated['status'] = 'confirmed';

        if (!empty($validated['staff_id'])) {
            $staff = Staff::find($validated['staff_id']);
            $validated['staff_name'] = $staff->name;
            $payout = $service->staff()
                ->where('staff_id', $staff->id)
                ->first()
                ?->pivot
                ?->payout_percentage;
            $validated['staff_payout_percentage'] = $payout ?? 0;
            $validated['staff_payout_amount'] = round(($service->price * ($validated['staff_payout_percentage'] ?? 0)) / 100, 2);
        } else {
            $validated['staff_payout_percentage'] = null;
            $validated['staff_payout_amount'] = null;
        }

        Booking::create($validated);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully');
    }

    public function create()
    {
        $clients = Client::all();
        $services = Service::all();
        $staff = Staff::with('services')->get();

        return view('admin.bookings-create', compact('clients', 'services', 'staff'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'client_id' => 'sometimes|exists:clients,id',
            'service_id' => 'sometimes|exists:services,id',
            'status' => 'sometimes|string',
            'date' => 'sometimes|date',
            'time' => 'sometimes|string',
            'staff_id' => 'nullable|exists:staff,id',
            'notes' => 'nullable|string',
        ]);

        if (isset($validated['staff_id'])) {
            $staff = $validated['staff_id'] ? Staff::find($validated['staff_id']) : null;
            $validated['staff_name'] = $staff?->name;
        }

        if ($request->filled('client_id')) {
            $client = Client::find($request->client_id);
            if ($client) {
                $validated['client_id'] = $client->id;
                $validated['client_name'] = $client->name;
            }
        }

        if ($request->filled('service_id')) {
            $service = Service::find($request->service_id);
            if ($service) {
                $validated['service_id'] = $service->id;
                $validated['service'] = $service->name;
                $validated['duration'] = $service->duration;
                $validated['price'] = $service->price;
            }
        }

        if (isset($validated['staff_id']) || isset($validated['service_id'])) {
            $staff = $booking->staff;
            $service = $booking->service;
            if (isset($validated['staff_id'])) {
                $staff = $validated['staff_id'] ? Staff::find($validated['staff_id']) : null;
            }
            if (isset($validated['service_id'])) {
                $service = Service::find($validated['service_id']);
            }
            if ($staff && $service) {
                $payout = $service->staff()
                    ->where('staff_id', $staff->id)
                    ->first()
                    ?->pivot
                    ?->payout_percentage;
                $validated['staff_payout_percentage'] = $payout ?? 0;
                $validated['staff_payout_amount'] = round(($service->price * ($validated['staff_payout_percentage'] ?? 0)) / 100, 2);
            } else {
                $validated['staff_payout_percentage'] = null;
                $validated['staff_payout_amount'] = null;
            }
        }

        $booking->update($validated);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully');
    }

    public function edit(Booking $booking)
    {
        $clients = Client::all();
        $services = Service::all();
        $staff = Staff::all();

        return view('admin.bookings-edit', compact('booking', 'clients', 'services', 'staff'));
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully');
    }
}
