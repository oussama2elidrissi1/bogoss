<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $query = Promotion::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'discount' => 'required|numeric',
            'type' => 'required|in:percentage,fixed',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'applicable_services' => 'nullable|array',
            'code' => 'required|string|unique:promotions',
            'status' => 'sometimes|string',
        ]);

        $promotion = Promotion::create($validated);

        return response()->json($promotion, 201);
    }

    public function show(Promotion $promotion)
    {
        return response()->json($promotion);
    }

    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'discount' => 'sometimes|numeric',
            'type' => 'sometimes|in:percentage,fixed',
            'valid_from' => 'sometimes|date',
            'valid_until' => 'sometimes|date|after:valid_from',
            'applicable_services' => 'nullable|array',
            'code' => 'sometimes|string|unique:promotions,code,' . $promotion->id,
            'status' => 'sometimes|string',
        ]);

        $promotion->update($validated);

        return response()->json($promotion);
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return response()->json(['message' => 'Promotion deleted successfully']);
    }
}
