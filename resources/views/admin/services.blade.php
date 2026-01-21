@extends('layouts.app')

@section('title', 'Services - Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-4xl font-bold mb-2 text-white">Service Management</h1>
            <p class="text-xl text-white/90">Manage your service catalog</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6 mb-6">
            <form method="GET" action="{{ route('admin.services.index') }}" class="flex gap-4 mb-4">
                <input type="text" name="search" placeholder="Search services..." value="{{ request('search') }}" class="input-field flex-1">
                <select name="category" class="input-field">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary">Search</button>
                <a href="{{ route('admin.services.create') }}" class="btn-secondary">Add Service</a>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($services as $service)
            <div class="glass-card overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-serif text-xl font-bold text-gray-900">{{ $service->name }}</h3>
                            <span class="badge badge-primary">{{ $service->category }}</span>
                        </div>
                        <span class="badge {{ $service->available ? 'badge-success' : 'badge-error' }}">
                            {{ $service->available ? 'Available' : 'Unavailable' }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">{{ $service->description }}</p>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-600">⏱️ {{ $service->duration }} min</span>
                        <span class="text-2xl font-bold text-primary">${{ $service->price }}</span>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn-primary flex-1 text-center text-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Are you sure?')" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-secondary bg-danger w-full text-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">No services found</p>
            </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $services->links() }}
        </div>
    </section>
</div>
@endsection
