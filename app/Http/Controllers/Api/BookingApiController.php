<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\ServiceResource;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Service;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingApiController extends Controller
{
    public function __construct(
        private BookingService $bookingService
    ) {}

    /**
     * GET /api/services
     * Récupérer tous les services avec leurs options
     */
    public function getServices(Request $request)
    {
        $query = Service::with('availableOptions')
            ->where('available', true);

        // Filtrer par catégorie
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $services = $query->orderBy('category')->orderBy('name')->get();

        return ServiceResource::collection($services);
    }

    /**
     * GET /api/services/{id}
     * Récupérer un service avec ses options
     */
    public function getService($id)
    {
        $service = Service::with('availableOptions')->findOrFail($id);

        if (!$service->available) {
            return response()->json([
                'message' => 'Ce service n\'est pas disponible actuellement.',
            ], 404);
        }

        return new ServiceResource($service);
    }

    /**
     * POST /api/bookings/calculate
     * Calculer les totaux d'un panier sans créer la réservation
     */
    public function calculateCart(Request $request)
    {
        $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.service_id' => ['required', 'exists:services,id'],
            'items.*.quantity' => ['nullable', 'integer', 'min:1'],
            'items.*.options' => ['nullable', 'array'],
            'items.*.options.*.option_id' => ['required', 'exists:service_options,id'],
            'items.*.options.*.quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        try {
            $totals = $this->bookingService->calculateCartTotals($request->items);

            return response()->json([
                'success' => true,
                'data' => $totals,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * POST /api/bookings
     * Créer une nouvelle réservation
     */
    public function store(StoreBookingRequest $request)
    {
        try {
            // Récupérer ou créer le client
            $user = Auth::user();
            $client = Client::firstOrCreate(
                ['email' => $user->email],
                [
                    'name' => $user->name,
                    'phone' => $user->phone ?? 'N/A',
                    'join_date' => now()->toDateString(),
                ]
            );

            // Créer la réservation
            $booking = $this->bookingService->createBooking(
                $request->validated(),
                $client
            );

            return response()->json([
                'success' => true,
                'message' => 'Réservation créée avec succès.',
                'data' => new BookingResource($booking),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la réservation: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * GET /api/bookings/{id}
     * Récupérer une réservation par ID ou référence
     */
    public function show($id)
    {
        $booking = Booking::with(['items.options', 'items.service', 'items.staff', 'client'])
            ->where(function ($query) use ($id) {
                $query->where('id', $id)
                      ->orWhere('booking_reference', $id);
            })
            ->firstOrFail();

        // Vérifier que l'utilisateur a accès à cette réservation
        $user = Auth::user();
        if ($booking->client->email !== $user->email) {
            return response()->json([
                'message' => 'Non autorisé.',
            ], 403);
        }

        return new BookingResource($booking);
    }

    /**
     * GET /api/bookings
     * Récupérer les réservations du client connecté
     */
    public function index()
    {
        $user = Auth::user();
        $client = Client::where('email', $user->email)->first();

        if (!$client) {
            return response()->json([
                'success' => true,
                'data' => [],
            ]);
        }

        $bookings = Booking::with(['items.options', 'items.service', 'items.staff'])
            ->where('client_id', $client->id)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(10);

        return BookingResource::collection($bookings);
    }
}
