@extends('layouts.app')

@section('title', __('pages.booking.title'))

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50" id="booking-page" data-auth="{{ auth()->check() ? '1' : '0' }}">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="font-serif text-5xl font-bold mb-4">{{ __('pages.booking.hero_title') }}</h1>
                <p class="text-xl max-w-2xl mx-auto">{{ __('pages.booking.hero_subtitle') }}</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(session('success'))
            <div class="glass-card p-4 mb-6 text-green-700 bg-green-50">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="mb-8">
                    <h2 class="font-serif text-2xl font-bold text-gray-900 mb-4">{{ __('pages.booking.choose_service') }}</h2>
                    <div class="flex flex-wrap gap-3 mb-6">
                        <a href="{{ route('booking', ['category' => 'All', 'date' => $selectedDate->toDateString(), 'service_id' => optional($selectedService)->id]) }}" class="px-6 py-2 rounded-full font-medium transition-all duration-300 {{ $selectedCategory === 'All' ? 'bg-primary text-white shadow-lg scale-105' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">{{ __('pages.common.all') }}</a>
                        @foreach($categories as $category)
                            <a href="{{ route('booking', ['category' => $category, 'date' => $selectedDate->toDateString(), 'service_id' => optional($selectedService)->id]) }}" class="px-6 py-2 rounded-full font-medium transition-all duration-300 {{ $selectedCategory === $category ? 'bg-primary text-white shadow-lg scale-105' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">{{ $category }}</a>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($services as $service)
                            <div class="glass-card overflow-hidden">
                                <div class="relative h-40 overflow-hidden">
                                    <img src="{{ $service->image ?? 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400' }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                                    <div class="absolute top-3 right-3">
                                        <span class="badge badge-primary">{{ $service->category }}</span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-serif text-lg font-bold text-gray-900 mb-2">{{ $service->name }}</h3>
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $service->description }}</p>
                                    <div class="flex items-center justify-between mb-3 text-sm text-gray-700">
                                        <span>⏱️ {{ $service->duration }} {{ __('pages.common.minutes') }}</span>
                                        <span class="text-primary font-bold">MAD {{ $service->price }}</span>
                                    </div>
                                    <button
                                        type="button"
                                        class="w-full btn-primary inline-block text-center js-book-service"
                                        data-service-id="{{ $service->id }}"
                                        data-service-name="{{ $service->name }}"
                                        data-service-price="{{ $service->price }}"
                                        data-service-duration="{{ $service->duration }}"
                                    >
                                        {{ __('pages.common.book') }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="glass-card p-6">
                    <h2 class="font-serif text-2xl font-bold text-gray-900 mb-4">{{ __('pages.booking.choose_date') }}</h2>
                    <form method="GET" class="space-y-4">
                        <input type="hidden" name="category" value="{{ $selectedCategory }}">
                        <input type="hidden" name="service_id" value="{{ optional($selectedService)->id }}">
                        <input type="date" name="date" min="{{ now()->toDateString() }}" value="{{ $selectedDate->toDateString() }}" class="input-field" onchange="this.form.submit()">
                    </form>
                </div>

                <div class="glass-card p-6">
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-4">{{ __('pages.booking.bookings_of', ['date' => $selectedDate->format('M d, Y')]) }}</h3>
                    @if($dateBookings->count() > 0)
                        <div class="space-y-3">
                            @foreach($dateBookings as $booking)
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="font-medium text-gray-900">{{ $booking->service }}</span>
                                        <span class="badge badge-primary">{{ $booking->time }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $booking->client_name }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">{{ __('pages.booking.no_bookings') }}</p>
                    @endif
                </div>

                <div class="glass-card p-6">
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-4">{{ __('pages.booking.available_staff') }}</h3>
                    @if($availableStaff->count() > 0)
                        <div class="space-y-3">
                            @foreach($availableStaff as $staff)
                                <div class="flex items-center space-x-3 bg-gray-50 rounded-lg p-3">
                                    <img src="{{ $staff->image ?? 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200' }}" alt="{{ $staff->name }}" class="w-12 h-12 rounded-full object-cover">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">{{ $staff->name }}</p>
                                        <p class="text-sm text-gray-600">{{ is_array($staff->role) ? implode(', ', $staff->role) : $staff->role }}</p>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex items-center space-x-1">
                                            <span class="text-yellow-500">★</span>
                                            <span class="text-sm font-medium">{{ $staff->rating }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">{{ __('pages.booking.no_staff') }}</p>
                    @endif
                </div>

                <div class="glass-card p-6">
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-4">{{ __('pages.booking.process_title') }}</h3>
                    <ol class="text-sm text-gray-600 space-y-2 list-decimal list-inside">
                        <li>{{ __('pages.booking.process_step1') }}</li>
                        <li>{{ __('pages.booking.process_step2') }}</li>
                        <li>{{ __('pages.booking.process_step3') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
</div>

@guest
<div id="auth-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-serif text-2xl font-bold text-gray-900">{{ __('pages.booking.auth_title') }}</h3>
            <button type="button" class="text-gray-500 hover:text-gray-700" data-close-modal>✕</button>
        </div>
        <div class="flex space-x-2 mb-6">
            <button type="button" class="px-4 py-2 rounded-full text-sm font-medium bg-primary text-white" data-auth-tab="login">{{ __('app.auth.sign_in') }}</button>
            <button type="button" class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700" data-auth-tab="register">{{ __('app.auth.register') }}</button>
        </div>

        <div id="auth-login-panel">
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.auth.email') }}</label>
                    <input type="email" name="email" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.auth.password') }}</label>
                    <input type="password" name="password" class="input-field" required>
                </div>
                <button type="submit" class="btn-primary w-full">{{ __('app.auth.sign_in') }}</button>
            </form>
        </div>

        <div id="auth-register-panel" class="hidden">
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.auth.name') }}</label>
                    <input type="text" name="name" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.auth.email') }}</label>
                    <input type="email" name="email" class="input-field" required>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.auth.password') }}</label>
                        <input type="password" name="password" class="input-field" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.auth.confirm_password') }}</label>
                        <input type="password" name="password_confirmation" class="input-field" required>
                    </div>
                </div>
                <button type="submit" class="btn-primary w-full">{{ __('app.auth.register') }}</button>
            </form>
        </div>
    </div>
</div>
@endguest

@auth
<div id="booking-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 max-h-[90vh] overflow-hidden">
        <div class="max-h-[85vh] overflow-y-auto pr-1">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-serif text-2xl font-bold text-gray-900">{{ __('pages.booking.modal_title') }}</h3>
            <button type="button" class="text-gray-500 hover:text-gray-700" data-close-modal>✕</button>
        </div>
        <div class="bg-gray-50 rounded-xl p-4 mb-6">
            <p class="text-sm text-gray-500">{{ __('pages.booking.selected_services') }}</p>
            <div class="space-y-2" id="booking-service-list">
                <p class="text-sm text-gray-600">{{ __('pages.booking.no_selected_services') }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('booking.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.booking.service_label') }}</label>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="button" class="btn-primary" id="add-service-btn">{{ __('pages.booking.add_service') }}</button>
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ __('pages.booking.add_service_hint') }}</p>
            </div>

            <div id="service-picker-panel" class="hidden border border-gray-200 rounded-xl p-4 bg-white">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-serif text-lg font-bold text-gray-900">{{ __('pages.booking.choose_another_service') }}</h4>
                    <button type="button" class="text-gray-500 hover:text-gray-700" id="close-service-panel">✕</button>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 mb-4">
                    <div class="relative flex-1">
                        <input
                            type="text"
                            id="service-filter-input"
                            class="input-field pl-10"
                            placeholder="{{ __('pages.common.search_service') }}"
                        >
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">🔍</span>
                    </div>
                    <select id="service-filter-category" class="input-field sm:w-48">
                        <option value="all">{{ __('pages.booking.all_categories') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-64 overflow-y-auto" id="service-cards-grid">
                    @foreach($services as $service)
                        <button
                            type="button"
                            class="glass-card overflow-hidden text-left hover:ring-2 hover:ring-primary js-add-service-card"
                            data-service-id="{{ $service->id }}"
                            data-service-name="{{ $service->name }}"
                            data-service-price="{{ $service->price }}"
                            data-service-duration="{{ $service->duration }}"
                            data-service-category="{{ $service->category }}"
                        >
                            <div class="relative h-28 overflow-hidden">
                                <img src="{{ $service->image ?? 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400' }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                                <div class="absolute top-2 right-2">
                                    <span class="badge badge-primary text-xs">{{ $service->category }}</span>
                                </div>
                            </div>
                            <div class="p-3">
                                <p class="font-semibold text-gray-900 text-sm">{{ $service->name }}</p>
                                <div class="flex items-center justify-between text-xs text-gray-600 mt-1">
                                    <span>⏱️ {{ $service->duration }} {{ __('pages.common.minutes') }}</span>
                                    <span class="text-primary font-bold">MAD {{ $service->price }}</span>
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.booking.date_label') }}</label>
                    <input type="date" name="date" class="input-field" value="{{ $selectedDate->toDateString() }}" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.booking.time_label') }}</label>
                    <select name="time" class="input-field" required>
                        @foreach($timeSlots as $time)
                            <option value="{{ $time }}">{{ $time }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.booking.staff_optional') }}</label>
                <select name="staff_id" class="input-field">
                    <option value="">{{ __('pages.booking.auto_assign') }}</option>
                    @foreach($availableStaff as $staffMember)
                        <option value="{{ $staffMember->id }}">{{ $staffMember->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.booking.notes_label') }}</label>
                <textarea name="notes" rows="3" class="input-field" placeholder="{{ __('pages.booking.notes_placeholder') }}"></textarea>
            </div>
            <button type="submit" class="btn-primary w-full">{{ __('pages.booking.confirm_booking') }}</button>
        </form>
        </div>
    </div>
</div>
@endauth

@push('scripts')
<script>
  (function () {
    const page = document.getElementById('booking-page');
    if (!page) return;
    const isAuth = page.dataset.auth === '1';
    const authModal = document.getElementById('auth-modal');
    const bookingModal = document.getElementById('booking-modal');
    const serviceButtons = document.querySelectorAll('.js-book-service');
    const closeButtons = document.querySelectorAll('[data-close-modal]');
    const loginPanel = document.getElementById('auth-login-panel');
    const registerPanel = document.getElementById('auth-register-panel');
    const loginTab = document.querySelector('[data-auth-tab="login"]');
    const registerTab = document.querySelector('[data-auth-tab="register"]');
    const serviceList = document.getElementById('booking-service-list');
    const bookingForm = bookingModal ? bookingModal.querySelector('form') : null;
    const servicePanel = document.getElementById('service-picker-panel');
    const closeServicePanel = document.getElementById('close-service-panel');
    const addServiceBtn = document.getElementById('add-service-btn');
    const serviceCards = document.querySelectorAll('.js-add-service-card');
    const serviceFilterInput = document.getElementById('service-filter-input');
    const serviceFilterCategory = document.getElementById('service-filter-category');
    const selectedServices = new Map();
    const labels = {
      noServiceSelected: @json(__('pages.booking.no_selected_services')),
      remove: @json(__('pages.common.remove')),
      minutes: @json(__('pages.common.minutes')),
    };

    const openModal = (modal) => {
      if (!modal) return;
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    };

    const closeModal = (modal) => {
      if (!modal) return;
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    };

    const setAuthTab = (tab) => {
      if (!loginPanel || !registerPanel || !loginTab || !registerTab) return;
      if (tab === 'register') {
        loginPanel.classList.add('hidden');
        registerPanel.classList.remove('hidden');
        loginTab.classList.remove('bg-primary', 'text-white');
        loginTab.classList.add('bg-gray-100', 'text-gray-700');
        registerTab.classList.add('bg-primary', 'text-white');
        registerTab.classList.remove('bg-gray-100', 'text-gray-700');
      } else {
        registerPanel.classList.add('hidden');
        loginPanel.classList.remove('hidden');
        registerTab.classList.remove('bg-primary', 'text-white');
        registerTab.classList.add('bg-gray-100', 'text-gray-700');
        loginTab.classList.add('bg-primary', 'text-white');
        loginTab.classList.remove('bg-gray-100', 'text-gray-700');
      }
    };

    if (loginTab && registerTab) {
      loginTab.addEventListener('click', () => setAuthTab('login'));
      registerTab.addEventListener('click', () => setAuthTab('register'));
    }

    closeButtons.forEach((btn) => {
      btn.addEventListener('click', () => {
        closeModal(authModal);
        closeModal(bookingModal);
      });
    });

    const renderSelected = () => {
      if (!serviceList) return;
      if (selectedServices.size === 0) {
        serviceList.innerHTML = `<p class="text-sm text-gray-600">${labels.noServiceSelected}</p>`;
        return;
      }
      serviceList.innerHTML = '';
      selectedServices.forEach((service) => {
        const row = document.createElement('div');
        row.className = 'flex items-center justify-between bg-white rounded-lg px-3 py-2 text-sm';
        row.innerHTML = `
          <div>
            <div class="font-medium text-gray-900">${service.name}</div>
            <div class="text-gray-500">${service.price} • ${service.duration}</div>
          </div>
          <button type="button" class="text-red-500 hover:text-red-600" data-remove-service="${service.id}">${labels.remove}</button>
        `;
        serviceList.appendChild(row);
      });

      if (!bookingForm) return;
      const hiddenInputs = bookingForm.querySelectorAll('input[name="service_ids[]"]');
      hiddenInputs.forEach((input) => input.remove());
      selectedServices.forEach((service) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'service_ids[]';
        input.value = service.id;
        bookingForm.appendChild(input);
      });
    };

    if (addServiceBtn && servicePanel) {
      addServiceBtn.addEventListener('click', () => {
        servicePanel.classList.toggle('hidden');
      });
    }

    if (closeServicePanel && servicePanel) {
      closeServicePanel.addEventListener('click', () => {
        servicePanel.classList.add('hidden');
      });
    }

    serviceCards.forEach((card) => {
      card.addEventListener('click', () => {
        const id = card.dataset.serviceId;
        if (!id || selectedServices.has(id)) return;
        selectedServices.set(id, {
          id,
          name: card.dataset.serviceName || '',
          price: card.dataset.servicePrice ? `MAD ${card.dataset.servicePrice}` : '',
          duration: card.dataset.serviceDuration ? `${card.dataset.serviceDuration} ${labels.minutes}` : '',
        });
        renderSelected();
      });
    });

    const applyServiceFilter = () => {
      const query = (serviceFilterInput?.value || '').toLowerCase().trim();
      const category = serviceFilterCategory?.value || 'all';
      serviceCards.forEach((card) => {
        const name = (card.dataset.serviceName || '').toLowerCase();
        const cardCategory = card.dataset.serviceCategory || '';
        const matchesQuery = !query || name.includes(query);
        const matchesCategory = category === 'all' || cardCategory === category;
        card.classList.toggle('hidden', !(matchesQuery && matchesCategory));
      });
    };

    if (serviceFilterInput) {
      serviceFilterInput.addEventListener('input', applyServiceFilter);
    }
    if (serviceFilterCategory) {
      serviceFilterCategory.addEventListener('change', applyServiceFilter);
    }

    if (serviceList) {
      serviceList.addEventListener('click', (event) => {
        const btn = event.target.closest('[data-remove-service]');
        if (!btn) return;
        const id = btn.getAttribute('data-remove-service');
        selectedServices.delete(id);
        renderSelected();
      });
    }

    serviceButtons.forEach((btn) => {
      btn.addEventListener('click', () => {
        const serviceId = btn.dataset.serviceId;
        const serviceName = btn.dataset.serviceName;
        const servicePrice = btn.dataset.servicePrice;
        const serviceDuration = btn.dataset.serviceDuration;
        if (isAuth) {
          if (serviceId) {
            selectedServices.clear();
            selectedServices.set(serviceId, {
              id: serviceId,
              name: serviceName || '',
              price: servicePrice ? `MAD ${servicePrice}` : '',
              duration: serviceDuration ? `${serviceDuration} ${labels.minutes}` : '',
            });
          }
          renderSelected();
          openModal(bookingModal);
        } else {
          setAuthTab('login');
          openModal(authModal);
        }
      });
    });
  })();
</script>
@endpush
@endsection

