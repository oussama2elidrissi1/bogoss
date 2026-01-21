<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        return response()->json(Subscription::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration' => 'required|string',
            'benefits' => 'required|array',
            'color' => 'nullable|string',
            'popular' => 'boolean',
        ]);

        $subscription = Subscription::create($validated);

        return response()->json($subscription, 201);
    }

    public function show(Subscription $subscription)
    {
        return response()->json($subscription);
    }

    public function update(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric',
            'duration' => 'sometimes|string',
            'benefits' => 'sometimes|array',
            'color' => 'nullable|string',
            'popular' => 'boolean',
        ]);

        $subscription->update($validated);

        return response()->json($subscription);
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return response()->json(['message' => 'Subscription deleted successfully']);
    }
}
