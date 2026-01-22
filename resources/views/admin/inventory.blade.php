@extends('layouts.app')

@section('title', 'Inventory - Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-4xl font-bold mb-2 text-white">Inventory Management</h1>
            <p class="text-xl text-white/90">Track and manage your supplies</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6 mb-6">
            <form method="GET" action="{{ route('admin.inventory.index') }}" class="flex gap-4">
                <select name="category" class="input-field">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                <select name="status" class="input-field">
                    <option value="">All Status</option>
                    <option value="in-stock" {{ request('status') == 'in-stock' ? 'selected' : '' }}>In Stock</option>
                    <option value="low-stock" {{ request('status') == 'low-stock' ? 'selected' : '' }}>Low Stock</option>
                    <option value="critical" {{ request('status') == 'critical' ? 'selected' : '' }}>Critical</option>
                </select>
                <button type="submit" class="btn-primary">Filter</button>
                <a href="{{ route('admin.inventory.create') }}" class="btn-secondary">Add Item</a>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($inventory as $item)
            <div class="glass-card p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-serif text-xl font-bold text-gray-900">{{ $item->name }}</h3>
                        <span class="badge badge-primary">{{ $item->category }}</span>
                    </div>
                    <span class="badge {{ $item->status === 'in-stock' ? 'badge-success' : ($item->status === 'low-stock' ? 'badge-warning' : 'badge-error') }}">
                        {{ ucfirst(str_replace('-', ' ', $item->status)) }}
                    </span>
                </div>
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Current Stock</span>
                        <span class="text-2xl font-bold {{ $item->quantity <= $item->min_quantity ? 'text-danger' : 'text-gray-900' }}">
                            {{ $item->quantity }} {{ $item->unit }}
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full {{ $item->quantity <= $item->min_quantity * 0.5 ? 'bg-danger' : ($item->quantity <= $item->min_quantity ? 'bg-warning' : 'bg-success') }}" 
                             style="width: {{ min(($item->quantity / ($item->min_quantity * 2)) * 100, 100) }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Min: {{ $item->min_quantity }}</span>
                        <span>Target: {{ $item->min_quantity * 2 }}</span>
                    </div>
                </div>
                <div class="space-y-2 text-sm mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Unit Price</span>
                        <span class="font-medium">MAD {{ $item->price }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Supplier</span>
                        <span class="font-medium">{{ $item->supplier }}</span>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.inventory.edit', $item) }}" class="btn-primary flex-1 text-center text-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.inventory.destroy', $item) }}" onsubmit="return confirm('Are you sure?')" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-secondary bg-danger w-full text-sm">Delete</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">No inventory items found</p>
            </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $inventory->links() }}
        </div>
    </section>
</div>
@endsection

