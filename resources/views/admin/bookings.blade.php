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
                                    <div
                                        class="bg-white rounded-lg p-3 border border-gray-100 cursor-pointer hover:border-primary/40 hover:shadow-sm js-booking-card"
                                        data-booking="{{ json_encode([
                                            'id' => $booking->id,
                                            'client_id' => $booking->client_id,
                                            'reference' => $booking->booking_reference,
                                            'client' => $booking->client_name,
                                            'date' => $booking->date->toDateString(),
                                            'time' => $booking->time,
                                            'total_duration' => $booking->total_duration,
                                            'total' => $booking->total,
                                            'status' => $booking->status,
                                            'notes' => $booking->notes,
                                            'items' => $booking->items->map(fn($item) => [
                                                'service_name' => $item->service_name,
                                                'staff_name' => $item->staff_name,
                                                'duration' => $item->duration,
                                                'total' => $item->total,
                                            ]),
                                        ]) }}"
                                    >
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="font-medium">{{ $booking->time }}</span>
                                            <span class="badge {{ $booking->status === 'confirmed' ? 'badge-success' : ($booking->status === 'pending' ? 'badge-warning' : 'badge-error') }}">
                                                {{ $booking->status }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-600 mt-1">
                                            {{ $booking->items->pluck('service_name')->join(', ') }}
                                        </div>
                                        <div class="text-xs text-gray-500">Client: {{ $booking->client_name }}</div>
                                        <div class="text-xs text-gray-400">Réf: {{ $booking->booking_reference }}</div>
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
            <h3 class="font-serif text-2xl font-bold text-gray-900">Réservations hors agenda</h3>
            @forelse($nonAgendaBookings as $booking)
            <div class="glass-card p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-serif text-xl font-bold text-gray-900">
                            Réf: {{ $booking->booking_reference }}
                        </h3>
                        <p class="text-sm text-gray-600">Client: {{ $booking->client_name }}</p>
                        <div class="mt-2 space-y-1">
                            @foreach($booking->items as $item)
                                <p class="text-xs text-gray-500">→ {{ $item->service_name }}</p>
                            @endforeach
                        </div>
                    </div>
                    <span class="badge {{ $booking->status === 'confirmed' ? 'badge-success' : ($booking->status === 'pending' ? 'badge-warning' : 'badge-error') }}">
                        {{ $booking->status }}
                    </span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-600 mb-4">
                    <div>📅 {{ $booking->date->format('M d, Y') }}</div>
                    <div>🕐 {{ $booking->time }} ({{ $booking->total_duration }} min)</div>
                    <div>🎫 {{ $booking->items->count() }} service(s)</div>
                    <div>💰 MAD {{ number_format($booking->total, 2) }}</div>
                </div>
                <div class="flex space-x-2">
                    <button
                        type="button"
                        class="btn-primary text-sm js-booking-card"
                        data-booking="{{ json_encode([
                            'id' => $booking->id,
                            'client_id' => $booking->client_id,
                            'reference' => $booking->booking_reference,
                            'client' => $booking->client_name,
                            'date' => $booking->date->toDateString(),
                            'time' => $booking->time,
                            'total_duration' => $booking->total_duration,
                            'total' => $booking->total,
                            'status' => $booking->status,
                            'notes' => $booking->notes,
                            'items' => $booking->items->map(fn($item) => [
                                'service_name' => $item->service_name,
                                'staff_name' => $item->staff_name,
                                'duration' => $item->duration,
                                'total' => $item->total,
                            ]),
                        ]) }}"
                    >
                        View Details
                    </button>
                            'status' => $booking->status,
                            'notes' => $booking->notes,
                        ]) }}"
                    >
                        View / Edit
                    </button>
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
            {{ $nonAgendaBookings->links() }}
        </div>
    </section>
</div>
@endsection

