@extends('layouts.app')

@section('title', 'Partners - Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-white">
                <h1 class="font-serif text-4xl font-bold mb-2">Partners</h1>
                <p class="text-xl">Manage partner accounts and commissions</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between mb-6">
            <form method="GET" class="flex gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search partners..." class="input-field">
                <button class="btn-primary">Search</button>
            </form>
            <a href="{{ route('admin.partners.create') }}" class="btn-secondary">Add Partner</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($partners as $partner)
                <div class="glass-card p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-serif text-xl font-bold">{{ $partner->name }}</h3>
                        <span class="badge {{ $partner->active ? 'badge-success' : 'badge-error' }}">{{ $partner->active ? 'Active' : 'Inactive' }}</span>
                    </div>
                    <p class="text-sm text-gray-600">Type: {{ $partner->type }}</p>
                    <p class="text-sm text-gray-600">Commission: {{ $partner->commission_rate }}%</p>
                    <p class="text-sm text-gray-600">Contact: {{ $partner->contact_name ?? 'N/A' }}</p>
                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('admin.partners.edit', $partner) }}" class="btn-primary text-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}" onsubmit="return confirm('Delete this partner?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn-secondary text-sm">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No partners found.</p>
            @endforelse
        </div>

        <div class="mt-6">{{ $partners->links() }}</div>
    </section>
</div>
@endsection
