@extends('layouts.app')

@section('title', 'Analytics - Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-white">
                <h1 class="font-serif text-4xl font-bold mb-2">Analytics Dashboard</h1>
                <p class="text-xl">Business insights and performance metrics</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Revenue</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($totalRevenue, 2) }}</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg">💰</div>
                </div>
            </div>
            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Bookings</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalBookings }}</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg">📅</div>
                </div>
            </div>
            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Clients</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalClients }}</p>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-lg">👥</div>
                </div>
            </div>
            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Active Services</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalServices }}</p>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-lg">🛍️</div>
                </div>
            </div>
            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Average Booking</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($averageBookingValue, 2) }}</p>
                    </div>
                    <div class="bg-indigo-50 p-3 rounded-lg">📈</div>
                </div>
            </div>
            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Staff Members</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $activeStaff }}</p>
                    </div>
                    <div class="bg-pink-50 p-3 rounded-lg">⭐</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="glass-card p-6">
                <h2 class="font-serif text-2xl font-bold text-gray-900 mb-4">Recent Bookings</h2>
                <div class="space-y-4">
                    @forelse($recentBookings as $booking)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $booking->service }}</p>
                                <p class="text-sm text-gray-600">{{ $booking->client_name }}</p>
                            </div>
                            <div class="text-sm text-gray-600">${{ $booking->price }}</div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">No recent bookings</p>
                    @endforelse
                </div>
            </div>

            <div class="glass-card p-6">
                <h2 class="font-serif text-2xl font-bold text-gray-900 mb-4">Top Services</h2>
                <div class="space-y-4">
                    @forelse($topServices as $index => $service)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-white {{ $index === 0 ? 'bg-yellow-500' : ($index === 1 ? 'bg-gray-400' : ($index === 2 ? 'bg-orange-600' : 'bg-gray-300')) }}">{{ $index + 1 }}</div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $service->service }}</p>
                                    <p class="text-sm text-gray-600">{{ $service->count }} bookings</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">No service data available</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
