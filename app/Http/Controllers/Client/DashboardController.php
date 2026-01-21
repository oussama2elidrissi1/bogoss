<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bookings = collect();

        $client = null;

        if ($user) {
            $client = Client::where('email', $user->email)->first();
            if ($client) {
                $bookings = Booking::where('client_id', $client->id)
                    ->orderBy('date', 'desc')
                    ->get();
            }
        }

        return view('client.dashboard', compact('bookings', 'user', 'client'));
    }
}
