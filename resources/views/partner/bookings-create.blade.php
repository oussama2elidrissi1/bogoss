@extends('layouts.app')

@section('title', __('pages.partner_booking_create.title'))

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6">
            <h1 class="font-serif text-3xl font-bold mb-6">{{ __('pages.partner_booking_create.title_short') }}</h1>
            <form method="POST" action="{{ route('partner.bookings.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.partner_booking_create.client_name') }}</label>
                    <input type="text" name="client_name" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.partner_booking_create.client_email') }}</label>
                    <input type="email" name="client_email" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.partner_booking_create.client_phone') }}</label>
                    <input type="text" name="client_phone" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.partner_booking_create.service') }}</label>
                    <select name="service_id" class="input-field" required>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.partner_booking_create.staff_optional') }}</label>
                    <select name="staff_id" class="input-field">
                        <option value="">{{ __('pages.partner_booking_create.any_staff') }}</option>
                        @foreach($staff as $member)
                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.partner_booking_create.date') }}</label>
                        <input type="date" name="date" class="input-field" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.partner_booking_create.time') }}</label>
                        <input type="time" name="time" class="input-field" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.partner_booking_create.notes') }}</label>
                    <textarea name="notes" class="input-field" rows="3"></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn-primary">{{ __('pages.partner_booking_create.submit') }}</button>
                    <a href="{{ route('partner.dashboard') }}" class="btn-secondary">{{ __('pages.common.cancel') }}</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

