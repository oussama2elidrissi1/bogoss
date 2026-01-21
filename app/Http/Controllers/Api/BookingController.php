<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['client', 'service', 'staff']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('client_name', 'like', '%' . $request->search . '%')
                  ->orWhere('service', 'like', '%' . $request->search . '%');
            });
        }

        return response()->json($query->get());
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

        $service = \App\Models\Service::find($validated['service_id']);
        $client = \App\Models\Client::find($validated['client_id']);

        $validated['client_name'] = $client->name;
        $validated['service'] = $service->name;
        $validated['duration'] = $service->duration;
        $validated['price'] = $service->price;
        $validated['status'] = 'confirmed';

        if ($validated['staff_id']) {
            $staff = \App\Models\Staff::find($validated['staff_id']);
            $validated['staff_name'] = $staff->name;
        }

        $booking = Booking::create($validated);

        return response()->json($booking, 201);
    }

    public function show(Booking $booking)
    {
        $booking->load(['client', 'service', 'staff']);
        return response()->json($booking);
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'sometimes|string',
            'date' => 'sometimes|date',
            'time' => 'sometimes|string',
            'staff_id' => 'nullable|exists:staff,id',
            'notes' => 'nullable|string',
        ]);

        if (isset($validated['staff_id'])) {
            $staff = \App\Models\Staff::find($validated['staff_id']);
            $validated['staff_name'] = $staff->name;
        }

        $booking->update($validated);

        return response()->json($booking);
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully']);
    }
}
