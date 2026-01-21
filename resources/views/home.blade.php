@extends('layouts.app')

@section('title', 'Home - Bogos Land Wellness')

@section('content')
<div class="min-h-screen">
    <section class="relative h-[600px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 gradient-wellness opacity-90"></div>
        <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=1920')"></div>
        <div class="relative z-10 text-center text-white px-4 max-w-4xl">
            <h1 class="font-serif text-5xl md:text-6xl font-bold mb-6 text-shadow-lg">Welcome to Bogos Land</h1>
            <p class="text-xl md:text-2xl mb-8 text-shadow">Your Sanctuary for Wellness, Beauty & Relaxation</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('booking') }}" class="btn-primary text-lg px-8 py-4">Book Appointment</a>
                <a href="{{ route('services') }}" class="btn-outline text-lg px-8 py-4">Explore Services</a>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h2 class="font-serif text-4xl font-bold text-gray-900 mb-4">Why Choose Bogos Land?</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Experience the perfect blend of traditional wellness practices and modern luxury</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            <div class="glass-card p-6 text-center">
                <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-2xl">✨</span>
                </div>
                <h3 class="font-serif text-xl font-bold text-gray-900 mb-2">Premium Services</h3>
                <p class="text-gray-600 text-sm">Experience luxury wellness treatments with traditional techniques</p>
            </div>
            <div class="glass-card p-6 text-center">
                <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-2xl">👥</span>
                </div>
                <h3 class="font-serif text-xl font-bold text-gray-900 mb-2">Expert Staff</h3>
                <p class="text-gray-600 text-sm">Certified professionals dedicated to your wellbeing</p>
            </div>
            <div class="glass-card p-6 text-center">
                <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-2xl">🏆</span>
                </div>
                <h3 class="font-serif text-xl font-bold text-gray-900 mb-2">Quality Products</h3>
                <p class="text-gray-600 text-sm">Only the finest organic and natural products</p>
            </div>
            <div class="glass-card p-6 text-center">
                <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-2xl">⏰</span>
                </div>
                <h3 class="font-serif text-xl font-bold text-gray-900 mb-2">Flexible Hours</h3>
                <p class="text-gray-600 text-sm">Open 7 days a week to fit your schedule</p>
            </div>
        </div>
    </section>

    <section class="bg-gradient-to-b from-white to-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="font-serif text-4xl font-bold text-gray-900 mb-4">Featured Services</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Discover our most popular wellness and beauty treatments</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($services ?? [] as $service)
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
                        <a href="{{ route('booking', ['service_id' => $service->id]) }}" class="w-full btn-primary inline-block text-center">Book Now</a>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500">No services available at the moment.</p>
                </div>
                @endforelse
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('services') }}" class="btn-primary text-lg px-8 py-4">View All Services</a>
            </div>
        </div>
    </section>

    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h2 class="font-serif text-4xl font-bold mb-6">Ready to Begin Your Wellness Journey?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Join our community and experience the transformative power of holistic wellness</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('subscriptions') }}" class="btn-accent text-lg px-8 py-4">View Membership Plans</a>
                <a href="{{ route('booking') }}" class="bg-white text-primary hover:bg-gray-100 px-8 py-4 rounded-lg font-medium text-lg transition-all duration-300">Book Your First Session</a>
            </div>
        </div>
    </section>
</div>
@endsection
