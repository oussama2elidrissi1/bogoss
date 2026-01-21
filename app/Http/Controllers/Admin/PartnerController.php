<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PartnerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = Partner::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        $partners = $query->orderBy('name')->paginate(15);

        return view('admin.partners', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'commission_rate' => 'required|numeric|min:0',
            'active' => 'boolean',
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users,email',
            'user_password' => 'required|string|min:6',
        ]);

        $partner = Partner::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'contact_name' => $validated['contact_name'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'],
            'commission_rate' => $validated['commission_rate'],
            'active' => (bool) ($validated['active'] ?? true),
        ]);

        $user = User::create([
            'name' => $validated['user_name'],
            'email' => $validated['user_email'],
            'password' => Hash::make($validated['user_password']),
            'role' => 'partner',
            'is_admin' => false,
        ]);

        $partner->users()->attach($user->id);

        return redirect()->route('admin.partners.index')->with('success', 'Partner created successfully');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners-edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'commission_rate' => 'required|numeric|min:0',
            'active' => 'boolean',
        ]);

        $partner->update($validated);

        return redirect()->route('admin.partners.index')->with('success', 'Partner updated successfully');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner deleted successfully');
    }
}
