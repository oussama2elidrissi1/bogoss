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
                  ->orWhereJsonContains('role', $request->search);
            });
        }

        $staff = $query->paginate(12);

        return view('admin.staff', compact('staff'));
    }

    public function create()
    {
        $services = Service::orderBy('name')->get();
        $serviceCategories = Service::query()->select('category')->distinct()->orderBy('category')->pluck('category');
        $roles = Staff::query()->pluck('role')->filter()->flatMap(function ($items) {
            return is_array($items) ? $items : json_decode($items ?? '[]', true);
        })->filter()->unique()->sort()->values();
        $specialties = Staff::query()->pluck('specialties')->filter()->flatMap(function ($items) {
            return is_array($items) ? $items : json_decode($items ?? '[]', true);
        })->filter()->unique()->sort()->values();

        return view('admin.staff-create', compact('services', 'serviceCategories', 'roles', 'specialties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'roles_input' => 'required|string',
            'specialties' => 'nullable|array',
            'specialties.*' => 'string|max:255',
            'specialties_input' => 'nullable|string',
            'email' => 'required|email|unique:staff',
            'phone' => 'required|string',
            'availability' => 'required',
        ]);

        $validated['role'] = $this->normalizeRoles([], $validated['roles_input'] ?? null);
        $validated['specialties'] = $this->normalizeSpecialties(
            $request->input('specialties', []),
            $validated['specialties_input'] ?? null
        );
        $validated['availability'] = array_map('trim', explode(',', $validated['availability']));
        $validated['join_date'] = now();
        $validated['rating'] = 0;
        $validated['completed_services'] = 0;
        unset($validated['roles_input'], $validated['specialties_input']);

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
            'roles_input' => 'nullable|string',
            'specialties' => 'nullable|array',
            'specialties.*' => 'string|max:255',
            'specialties_input' => 'nullable|string',
            'email' => 'sometimes|email|unique:staff,email,' . $staff->id,
            'phone' => 'sometimes|string',
            'availability' => 'sometimes',
        ]);

        if ($request->filled('roles_input')) {
            $validated['role'] = $this->normalizeRoles([], $validated['roles_input'] ?? null);
        }
        if ($request->has('specialties') || $request->filled('specialties_input')) {
            $validated['specialties'] = $this->normalizeSpecialties(
                $request->input('specialties', []),
                $validated['specialties_input'] ?? null
            );
        }
        if (isset($validated['availability'])) {
            $validated['availability'] = array_map('trim', explode(',', $validated['availability']));
        }
        unset($validated['roles_input'], $validated['specialties_input']);
        $staff->update($validated);
        $payouts = $this->extractPayouts($request);
        $staff->services()->sync($payouts);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member updated successfully');
    }

    public function edit(Staff $staff)
    {
        $services = Service::orderBy('name')->get();
        $serviceCategories = Service::query()->select('category')->distinct()->orderBy('category')->pluck('category');
        $roles = Staff::query()->pluck('role')->filter()->flatMap(function ($items) {
            return is_array($items) ? $items : json_decode($items ?? '[]', true);
        })->filter()->unique()->sort()->values();
        $specialties = Staff::query()->pluck('specialties')->filter()->flatMap(function ($items) {
            return is_array($items) ? $items : json_decode($items ?? '[]', true);
        })->filter()->unique()->sort()->values();

        return view('admin.staff-edit', compact('staff', 'services', 'serviceCategories', 'roles', 'specialties'));
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Staff member deleted successfully');
    }

    public function history(Request $request, Staff $staff)
    {
        $date = $request->get('date', now()->toDateString());

        $bookingsQuery = $staff->bookings()
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc');

        $bookingsQuery->whereDate('date', $date);

        $bookings = $bookingsQuery->paginate(20)->withQueryString();

        $confirmedQuery = (clone $bookingsQuery)->where('status', 'confirmed');
        $totalEarnings = $confirmedQuery->sum('staff_payout_amount');
        $totalConfirmed = $confirmedQuery->count();

        return view('admin.staff-history', compact('staff', 'bookings', 'totalEarnings', 'totalConfirmed', 'date'));
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

    private function normalizeRoles(array $roles, ?string $input): array
    {
        $items = $roles;
        if ($input) {
            $fromInput = array_filter(array_map('trim', explode(',', $input)));
            $items = array_merge($items, $fromInput);
        }

        return array_values(array_unique(array_filter(array_map('trim', $items))));
    }

    private function normalizeSpecialties(array $specialties, ?string $input): array
    {
        $items = $specialties;
        if ($input) {
            $fromInput = array_filter(array_map('trim', explode(',', $input)));
            $items = array_merge($items, $fromInput);
        }

        return array_values(array_unique(array_filter(array_map('trim', $items))));
    }
}
