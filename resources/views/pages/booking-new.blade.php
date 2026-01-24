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

                    @if(!empty($serviceGroups))
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                            @foreach($serviceGroups as $group)
                                @php
                                    $variants = ($group['variants'] ?? collect())->map(function ($s) {
                                        $options = $s->availableOptions ?? collect();
                                        return [
                                            'id' => $s->id,
                                            'name' => $s->name,
                                            'price' => (float) $s->price,
                                            'duration' => (int) $s->duration,
                                            'options' => $options->map(fn($opt) => [
                                                'id' => $opt->id,
                                                'name' => $opt->name,
                                                'description' => $opt->description,
                                                'price' => (float) $opt->price,
                                                'duration' => $opt->duration,
                                                'is_required' => $opt->is_required,
                                                'max_quantity' => $opt->max_quantity,
                                            ])->values(),
                                        ];
                                    })->values();
                                @endphp
                                @if($variants->count() > 0)
                                    <div class="glass-card p-5">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="font-serif text-xl font-bold text-gray-900">{{ $group['title'] }}</div>
                                            <div class="text-2xl">{{ $group['icon'] ?? '✨' }}</div>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-4">Choisissez le type et personnalisez avec des options.</p>
                                        <button
                                            type="button"
                                            class="btn-primary w-full js-book-group"
                                            data-group-title="{{ $group['title'] }}"
                                            data-variants='@json($variants)'
                                        >
                                            Choisir {{ $group['title'] }}
                                        </button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <div class="flex flex-wrap gap-3 mb-6">
                        <a href="{{ route('booking', ['category' => 'All', 'date' => $selectedDate->toDateString()]) }}" class="px-6 py-2 rounded-full font-medium transition-all duration-300 {{ $selectedCategory === 'All' ? 'bg-primary text-white shadow-lg scale-105' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">{{ __('pages.common.all') }}</a>
                        @foreach($categories as $category)
                            <a href="{{ route('booking', ['category' => $category, 'date' => $selectedDate->toDateString()]) }}" class="px-6 py-2 rounded-full font-medium transition-all duration-300 {{ $selectedCategory === $category ? 'bg-primary text-white shadow-lg scale-105' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">{{ $category }}</a>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($services as $service)
                            @php
                                $serviceOptions = $service->availableOptions ?? collect();
                            @endphp
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
                                    @if($serviceOptions->count() > 0)
                                        <p class="text-xs text-gray-500 mb-2">✨ {{ $serviceOptions->count() }} option(s) disponible(s)</p>
                                    @endif
                                    <button
                                        type="button"
                                        class="w-full btn-primary inline-block text-center js-book-service"
                                        data-service-id="{{ $service->id }}"
                                        data-service-name="{{ $service->name }}"
                                        data-service-price="{{ $service->price }}"
                                        data-service-duration="{{ $service->duration }}"
                                        data-service-category="{{ $service->category }}"
                                        data-service-options="{{ json_encode($serviceOptions->map(function($opt) { return ['id' => $opt->id, 'name' => $opt->name, 'description' => $opt->description, 'price' => (float) $opt->price, 'duration' => $opt->duration, 'is_required' => $opt->is_required, 'max_quantity' => $opt->max_quantity]; })->values()) }}"
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
                <!-- Panier -->
                <div class="glass-card p-6 sticky top-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-serif text-xl font-bold text-gray-900">Panier</h3>
                        <button id="clear-cart-btn" class="text-sm text-red-600 hover:text-red-700 hidden">
                            Vider
                        </button>
                    </div>
                    
                    <div id="cart-items-list" class="space-y-3 mb-6">
                        <p class="text-sm text-gray-500 text-center py-4">Aucun service sélectionné</p>
                    </div>

                    <!-- Totaux -->
                    <div id="cart-totals" class="border-t border-gray-200 pt-4 space-y-2 hidden">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Sous-total</span>
                            <span id="cart-subtotal">MAD 0.00</span>
                        </div>
                        <div class="flex justify-between text-sm text-green-600">
                            <span>Réduction</span>
                            <span id="cart-discount">- MAD 0.00</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t">
                            <span>Total</span>
                            <span id="cart-total">MAD 0.00</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Durée totale</span>
                            <span id="cart-duration">0 min</span>
                        </div>
                    </div>

                    <!-- Formulaire de réservation -->
                    <form id="booking-form" class="hidden border-t border-gray-200 pt-4 mt-4">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.booking.date_label') }}</label>
                                <input type="date" name="date" id="booking-date" class="input-field" value="{{ $selectedDate->toDateString() }}" min="{{ now()->toDateString() }}" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.booking.time_label') }}</label>
                                <select name="time" id="booking-time" class="input-field" required>
                                    @foreach($timeSlots as $time)
                                        <option value="{{ $time }}">{{ $time }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.booking.notes_label') }}</label>
                                <textarea name="notes" id="booking-notes" rows="3" class="input-field" placeholder="{{ __('pages.booking.notes_placeholder') }}"></textarea>
                            </div>
                            <button type="submit" class="btn-primary w-full">
                                {{ __('pages.booking.confirm_booking') }}
                            </button>
                        </div>
                    </form>
                </div>

                <div class="glass-card p-6">
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-4">{{ __('pages.booking.choose_date') }}</h3>
                    <form method="GET" class="space-y-4">
                        <input type="hidden" name="category" value="{{ $selectedCategory }}">
                        <input type="date" name="date" min="{{ now()->toDateString() }}" value="{{ $selectedDate->toDateString() }}" class="input-field" onchange="this.form.submit()">
                    </form>
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
            </div>
        </div>
    </section>
</div>

<!-- Modal Auth pour les non-connectés -->
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

<!-- Modal Options du Service -->
@auth
<div id="service-options-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-serif text-2xl font-bold text-gray-900" id="options-modal-title">Options du service</h3>
                <p class="text-sm text-gray-600 mt-1">
                    <span id="options-modal-service-info"></span>
                </p>
            </div>
            <button type="button" class="text-gray-500 hover:text-gray-700" id="close-options-modal">✕</button>
        </div>

        <!-- Sélection de variante pour les groupes -->
        <div id="variant-selector" class="hidden mb-6 border-b border-gray-200 pb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Choisissez le type</label>
            <select id="variant-select" class="input-field">
                <!-- Options chargées dynamiquement -->
            </select>
        </div>

        <!-- Liste des options -->
        <div id="options-list" class="space-y-4 mb-6">
            <!-- Options chargées dynamiquement -->
        </div>

        <!-- Sélection du staff (optionnel) -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Praticien (optionnel)</label>
            <select id="options-staff-select" class="input-field">
                <option value="">Attribution automatique</option>
                @foreach($availableStaff as $staff)
                    <option value="{{ $staff->id }}">{{ $staff->name }} - {{ is_array($staff->role) ? implode(', ', $staff->role) : $staff->role }}</option>
                @endforeach
            </select>
        </div>

        <!-- Notes -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Notes pour ce service (optionnel)</label>
            <textarea id="options-notes" rows="2" class="input-field" placeholder="Demandes spéciales..."></textarea>
        </div>

        <!-- Bouton d'ajout -->
        <div class="flex gap-3">
            <button type="button" class="btn-secondary flex-1" id="cancel-options-btn">
                Annuler
            </button>
            <button type="button" class="btn-primary flex-1" id="add-to-cart-btn">
                Ajouter au panier
            </button>
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
    const optionsModal = document.getElementById('service-options-modal');
    const closeAuthBtns = document.querySelectorAll('[data-close-modal]');
    const closeOptionsBtn = document.getElementById('close-options-modal');
    const cancelOptionsBtn = document.getElementById('cancel-options-btn');
    const addToCartBtn = document.getElementById('add-to-cart-btn');
    const optionsModalTitle = document.getElementById('options-modal-title');
    const optionsModalServiceInfo = document.getElementById('options-modal-service-info');
    const optionsList = document.getElementById('options-list');
    const variantSelector = document.getElementById('variant-selector');
    const variantSelect = document.getElementById('variant-select');
    const optionsStaffSelect = document.getElementById('options-staff-select');
    const optionsNotes = document.getElementById('options-notes');
    const cartItemsList = document.getElementById('cart-items-list');
    const cartTotals = document.getElementById('cart-totals');
    const bookingForm = document.getElementById('booking-form');
    const clearCartBtn = document.getElementById('clear-cart-btn');

    // Gestion des onglets auth
    const loginPanel = document.getElementById('auth-login-panel');
    const registerPanel = document.getElementById('auth-register-panel');
    const loginTab = document.querySelector('[data-auth-tab="login"]');
    const registerTab = document.querySelector('[data-auth-tab="register"]');

    // État du panier
    const CART_STORAGE_KEY = 'booking_cart_items';
    let cart = []; // {serviceId, serviceName, price, duration, category, staffId, staffName, notes, options: [{optionId, name, price, duration, quantity}]}
    let currentService = null;
    let currentVariants = [];
    let selectedOptions = new Map(); // optionId -> quantity

    // Utilitaires
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

    // Event listeners auth
    if (loginTab && registerTab) {
      loginTab.addEventListener('click', () => setAuthTab('login'));
      registerTab.addEventListener('click', () => setAuthTab('register'));
    }

    closeAuthBtns.forEach((btn) => {
      btn.addEventListener('click', () => closeModal(authModal));
    });

    // Charger le panier depuis localStorage
    const loadCart = () => {
      try {
        const stored = localStorage.getItem(CART_STORAGE_KEY);
        if (stored) {
          cart = JSON.parse(stored);
        }
      } catch (e) {
        console.error('Erreur chargement panier:', e);
        cart = [];
      }
    };

    // Sauvegarder le panier
    const saveCart = () => {
      try {
        localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
      } catch (e) {
        console.error('Erreur sauvegarde panier:', e);
      }
    };

    // Ouvrir la modal d'options
    const openServiceOptionsModal = (service, variants = []) => {
      currentService = service;
      currentVariants = variants;
      selectedOptions.clear();

      if (optionsModalTitle) {
        optionsModalTitle.textContent = `Options pour ${service.name}`;
      }
      
      if (optionsModalServiceInfo) {
        optionsModalServiceInfo.textContent = `MAD ${service.price} • ${service.duration} min`;
      }

      // Si c'est un groupe avec variants
      if (variants.length > 0 && variantSelector && variantSelect) {
        variantSelector.classList.remove('hidden');
        variantSelect.innerHTML = variants.map((v, i) => 
          `<option value="${i}">${v.name} - MAD ${v.price} (${v.duration} min)</option>`
        ).join('');
        
        // Charger les options de la première variante
        variantSelect.addEventListener('change', () => {
          const selectedVariant = variants[parseInt(variantSelect.value)];
          if (selectedVariant) {
            currentService = {
              id: selectedVariant.id,
              name: selectedVariant.name,
              price: selectedVariant.price,
              duration: selectedVariant.duration,
              category: service.category,
              options: selectedVariant.options || []
            };
            renderOptions();
          }
        });
        
        // Initialiser avec la première variante
        currentService = {
          id: variants[0].id,
          name: variants[0].name,
          price: variants[0].price,
          duration: variants[0].duration,
          category: service.category,
          options: variants[0].options || []
        };
      } else {
        if (variantSelector) variantSelector.classList.add('hidden');
      }

      renderOptions();
      openModal(optionsModal);
    };

    // Render les options
    const renderOptions = () => {
      if (!optionsList || !currentService) return;

      const options = currentService.options || [];

      if (options.length === 0) {
        optionsList.innerHTML = '<p class="text-sm text-gray-500">Aucune option disponible pour ce service.</p>';
        return;
      }

      optionsList.innerHTML = options.map(option => {
        const currentQty = selectedOptions.get(option.id) || 0;
        return `
          <div class="border border-gray-200 rounded-lg p-4">
            <div class="flex justify-between items-start mb-3">
              <div class="flex-1">
                <div class="flex items-center gap-2">
                  <h4 class="font-semibold text-gray-900">${option.name}</h4>
                  ${option.is_required ? '<span class="badge badge-primary text-xs">Requis</span>' : ''}
                </div>
                ${option.description ? `<p class="text-sm text-gray-600 mt-1">${option.description}</p>` : ''}
              </div>
              <div class="text-right ml-3">
                <p class="font-bold text-primary">MAD ${option.price.toFixed(2)}</p>
                ${option.duration > 0 ? `<p class="text-xs text-gray-500">+${option.duration} min</p>` : ''}
              </div>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-sm text-gray-600">Max: ${option.max_quantity}</span>
              <div class="flex items-center gap-3">
                <button
                  type="button"
                  class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center font-bold"
                  data-option-decrease="${option.id}"
                  ${currentQty === 0 ? 'disabled' : ''}
                >
                  −
                </button>
                <span class="w-8 text-center font-semibold" data-option-qty="${option.id}">${currentQty}</span>
                <button
                  type="button"
                  class="w-8 h-8 rounded-full bg-primary hover:bg-primary-dark text-white flex items-center justify-center font-bold"
                  data-option-increase="${option.id}"
                  ${currentQty >= option.max_quantity ? 'disabled' : ''}
                >
                  +
                </button>
              </div>
            </div>
          </div>
        `;
      }).join('');

      // Attacher les événements
      attachOptionEvents();
    };

    // Attacher les événements sur les boutons +/-
    const attachOptionEvents = () => {
      if (!optionsList) return;

      optionsList.querySelectorAll('[data-option-increase]').forEach(btn => {
        btn.addEventListener('click', () => {
          const optionId = parseInt(btn.getAttribute('data-option-increase'));
          const option = currentService.options.find(opt => opt.id === optionId);
          if (!option) return;

          const currentQty = selectedOptions.get(optionId) || 0;
          if (currentQty < option.max_quantity) {
            selectedOptions.set(optionId, currentQty + 1);
            updateOptionDisplay(optionId);
          }
        });
      });

      optionsList.querySelectorAll('[data-option-decrease]').forEach(btn => {
        btn.addEventListener('click', () => {
          const optionId = parseInt(btn.getAttribute('data-option-decrease'));
          const currentQty = selectedOptions.get(optionId) || 0;
          
          if (currentQty > 0) {
            if (currentQty === 1) {
              selectedOptions.delete(optionId);
            } else {
              selectedOptions.set(optionId, currentQty - 1);
            }
            updateOptionDisplay(optionId);
          }
        });
      });
    };

    // Mettre à jour l'affichage d'une option
    const updateOptionDisplay = (optionId) => {
      const qtyEl = optionsList.querySelector(`[data-option-qty="${optionId}"]`);
      const increaseBtn = optionsList.querySelector(`[data-option-increase="${optionId}"]`);
      const decreaseBtn = optionsList.querySelector(`[data-option-decrease="${optionId}"]`);
      const option = currentService.options.find(opt => opt.id === optionId);
      
      const qty = selectedOptions.get(optionId) || 0;
      
      if (qtyEl) qtyEl.textContent = qty;
      if (increaseBtn) increaseBtn.disabled = qty >= option.max_quantity;
      if (decreaseBtn) decreaseBtn.disabled = qty === 0;
    };

    // Ajouter au panier
    const addServiceToCart = () => {
      if (!currentService) return;

      const staffId = optionsStaffSelect?.value || null;
      const staffName = staffId ? optionsStaffSelect.options[optionsStaffSelect.selectedIndex].text : null;
      const notes = optionsNotes?.value || '';

      const cartItem = {
        serviceId: currentService.id,
        serviceName: currentService.name,
        price: currentService.price,
        duration: currentService.duration,
        category: currentService.category,
        staffId: staffId,
        staffName: staffName,
        notes: notes,
        options: []
      };

      // Ajouter les options sélectionnées
      selectedOptions.forEach((quantity, optionId) => {
        const option = currentService.options.find(opt => opt.id === optionId);
        if (option) {
          cartItem.options.push({
            optionId: option.id,
            name: option.name,
            price: option.price,
            duration: option.duration,
            quantity: quantity
          });
        }
      });

      cart.push(cartItem);
      saveCart();
      renderCart();
      closeModal(optionsModal);
      
      // Reset
      selectedOptions.clear();
      if (optionsNotes) optionsNotes.value = '';
      if (optionsStaffSelect) optionsStaffSelect.value = '';
    };

    // Render le panier
    const renderCart = () => {
      if (!cartItemsList) return;

      if (cart.length === 0) {
        cartItemsList.innerHTML = '<p class="text-sm text-gray-500 text-center py-4">Aucun service sélectionné</p>';
        if (cartTotals) cartTotals.classList.add('hidden');
        if (bookingForm) bookingForm.classList.add('hidden');
        if (clearCartBtn) clearCartBtn.classList.add('hidden');
        return;
      }

      cartItemsList.innerHTML = cart.map((item, index) => {
        const optionsTotal = item.options.reduce((sum, opt) => sum + (opt.price * opt.quantity), 0);
        const itemTotal = item.price + optionsTotal;

        return `
          <div class="bg-gray-50 rounded-lg p-3">
            <div class="flex justify-between items-start mb-2">
              <div class="flex-1 min-w-0">
                <h4 class="font-semibold text-gray-900 text-sm truncate">${item.serviceName}</h4>
                <p class="text-xs text-gray-600">MAD ${item.price.toFixed(2)} • ${item.duration} min</p>
                ${item.staffName ? `<p class="text-xs text-gray-500">👤 ${item.staffName}</p>` : ''}
              </div>
              <button
                type="button"
                class="text-red-500 hover:text-red-700 ml-2"
                data-remove-cart-item="${index}"
              >
                ✕
              </button>
            </div>
            ${item.options.length > 0 ? `
              <div class="mt-2 space-y-1 border-t border-gray-200 pt-2">
                ${item.options.map(opt => `
                  <div class="flex justify-between text-xs text-gray-600 pl-2">
                    <span>+ ${opt.name} (×${opt.quantity})</span>
                    <span>MAD ${(opt.price * opt.quantity).toFixed(2)}</span>
                  </div>
                `).join('')}
              </div>
            ` : ''}
            <div class="mt-2 pt-2 border-t border-gray-200 flex justify-between items-center">
              <button
                type="button"
                class="text-xs text-primary hover:text-primary-dark"
                data-edit-cart-item="${index}"
              >
                ✏️ Modifier
              </button>
              <span class="text-sm font-bold text-gray-900">MAD ${itemTotal.toFixed(2)}</span>
            </div>
          </div>
        `;
      }).join('');

      // Calculer les totaux
      calculateTotals();

      // Afficher les sections
      if (cartTotals) cartTotals.classList.remove('hidden');
      if (bookingForm) bookingForm.classList.remove('hidden');
      if (clearCartBtn) clearCartBtn.classList.remove('hidden');

      // Attacher les événements
      attachCartEvents();
    };

    // Calculer les totaux
    const calculateTotals = () => {
      let subtotal = 0;
      let totalDuration = 0;

      cart.forEach(item => {
        const optionsTotal = item.options.reduce((sum, opt) => sum + (opt.price * opt.quantity), 0);
        const optionsDuration = item.options.reduce((sum, opt) => sum + (opt.duration * opt.quantity), 0);
        
        subtotal += item.price + optionsTotal;
        totalDuration += item.duration + optionsDuration;
      });

      const discount = 0; // TODO: Calculer via API pour les promotions
      const total = subtotal - discount;

      if (document.getElementById('cart-subtotal')) {
        document.getElementById('cart-subtotal').textContent = `MAD ${subtotal.toFixed(2)}`;
      }
      if (document.getElementById('cart-discount')) {
        document.getElementById('cart-discount').textContent = `- MAD ${discount.toFixed(2)}`;
      }
      if (document.getElementById('cart-total')) {
        document.getElementById('cart-total').textContent = `MAD ${total.toFixed(2)}`;
      }
      if (document.getElementById('cart-duration')) {
        document.getElementById('cart-duration').textContent = `${totalDuration} min`;
      }
    };

    // Attacher les événements du panier
    const attachCartEvents = () => {
      // Supprimer un item
      cartItemsList.querySelectorAll('[data-remove-cart-item]').forEach(btn => {
        btn.addEventListener('click', () => {
          const index = parseInt(btn.getAttribute('data-remove-cart-item'));
          cart.splice(index, 1);
          saveCart();
          renderCart();
        });
      });

      // Modifier un item
      cartItemsList.querySelectorAll('[data-edit-cart-item]').forEach(btn => {
        btn.addEventListener('click', () => {
          const index = parseInt(btn.getAttribute('data-edit-cart-item'));
          const item = cart[index];
          
          // Supprimer l'item et rouvrir la modal avec les données pré-remplies
          cart.splice(index, 1);
          saveCart();
          
          // Préparer le service avec les options pré-sélectionnées
          const service = {
            id: item.serviceId,
            name: item.serviceName,
            price: item.price,
            duration: item.duration,
            category: item.category,
            options: item.options.map(opt => ({
              id: opt.optionId,
              name: opt.name,
              price: opt.price,
              duration: opt.duration,
              max_quantity: 10 // Valeur par défaut
            }))
          };

          // Pré-remplir les options
          item.options.forEach(opt => {
            selectedOptions.set(opt.optionId, opt.quantity);
          });

          // Pré-remplir le staff et les notes
          if (optionsStaffSelect && item.staffId) {
            optionsStaffSelect.value = item.staffId;
          }
          if (optionsNotes && item.notes) {
            optionsNotes.value = item.notes;
          }

          openServiceOptionsModal(service);
        });
      });
    };

    // Event listeners modal options
    if (closeOptionsBtn) {
      closeOptionsBtn.addEventListener('click', () => {
        closeModal(optionsModal);
        selectedOptions.clear();
      });
    }

    if (cancelOptionsBtn) {
      cancelOptionsBtn.addEventListener('click', () => {
        closeModal(optionsModal);
        selectedOptions.clear();
      });
    }

    if (addToCartBtn) {
      addToCartBtn.addEventListener('click', addServiceToCart);
    }

    // Event listeners sur les boutons de service
    document.querySelectorAll('.js-book-service').forEach(btn => {
      btn.addEventListener('click', () => {
        if (!isAuth) {
          setAuthTab('login');
          openModal(authModal);
          return;
        }

        const service = {
          id: parseInt(btn.dataset.serviceId),
          name: btn.dataset.serviceName,
          price: parseFloat(btn.dataset.servicePrice),
          duration: parseInt(btn.dataset.serviceDuration),
          category: btn.dataset.serviceCategory,
          options: JSON.parse(btn.dataset.serviceOptions || '[]')
        };

        openServiceOptionsModal(service);
      });
    });

    // Event listeners sur les groupes
    document.querySelectorAll('.js-book-group').forEach(btn => {
      btn.addEventListener('click', () => {
        if (!isAuth) {
          setAuthTab('login');
          openModal(authModal);
          return;
        }

        const title = btn.dataset.groupTitle;
        const variants = JSON.parse(btn.dataset.variants || '[]');

        if (variants.length > 0) {
          const service = {
            id: variants[0].id,
            name: title,
            price: variants[0].price,
            duration: variants[0].duration,
            category: title,
            options: []
          };

          openServiceOptionsModal(service, variants);
        }
      });
    });

    // Vider le panier
    if (clearCartBtn) {
      clearCartBtn.addEventListener('click', () => {
        if (confirm('Voulez-vous vraiment vider le panier ?')) {
          cart = [];
          localStorage.removeItem(CART_STORAGE_KEY);
          renderCart();
        }
      });
    }

    // Soumettre la réservation
    if (bookingForm) {
      bookingForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (cart.length === 0) {
          alert('Votre panier est vide');
          return;
        }

        const formData = {
          date: document.getElementById('booking-date')?.value,
          time: document.getElementById('booking-time')?.value,
          notes: document.getElementById('booking-notes')?.value || '',
          items: cart.map(item => ({
            service_id: item.serviceId,
            staff_id: item.staffId || null,
            quantity: 1,
            notes: item.notes || '',
            options: item.options.map(opt => ({
              option_id: opt.optionId,
              quantity: opt.quantity
            }))
          }))
        };

        try {
          const submitBtn = bookingForm.querySelector('button[type="submit"]');
          submitBtn.disabled = true;
          submitBtn.textContent = 'Création en cours...';

          const response = await fetch('/api/bookings', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify(formData)
          });

          const data = await response.json();

          if (response.ok && data.success) {
            // Vider le panier
            cart = [];
            localStorage.removeItem(CART_STORAGE_KEY);
            
            // Afficher le succès et rediriger
            alert(`Réservation créée avec succès!\nRéférence: ${data.data.booking_reference}`);
            window.location.href = '/client/dashboard';
          } else {
            throw new Error(data.message || 'Erreur lors de la création de la réservation');
          }
        } catch (error) {
          console.error('Erreur:', error);
          alert(error.message || 'Une erreur est survenue lors de la création de la réservation');
          
          const submitBtn = bookingForm.querySelector('button[type="submit"]');
          submitBtn.disabled = false;
          submitBtn.textContent = '{{ __("pages.booking.confirm_booking") }}';
        }
      });
    }

    // Initialiser
    loadCart();
    renderCart();
  })();
</script>
@endpush
@endsection
