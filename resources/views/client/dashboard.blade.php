@extends('layouts.app')

@section('title', __('pages.client.title'))

@section('content')
@if(!$user)
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50 flex items-center justify-center p-4">
    <div class="glass-card max-w-md w-full p-8">
        <div class="text-center mb-6">
            <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-white text-2xl">🔐</span>
            </div>
            <h2 class="font-serif text-3xl font-bold text-gray-900 mb-2">{{ __('pages.client.login_title') }}</h2>
            <p class="text-gray-600">{{ __('pages.client.login_subtitle') }}</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.auth.email') }}</label>
                <input type="email" name="email" required class="input-field" placeholder="{{ __('pages.client.email_placeholder') }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.auth.password') }}</label>
                <input type="password" name="password" required class="input-field" placeholder="••••••••">
            </div>
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                    {{ $errors->first() }}
                </div>
            @endif
            <button type="submit" class="w-full btn-primary">{{ __('app.auth.sign_in') }}</button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 mb-4">{{ __('pages.client.need_account') }}</p>
            <a href="{{ route('register') }}" class="btn-outline">{{ __('app.auth.register') }}</a>
        </div>
    </div>
</div>
@else
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-white">
                <h1 class="font-serif text-4xl font-bold mb-2">{{ __('pages.client.welcome', ['name' => $user->name]) }}</h1>
                <p class="text-xl">{{ __('pages.client.subtitle') }}</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @php
            $upcomingBookings = $bookings->filter(fn ($b) => $b->date >= now()->toDateString());
            $clientProfile = $client;
        @endphp
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="glass-card p-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 gradient-wellness rounded-full flex items-center justify-center">📅</div>
                    <div>
                        <p class="text-gray-600 text-sm">{{ __('pages.client.upcoming_bookings') }}</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $upcomingBookings->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="glass-card p-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 gradient-wellness rounded-full flex items-center justify-center">👤</div>
                    <div>
                        <p class="text-gray-600 text-sm">{{ __('pages.client.total_visits') }}</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $clientProfile->visits ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="glass-card p-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 gradient-wellness rounded-full flex items-center justify-center">💳</div>
                    <div>
                        <p class="text-gray-600 text-sm">{{ __('pages.client.total_spent') }}</p>
                        <p class="text-3xl font-bold text-gray-900">MAD {{ $clientProfile->total_spent ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="glass-card p-6">
                    <h2 class="font-serif text-2xl font-bold text-gray-900 mb-6">{{ __('pages.client.upcoming_appointments') }}</h2>
                    @if($upcomingBookings->count() > 0)
                        <div class="space-y-4">
                            @foreach($upcomingBookings as $booking)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-bold text-gray-900">{{ $booking->service }}</h3>
                                            <p class="text-sm text-gray-600">{{ __('pages.client.with_staff', ['name' => $booking->staff_name ?? __('pages.client.any_staff')]) }}</p>
                                        </div>
                                        <span class="badge badge-primary">{{ __('admin.status.' . $booking->status) }}</span>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                                        <span>📅 {{ $booking->date }}</span>
                                        <span>🕐 {{ $booking->time }}</span>
                                        <span>⏱️ {{ $booking->duration }} {{ __('pages.common.minutes') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">📅</div>
                            <p class="text-gray-600 mb-4">{{ __('pages.client.no_upcoming') }}</p>
                            <a href="{{ route('booking') }}" class="btn-primary">{{ __('pages.common.book') }}</a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div class="glass-card p-6">
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-4">{{ __('pages.client.account_details') }}</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-600">{{ __('app.auth.email') }}</p>
                            <p class="font-medium text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">{{ __('pages.client.phone') }}</p>
                            <p class="font-medium text-gray-900">{{ $clientProfile->phone ?? __('pages.client.not_available') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">{{ __('pages.client.member_since') }}</p>
                            <p class="font-medium text-gray-900">{{ $clientProfile->join_date ?? $user->created_at?->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">{{ __('pages.client.membership') }}</p>
                            <p class="font-medium text-gray-900">{{ $clientProfile->subscription ?? __('pages.client.no_membership') }}</p>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-6">
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-4">{{ __('pages.client.quick_actions') }}</h3>
                    <div class="space-y-2">
                        <a href="{{ route('booking') }}" class="block w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">📅 {{ __('pages.client.action_book') }}</a>
                        <a href="{{ route('subscriptions') }}" class="block w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">💳 {{ __('pages.client.action_memberships') }}</a>
                        <a href="{{ route('shop') }}" class="block w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">🛍️ {{ __('pages.client.action_shop') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endif
@endsection

