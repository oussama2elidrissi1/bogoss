<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::query();

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('role', 'like', '%' . $request->search . '%');
            });
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string',
            'specialties' => 'required|array',
            'email' => 'required|email|unique:staff',
            'phone' => 'required|string',
            'availability' => 'required|array',
            'image' => 'nullable|string',
        ]);

        $validated['join_date'] = now();
        $validated['rating'] = 0;
        $validated['completed_services'] = 0;

        $staff = Staff::create($validated);

        return response()->json($staff, 201);
    }

    public function show(Staff $staff)
    {
        return response()->json($staff);
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'role' => 'sometimes|string',
            'specialties' => 'sometimes|array',
            'email' => 'sometimes|email|unique:staff,email,' . $staff->id,
            'phone' => 'sometimes|string',
            'availability' => 'sometimes|array',
            'rating' => 'sometimes|numeric',
            'completed_services' => 'sometimes|integer',
            'image' => 'nullable|string',
        ]);

        $staff->update($validated);

        return response()->json($staff);
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();

        return response()->json(['message' => 'Staff member deleted successfully']);
    }
}
