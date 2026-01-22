@extends('layouts.app')

@section('title', 'Clients - Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-4xl font-bold mb-2 text-white">Client Management</h1>
            <p class="text-xl text-white/90">Manage your client database</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6 mb-6">
            <form method="GET" action="{{ route('admin.clients.index') }}" class="flex gap-4">
                <input type="text" name="search" placeholder="Search clients..." value="{{ request('search') }}" class="input-field flex-1">
                <button type="submit" class="btn-primary">Search</button>
                <a href="{{ route('admin.clients.create') }}" class="btn-secondary">Add Client</a>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse($clients as $client)
            <div class="glass-card p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-serif text-xl font-bold text-gray-900">{{ $client->name }}</h3>
                        @if($client->subscription)
                            <span class="badge badge-primary">{{ $client->subscription }}</span>
                        @endif
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.clients.edit', $client) }}" class="btn-primary text-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-secondary bg-danger text-sm">Delete</button>
                        </form>
                    </div>
                </div>
                <div class="space-y-2 text-sm text-gray-600">
                    <p>📧 {{ $client->email }}</p>
                    <p>📞 {{ $client->phone }}</p>
                    <p>📅 Joined {{ $client->join_date->format('M d, Y') }}</p>
                </div>
                <div class="grid grid-cols-3 gap-4 pt-4 border-t border-gray-200 mt-4">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-primary">{{ $client->visits }}</p>
                        <p class="text-xs text-gray-600">Visits</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-secondary">MAD {{ $client->total_spent }}</p>
                        <p class="text-xs text-gray-600">Spent</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm font-medium">{{ $client->last_visit ? $client->last_visit->format('M d') : 'N/A' }}</p>
                        <p class="text-xs text-gray-600">Last Visit</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-2 text-center py-12">
                <p class="text-gray-500">No clients found</p>
            </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $clients->links() }}
        </div>
    </section>
</div>
@endsection

