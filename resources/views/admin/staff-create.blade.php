@extends('layouts.app')

@section('title', 'Add Staff - Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6">
            <h1 class="font-serif text-3xl font-bold mb-6">Add Staff</h1>
            <form method="POST" action="{{ route('admin.staff.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                    <input type="text" name="name" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <input type="text" name="role" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Specialties (comma separated)</label>
                    <input type="text" name="specialties" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                    <input type="text" name="phone" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Availability (comma separated days)</label>
                    <input type="text" name="availability" class="input-field" required>
                </div>
                <div class="pt-2 border-t border-gray-200">
                    <h2 class="text-sm font-semibold text-gray-800 mb-2">Service Payout Percentages</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($services as $service)
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">{{ $service->name }}</label>
                                <div class="flex items-center gap-2">
                                    <input
                                        type="number"
                                        name="payout_percentages[{{ $service->id }}]"
                                        class="input-field"
                                        min="0"
                                        max="100"
                                        step="0.01"
                                        placeholder="0"
                                    >
                                    <span class="text-xs text-gray-500">%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn-primary">Save</button>
                    <a href="{{ route('admin.staff.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
