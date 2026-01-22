<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = Inventory::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $inventory = $query->paginate(12);
        $categories = Inventory::distinct()->pluck('category');

        return view('admin.inventory', compact('inventory', 'categories'));
    }

    public function create()
    {
        return view('admin.inventory-create');
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

        Inventory::create($validated);

        return redirect()->route('admin.inventory.index')->with('success', 'Inventory item created successfully');
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
        ]);

        if (isset($validated['quantity']) && isset($validated['min_quantity'])) {
            $validated['status'] = $validated['quantity'] <= $validated['min_quantity'] ? 'low-stock' : 'in-stock';
        }

        $inventory->update($validated);

        return redirect()->route('admin.inventory.index')->with('success', 'Inventory item updated successfully');
    }

    public function edit(Inventory $inventory)
    {
        return view('admin.inventory-edit', compact('inventory'));
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('admin.inventory.index')->with('success', 'Inventory item deleted successfully');
    }
}
