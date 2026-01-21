<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = Staff::query();

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('role', 'like', '%' . $request->search . '%');
            });
        }

        $staff = $query->paginate(12);

        return view('admin.staff', compact('staff'));
    }

    public function create()
    {
        $services = Service::orderBy('name')->get();
        return view('admin.staff-create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string',
            'specialties' => 'required',
            'email' => 'required|email|unique:staff',
            'phone' => 'required|string',
            'availability' => 'required',
        ]);

        $validated['specialties'] = array_map('trim', explode(',', $validated['specialties']));
        $validated['availability'] = array_map('trim', explode(',', $validated['availability']));
        $validated['join_date'] = now();
        $validated['rating'] = 0;
        $validated['completed_services'] = 0;

        $staff = Staff::create($validated);
        $payouts = $this->extractPayouts($request);
        if (!empty($payouts)) {
            $staff->services()->sync($payouts);
        }

        return redirect()->route('admin.staff.index')->with('success', 'Staff member created successfully');
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'role' => 'sometimes|string',
            'specialties' => 'sometimes',
            'email' => 'sometimes|email|unique:staff,email,' . $staff->id,
            'phone' => 'sometimes|string',
            'availability' => 'sometimes',
        ]);

        if (isset($validated['specialties'])) {
            $validated['specialties'] = array_map('trim', explode(',', $validated['specialties']));
        }
        if (isset($validated['availability'])) {
            $validated['availability'] = array_map('trim', explode(',', $validated['availability']));
        }
        $staff->update($validated);
        $payouts = $this->extractPayouts($request);
        $staff->services()->sync($payouts);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member updated successfully');
    }

    public function edit(Staff $staff)
    {
        $services = Service::orderBy('name')->get();
        return view('admin.staff-edit', compact('staff', 'services'));
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Staff member deleted successfully');
    }

    private function extractPayouts(Request $request): array
    {
        $payouts = [];
        foreach ($request->input('payout_percentages', []) as $serviceId => $percent) {
            if ($percent === '' || $percent === null) {
                continue;
            }
            $payouts[$serviceId] = ['payout_percentage' => (float) $percent];
        }

        return $payouts;
    }
}
