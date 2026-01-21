<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::query();

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'quantity' => 'required|integer',
            'min_quantity' => 'required|integer',
            'unit' => 'required|string',
            'price' => 'required|numeric',
            'supplier' => 'required|string',
        ]);

        $validated['last_restocked'] = now();
        $validated['status'] = $validated['quantity'] <= $validated['min_quantity'] ? 'low-stock' : 'in-stock';

        $inventory = Inventory::create($validated);

        return response()->json($inventory, 201);
    }

    public function show(Inventory $inventory)
    {
        return response()->json($inventory);
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'category' => 'sometimes|string',
            'quantity' => 'sometimes|integer',
            'min_quantity' => 'sometimes|integer',
            'unit' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'supplier' => 'sometimes|string',
            'last_restocked' => 'sometimes|date',
        ]);

        if (isset($validated['quantity']) && isset($validated['min_quantity'])) {
            $validated['status'] = $validated['quantity'] <= $validated['min_quantity'] ? 'low-stock' : 'in-stock';
        }

        $inventory->update($validated);

        return response()->json($inventory);
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return response()->json(['message' => 'Inventory item deleted successfully']);
    }
}
