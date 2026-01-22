@extends('layouts.app')

@section('title', __('pages.partner_dashboard.title'))

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-white">
                <h1 class="font-serif text-4xl font-bold mb-2">{{ __('pages.partner_dashboard.title_short') }}</h1>
                <p class="text-xl">{{ __('pages.partner_dashboard.welcome', ['name' => $partner->name]) }}</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(session('success'))
            <div class="glass-card p-4 mb-6 text-green-700 bg-green-50">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="glass-card p-6">
                <p class="text-sm text-gray-600">{{ __('pages.partner_dashboard.total_bookings') }}</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalBookings }}</p>
            </div>
            <div class="glass-card p-6">
                <p class="text-sm text-gray-600">{{ __('pages.partner_dashboard.total_commission') }}</p>
                <p class="text-3xl font-bold text-gray-900">MAD {{ number_format($totalCommission, 2) }}</p>
            </div>
            <div class="glass-card p-6">
                <p class="text-sm text-gray-600">{{ __('pages.partner_dashboard.commission_rate') }}</p>
                <p class="text-3xl font-bold text-gray-900">{{ $partner->commission_rate }}%</p>
            </div>
        </div>

        <div class="flex items-center justify-between mb-4">
            <form method="GET" class="flex gap-3">
                <input type="date" name="from" value="{{ $from }}" class="input-field">
                <input type="date" name="to" value="{{ $to }}" class="input-field">
                <button class="btn-primary">{{ __('pages.common.filter') }}</button>
            </form>
            <a href="{{ route('partner.bookings.create') }}" class="btn-secondary">{{ __('pages.partner_dashboard.new_booking') }}</a>
        </div>

        <div class="glass-card p-6">
            <h2 class="font-serif text-2xl font-bold mb-4">{{ __('pages.partner_dashboard.bookings') }}</h2>
            <div class="space-y-3">
                @forelse($bookings as $booking)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-gray-900">{{ $booking->client_name }} - {{ $booking->service }}</p>
                                <p class="text-sm text-gray-600">{{ __('pages.partner_dashboard.booking_line', ['date' => $booking->date->format('M d, Y'), 'time' => $booking->time]) }}</p>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-primary">MAD {{ $booking->price }}</span>
                                <p class="text-sm text-gray-600">{{ __('pages.partner_dashboard.commission_line', ['amount' => $booking->commission_amount]) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">{{ __('pages.partner_dashboard.no_bookings') }}</p>
                @endforelse
            </div>
        </div>
    </section>
</div>
@endsection

