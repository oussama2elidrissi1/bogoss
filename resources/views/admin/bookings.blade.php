@extends('layouts.app')

@section('title', 'Bookings - Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-4xl font-bold mb-2 text-white">Booking Management</h1>
            <p class="text-xl text-white/90">Manage appointments and schedules</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(session('success'))
            <div class="glass-card p-4 mb-6 text-green-700 bg-green-50">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="glass-card p-4 mb-6 text-red-700 bg-red-50">
                {{ session('error') }}
            </div>
        @endif
        <div class="glass-card p-6 mb-6">
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="flex gap-4">
                <select name="status" class="input-field">
                    <option value="">All Status</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <input type="date" name="date" value="{{ request('date') }}" class="input-field">
                <input type="hidden" name="agenda_start" value="{{ request('agenda_start', $agendaStart->toDateString()) }}">
                <button type="submit" class="btn-primary">Filter</button>
                <a href="{{ route('admin.bookings.create') }}" class="btn-secondary">Add Booking</a>
            </form>
        </div>

        <div class="glass-card p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="font-serif text-2xl font-bold text-gray-900">Weekly Agenda</h2>
                    <p class="text-sm text-gray-600">
                        {{ $agendaStart->format('M d') }} - {{ $agendaEnd->format('M d, Y') }}
                    </p>
                </div>
                @php
                    $baseQuery = request()->query();
                @endphp
                <div class="flex space-x-2">
                    <a href="{{ route('admin.bookings.index', array_merge($baseQuery, ['agenda_start' => $agendaPrev])) }}" class="px-4 py-2 bg-gray-100 rounded-lg text-sm hover:bg-gray-200">Prev</a>
                    <a href="{{ route('admin.bookings.index', array_merge($baseQuery, ['agenda_start' => $agendaNext])) }}" class="px-4 py-2 bg-gray-100 rounded-lg text-sm hover:bg-gray-200">Next</a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($agendaDays as $day)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-sm font-medium text-gray-900">{{ $day['date']->format('D') }}</div>
                            <div class="text-xs text-gray-500">{{ $day['date']->format('M d') }}</div>
                        </div>
                        @if($day['bookings']->count() > 0)
                            <div class="space-y-2">
                                @foreach($day['bookings'] as $booking)
                                    <div class="bg-white rounded-lg p-3 border border-gray-100">
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="font-medium">{{ $booking->time }}</span>
                                            <span class="badge {{ $booking->status === 'confirmed' ? 'badge-success' : ($booking->status === 'pending' ? 'badge-warning' : 'badge-error') }}">
                                                {{ $booking->status }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-600 mt-1">{{ $booking->service }}</div>
                                        <div class="text-xs text-gray-500">Client: {{ $booking->client_name }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-gray-500">No bookings</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-4">
            @forelse($bookings as $booking)
            <div class="glass-card p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-serif text-xl font-bold text-gray-900">{{ $booking->service }}</h3>
                        <p class="text-sm text-gray-600">Client: {{ $booking->client_name }}</p>
                    </div>
                    <span class="badge {{ $booking->status === 'confirmed' ? 'badge-success' : ($booking->status === 'pending' ? 'badge-warning' : 'badge-error') }}">
                        {{ $booking->status }}
                    </span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-600 mb-4">
                    <div>📅 {{ $booking->date->format('M d, Y') }}</div>
                    <div>🕐 {{ $booking->time }} ({{ $booking->duration }} min)</div>
                    <div>👤 {{ $booking->staff_name ?? 'Any Available' }}</div>
                    <div>💰 ${{ $booking->price }}</div>
                </div>
                @if($booking->staff_payout_percentage)
                    <div class="text-xs text-gray-500 mb-4">
                        Staff payout: {{ $booking->staff_payout_percentage }}% ({{ number_format($booking->staff_payout_amount, 2) }})
                    </div>
                @endif
                <div class="flex space-x-2">
                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn-primary text-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-secondary bg-danger text-sm">Delete</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <p class="text-gray-500">No bookings found</p>
            </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    </section>
</div>
@endsection
