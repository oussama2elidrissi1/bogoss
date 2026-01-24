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
        // Charger les bookings avec leurs items et relations
        $query = Booking::with(['client', 'items.service', 'items.staff']);

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

        $agendaQuery = Booking::with(['items.service', 'items.staff'])
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

        $nonAgendaQuery = Booking::with(['items.service', 'items.staff'])
            ->whereNotBetween('date', [$agendaStart->toDateString(), $agendaEnd->toDateString()]);

        if ($request->has('status') && $request->status !== '') {
            $nonAgendaQuery->where('status', $request->status);
        }

        if ($request->has('date') && $request->date !== '') {
            $nonAgendaQuery->whereDate('date', $request->date);
        }

        $nonAgendaBookings = $nonAgendaQuery->orderBy('date', 'desc')->paginate(15);

        return view('admin.bookings', compact(
            'bookings',
            'nonAgendaBookings',
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
        // TODO: Adapter pour la nouvelle architecture avec BookingService
        return redirect()->route('admin.bookings.index')
            ->with('error', 'La création de réservations depuis l\'admin doit être mise à jour pour la nouvelle architecture.');
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
        // Seul le statut peut être mis à jour pour l'instant
        $validated = $request->validate([
            'status' => 'sometimes|string|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string',
        ]);

        $booking->update($validated);

        return redirect()->route('admin.bookings.index')->with('success', 'Statut de la réservation mis à jour');
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
