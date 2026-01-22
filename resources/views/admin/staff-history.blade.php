@extends('layouts.app')

@section('title', __('admin.staff_history.title'))

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-4xl font-bold mb-2 text-white">{{ __('admin.staff_history.title_short', ['name' => $staff->name]) }}</h1>
            <p class="text-xl text-white/90">{{ is_array($staff->role) ? implode(', ', $staff->role) : $staff->role }}</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin.staff_history.day') }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.staff.history', ['staff' => $staff->id, 'date' => \Carbon\Carbon::parse($date)->subDay()->toDateString()]) }}" class="btn-secondary">{{ __('admin.staff_history.prev') }}</a>
                    <a href="{{ route('admin.staff.history', ['staff' => $staff->id, 'date' => \Carbon\Carbon::parse($date)->addDay()->toDateString()]) }}" class="btn-secondary">{{ __('admin.staff_history.next') }}</a>
                    <a href="{{ route('admin.staff.history', ['staff' => $staff->id, 'date' => now()->toDateString()]) }}" class="btn-primary">{{ __('admin.staff_history.today') }}</a>
                </div>
            </div>
        </div>

        <div class="glass-card p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin.staff_history.total_earnings') }}</p>
                    <p class="text-3xl font-bold text-gray-900">MAD {{ number_format($totalEarnings, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin.staff_history.total_confirmed') }}</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalConfirmed }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{ __('admin.staff_history.avg_earnings') }}</p>
                    <p class="text-3xl font-bold text-gray-900">
                        MAD {{ $totalConfirmed > 0 ? number_format($totalEarnings / $totalConfirmed, 2) : '0.00' }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.staff.index') }}" class="btn-secondary">{{ __('pages.common.cancel') }}</a>
                </div>
            </div>
        </div>

        <div class="glass-card p-6">
            <h2 class="font-serif text-2xl font-bold text-gray-900 mb-4">{{ __('admin.staff_history.history_title') }}</h2>
            @if($bookings->count() > 0)
                <div class="space-y-3">
                    @foreach($bookings as $booking)
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $booking->service }}</p>
                                    <p class="text-sm text-gray-600">{{ $booking->client_name }}</p>
                                </div>
                                <span class="badge {{ $booking->status === 'confirmed' ? 'badge-success' : ($booking->status === 'pending' ? 'badge-warning' : 'badge-error') }}">
                                    {{ __('admin.status.' . $booking->status) }}
                                </span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-600">
                                <div>📅 {{ $booking->date->format('M d, Y') }}</div>
                                <div>🕐 {{ $booking->time }}</div>
                                <div>⏱️ {{ $booking->duration }} {{ __('pages.common.minutes') }}</div>
                                <div>💰 MAD {{ number_format($booking->price, 2) }}</div>
                                <div>💼 {{ __('admin.staff_history.staff_commission') }}: MAD {{ number_format($booking->staff_payout_amount ?? 0, 2) }}</div>
                                <div>📈 {{ __('admin.staff_history.rate') }}: {{ number_format($booking->staff_payout_percentage ?? 0, 2) }}%</div>
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ __('admin.staff_history.notes') }}: <span class="text-gray-900">{{ $booking->notes ?: '-' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $bookings->links() }}
                </div>
            @else
                <p class="text-sm text-gray-500">{{ __('admin.staff_history.none') }}</p>
            @endif
        </div>
    </section>
</div>
@endsection
