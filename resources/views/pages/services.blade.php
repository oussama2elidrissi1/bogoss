@extends('layouts.app')

@section('title', 'Services - Bogos Land Wellness')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="font-serif text-5xl font-bold mb-4">Our Services</h1>
                <p class="text-xl max-w-2xl mx-auto">Explore our comprehensive range of wellness and beauty treatments</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <form method="GET" class="mb-8">
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="relative flex-1">
                    <input
                        type="text"
                        name="q"
                        placeholder="Search services..."
                        value="{{ $searchQuery }}"
                        class="input-field pl-10"
                    />
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">🔍</span>
                </div>
                <input type="hidden" name="category" value="{{ $selectedCategory }}">
                <button type="submit" class="btn-primary">Search</button>
            </div>
        </form>

        <div class="flex flex-wrap gap-3 mb-8">
            <a href="{{ route('services', ['category' => 'All', 'q' => $searchQuery]) }}" class="px-6 py-2 rounded-full font-medium transition-all duration-300 {{ $selectedCategory === 'All' ? 'bg-primary text-white shadow-lg scale-105' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">All</a>
            @foreach($categories as $category)
                <a href="{{ route('services', ['category' => $category, 'q' => $searchQuery]) }}" class="px-6 py-2 rounded-full font-medium transition-all duration-300 {{ $selectedCategory === $category ? 'bg-primary text-white shadow-lg scale-105' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">{{ $category }}</a>
            @endforeach
        </div>

        @if($services->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($services as $service)
                    <div class="glass-card overflow-hidden">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $service->image ?? 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400' }}" alt="{{ $service->name }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                            <div class="absolute top-3 right-3">
                                <span class="badge badge-primary">{{ $service->category }}</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-serif text-xl font-bold text-gray-900 mb-2">{{ $service->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $service->description }}</p>
                            <div class="flex items-center justify-between mb-4 text-sm text-gray-700">
                                <span>⏱️ {{ $service->duration }} min</span>
                                <span class="text-primary font-bold">${{ $service->price }}</span>
                            </div>
                            <a href="{{ route('booking', ['service_id' => $service->id]) }}" class="w-full btn-primary inline-block text-center {{ $service->available ? '' : 'opacity-50 pointer-events-none' }}">
                                {{ $service->available ? 'Book Now' : 'Unavailable' }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">🔍</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No services found</h3>
                <p class="text-gray-600">Try adjusting your search or filter criteria</p>
            </div>
        @endif
    </section>
</div>
@endsection
