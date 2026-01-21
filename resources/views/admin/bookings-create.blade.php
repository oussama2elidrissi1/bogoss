@extends('layouts.app')

@section('title', 'Add Booking - Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6">
            <h1 class="font-serif text-3xl font-bold mb-6">Add Booking</h1>
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm mb-4">
                    {{ $errors->first() }}
                </div>
            @endif
            <form method="POST" action="{{ route('admin.bookings.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Client</label>
                    <select name="client_id" class="input-field" required>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }} ({{ $client->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Service</label>
                    <select name="service_id" class="input-field" required>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" data-price="{{ $service->price }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Staff (Optional)</label>
                    <select name="staff_id" class="input-field">
                        <option value="">Any Available</option>
                        @foreach($staff as $member)
                            <option value="{{ $member->id }}" data-payouts='@json($member->services->pluck("pivot.payout_percentage","id"))' {{ old('staff_id') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1" id="staff-payout-preview"></p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                        <input type="date" name="date" class="input-field" value="{{ old('date') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Time</label>
                        <input type="time" name="time" class="input-field" value="{{ old('time') }}" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" class="input-field" rows="3">{{ old('notes') }}</textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn-primary">Save</button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
  (function () {
    const serviceSelect = document.querySelector('select[name="service_id"]');
    const staffSelect = document.querySelector('select[name="staff_id"]');
    const preview = document.getElementById('staff-payout-preview');
    if (!serviceSelect || !staffSelect || !preview) return;

    const updatePreview = () => {
      const serviceId = serviceSelect.value;
      const staffOption = staffSelect.options[staffSelect.selectedIndex];
      const payouts = staffOption?.dataset?.payouts ? JSON.parse(staffOption.dataset.payouts) : {};
      const percent = payouts[serviceId] ?? 0;
      preview.textContent = staffOption?.value ? `Staff payout: ${percent}%` : '';
    };

    serviceSelect.addEventListener('change', updatePreview);
    staffSelect.addEventListener('change', updatePreview);
    updatePreview();
  })();
</script>
@endpush