@push('scripts')
<div id="booking-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 max-h-[90vh] overflow-hidden">
        <div class="max-h-[85vh] overflow-y-auto pr-1">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-serif text-2xl font-bold text-gray-900">Booking Details</h3>
                <button type="button" class="text-gray-500 hover:text-gray-700" data-close-modal>✕</button>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 mb-6 text-sm">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-gray-500">Référence</p>
                        <p class="font-semibold text-gray-900" id="modal-reference"></p>
                    </div>
                    <span class="badge badge-warning" id="modal-status"></span>
                </div>
                
                <div class="grid grid-cols-2 gap-3 mb-4 text-gray-600">
                    <div>Client: <span class="text-gray-900 font-medium" id="modal-client"></span></div>
                    <div>Date: <span class="text-gray-900 font-medium" id="modal-date"></span></div>
                    <div>Heure: <span class="text-gray-900 font-medium" id="modal-time"></span></div>
                    <div>Durée totale: <span class="text-gray-900 font-medium" id="modal-total-duration"></span> min</div>
                </div>

                <!-- Liste des services -->
                <div class="border-t border-gray-200 pt-3 mb-3">
                    <p class="text-gray-700 font-semibold mb-2">Services réservés:</p>
                    <div id="modal-items-list" class="space-y-2">
                        <!-- Items chargés dynamiquement -->
                    </div>
                </div>

                <!-- Total -->
                <div class="border-t border-gray-200 pt-3 flex items-center justify-between">
                    <span class="text-gray-700 font-semibold">Total à payer</span>
                    <span class="text-lg font-bold text-primary">MAD <span id="modal-total"></span></span>
                </div>

                <div class="mt-3 text-gray-600 text-sm" id="modal-notes-container">
                    <span class="font-medium">Notes:</span> <span class="text-gray-900" id="modal-notes"></span>
                </div>
            </div>

            <form method="POST" id="modal-edit-form" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="input-field">
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" rows="3" class="input-field" placeholder="Notes administratives..."></textarea>
                </div>
                <button type="submit" class="btn-primary w-full">Update Status & Notes</button>
            </form>
        </div>
    </div>
</div>

<script>
  (function () {
    const modal = document.getElementById('booking-modal');
    const closeBtns = document.querySelectorAll('[data-close-modal]');
    const cards = document.querySelectorAll('.js-booking-card');
    const form = document.getElementById('modal-edit-form');

    const setBadgeClass = (statusEl, status) => {
      statusEl.classList.remove('badge-success', 'badge-warning', 'badge-error');
      if (status === 'confirmed') statusEl.classList.add('badge-success');
      else if (status === 'cancelled') statusEl.classList.add('badge-error');
      else statusEl.classList.add('badge-warning');
    };

    const openModal = () => {
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    };

    const closeModal = () => {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    };

    closeBtns.forEach((btn) => btn.addEventListener('click', closeModal));

    cards.forEach((card) => {
      card.addEventListener('click', () => {
        const data = card.dataset.booking ? JSON.parse(card.dataset.booking) : null;
        if (!data || !form) return;

        // Afficher la référence et les infos de base
        document.getElementById('modal-reference').textContent = data.reference || '-';
        document.getElementById('modal-client').textContent = data.client || '-';
        document.getElementById('modal-date').textContent = data.date || '-';
        document.getElementById('modal-time').textContent = data.time || '-';
        document.getElementById('modal-total-duration').textContent = data.total_duration || '-';
        document.getElementById('modal-total').textContent = parseFloat(data.total || 0).toFixed(2);
        
        const notesText = data.notes || 'Aucune note';
        document.getElementById('modal-notes').textContent = notesText;
        if (!data.notes) {
          document.getElementById('modal-notes-container').classList.add('text-gray-400');
        } else {
          document.getElementById('modal-notes-container').classList.remove('text-gray-400');
        }

        // Afficher le statut
        const statusEl = document.getElementById('modal-status');
        statusEl.textContent = data.status || 'pending';
        setBadgeClass(statusEl, data.status);

        // Afficher la liste des services (items)
        const itemsList = document.getElementById('modal-items-list');
        itemsList.innerHTML = '';
        
        if (data.items && data.items.length > 0) {
          data.items.forEach((item, index) => {
            const itemDiv = document.createElement('div');
            itemDiv.className = 'bg-white rounded-lg p-3 border border-gray-200';
            itemDiv.innerHTML = `
              <div class="flex items-start justify-between mb-2">
                <div class="flex-1">
                  <p class="font-semibold text-gray-900">${index + 1}. ${item.service_name}</p>
                  <p class="text-xs text-gray-600 mt-1">
                    👤 ${item.staff_name || 'Non assigné'} • ⏱️ ${item.duration} min
                  </p>
                </div>
                <div class="text-right">
                  <p class="font-bold text-gray-900">MAD ${parseFloat(item.total).toFixed(2)}</p>
                </div>
              </div>
            `;
            itemsList.appendChild(itemDiv);
          });
        } else {
          itemsList.innerHTML = '<p class="text-sm text-gray-500 italic">Aucun service trouvé</p>';
        }

        // Préremplir le formulaire
        form.action = `{{ url('admin/bookings') }}/${data.id}`;
        form.querySelector('select[name="status"]').value = data.status || 'pending';
        form.querySelector('textarea[name="notes"]').value = data.notes || '';

        openModal();
      });
    });
  })();
</script>
@endpush

