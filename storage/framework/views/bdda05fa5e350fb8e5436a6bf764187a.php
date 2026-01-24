

<?php $__env->startSection('title', 'Réserver vos services'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <!-- Message de succès -->
    <?php if(session('booking_success')): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
        <div class="glass-card p-4 bg-green-50 border-l-4 border-green-500">
            <div class="flex items-center">
                <span class="text-2xl mr-3">✅</span>
                <div>
                    <p class="font-semibold text-green-800">Réservation créée avec succès !</p>
                    <p class="text-sm text-green-700">Référence: <?php echo e(session('booking_reference')); ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="font-serif text-5xl font-bold mb-4">📅 Réservez vos services</h1>
                <p class="text-xl max-w-2xl mx-auto">Sélectionnez plusieurs services et profitez de nos promotions</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <?php
            $promoData = $promotions->map(function ($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'discount' => (float) $p->discount,
                    'type' => $p->type,
                    'applicable_services' => is_array($p->applicable_services) ? $p->applicable_services : [],
                    'code' => $p->code,
                ];
            })->values();
        ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" id="pack-builder">
            <div class="lg:col-span-2">
                <!-- Filters -->
                <div class="glass-card p-6 mb-6">
                    <h2 class="font-serif text-2xl font-bold text-gray-900 mb-4">📅 Réservez vos services</h2>
                    <p class="text-gray-600 text-sm mb-6">Sélectionnez plusieurs services. Si une promotion est active, la remise s'applique automatiquement.</p>
                    
                    <!-- Search Bar -->
                    <form method="GET" action="<?php echo e(route('packs')); ?>" class="mb-6">
                        <div class="relative">
                            <input
                                type="text"
                                name="search"
                                value="<?php echo e($searchQuery); ?>"
                                class="input-field pl-10 w-full"
                                placeholder="Rechercher un service..."
                            >
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">🔍</span>
                            <input type="hidden" name="category" value="<?php echo e($selectedCategory); ?>">
                        </div>
                    </form>

                    <!-- Category Filters with Icons -->
                    <?php
                        $categoryIcons = [
                            'all' => ['icon' => '✨', 'label' => 'Tous', 'color' => 'from-purple-500 to-pink-500'],
                            'Hammam' => ['icon' => '🧖‍♂️', 'label' => 'Hammam', 'color' => 'from-blue-500 to-cyan-500'],
                            'Soins' => ['icon' => '💆‍♂️', 'label' => 'Soins', 'color' => 'from-green-500 to-emerald-500'],
                            'Massage' => ['icon' => '🌺', 'label' => 'Massage', 'color' => 'from-pink-500 to-rose-500'],
                            'Hijama' => ['icon' => '🩺', 'label' => 'Hijama', 'color' => 'from-red-500 to-orange-500'],
                            'Gommage' => ['icon' => '✨', 'label' => 'Gommage', 'color' => 'from-yellow-500 to-amber-500'],
                            'Épilation' => ['icon' => '💅', 'label' => 'Épilation', 'color' => 'from-indigo-500 to-purple-500'],
                        ];
                    ?>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        <?php
                            $catAll = $categoryIcons['all'];
                            $isAllActive = $selectedCategory === 'all';
                        ?>
                        <a href="<?php echo e(route('packs', ['category' => 'all', 'search' => request('search')])); ?>" 
                           class="relative overflow-hidden rounded-xl p-4 transition-all duration-300 transform hover:scale-105 <?php echo e($isAllActive ? 'ring-2 ring-primary shadow-lg' : 'hover:shadow-md'); ?>">
                            <div class="absolute inset-0 bg-gradient-to-br <?php echo e($catAll['color']); ?> opacity-<?php echo e($isAllActive ? '100' : '20'); ?>"></div>
                            <div class="relative flex flex-col items-center text-center">
                                <span class="text-3xl mb-2"><?php echo e($catAll['icon']); ?></span>
                                <span class="text-sm font-semibold <?php echo e($isAllActive ? 'text-white' : 'text-gray-900'); ?>"><?php echo e($catAll['label']); ?></span>
                                <?php if($isAllActive): ?>
                                    <span class="absolute top-0 right-0 w-6 h-6 bg-white rounded-full flex items-center justify-center">
                                        <span class="text-xs">✓</span>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </a>

                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $catInfo = $categoryIcons[$category] ?? ['icon' => '⭐', 'label' => $category, 'color' => 'from-gray-500 to-gray-600'];
                                $isActive = $selectedCategory === $category;
                            ?>
                            <a href="<?php echo e(route('packs', ['category' => $category, 'search' => request('search')])); ?>" 
                               class="relative overflow-hidden rounded-xl p-4 transition-all duration-300 transform hover:scale-105 <?php echo e($isActive ? 'ring-2 ring-primary shadow-lg' : 'hover:shadow-md'); ?>">
                                <div class="absolute inset-0 bg-gradient-to-br <?php echo e($catInfo['color']); ?> opacity-<?php echo e($isActive ? '100' : '20'); ?>"></div>
                                <div class="relative flex flex-col items-center text-center">
                                    <span class="text-3xl mb-2"><?php echo e($catInfo['icon']); ?></span>
                                    <span class="text-sm font-semibold <?php echo e($isActive ? 'text-white' : 'text-gray-900'); ?>"><?php echo e($catInfo['label']); ?></span>
                                    <?php if($isActive): ?>
                                        <span class="absolute top-0 right-0 w-6 h-6 bg-white rounded-full flex items-center justify-center">
                                            <span class="text-xs">✓</span>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <?php if(request()->filled('search') || (request()->filled('category') && request('category') !== 'all')): ?>
                        <div class="mt-4 flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                            <span class="text-sm text-gray-700">
                                <strong><?php echo e($services->count()); ?></strong> service(s) trouvé(s)
                                <?php if(request()->filled('search')): ?>
                                    pour "<strong><?php echo e($searchQuery); ?></strong>"
                                <?php endif; ?>
                            </span>
                            <a href="<?php echo e(route('packs')); ?>" class="text-sm text-primary hover:text-primary-dark font-medium">
                                ✕ Réinitialiser
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if($services->count() > 0): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button
                                type="button"
                                class="glass-card overflow-hidden text-left hover:ring-2 hover:ring-primary js-pack-service"
                                data-service-id="<?php echo e($service->id); ?>"
                                data-service-name="<?php echo e($service->name); ?>"
                                data-service-category="<?php echo e($service->category); ?>"
                                data-service-price="<?php echo e($service->price); ?>"
                                data-service-duration="<?php echo e($service->duration); ?>"
                            >
                                <div class="relative h-40 overflow-hidden">
                                    <img src="<?php echo e($service->image ?? 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400'); ?>" alt="<?php echo e($service->name); ?>" class="w-full h-full object-cover">
                                    <div class="absolute top-3 right-3">
                                        <span class="badge badge-primary"><?php echo e($service->category); ?></span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <h3 class="font-serif text-lg font-bold text-gray-900 mb-1"><?php echo e($service->name); ?></h3>
                                            <p class="text-gray-600 text-sm line-clamp-2"><?php echo e($service->description); ?></p>
                                        </div>
                                        <span class="badge badge-success js-selected-badge hidden">✓</span>
                                    </div>
                                    <div class="flex items-center justify-between mt-3 text-sm text-gray-700">
                                        <span>⏱️ <?php echo e($service->duration); ?> <?php echo e(__('pages.common.minutes')); ?></span>
                                        <span class="text-primary font-bold">MAD <?php echo e($service->price); ?></span>
                                    </div>
                                </div>
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="glass-card p-8 text-center">
                        <div class="text-4xl mb-3">🔍</div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Aucun service trouvé</h3>
                        <p class="text-gray-600 mb-4">
                            Aucun service ne correspond à vos critères de recherche.
                        </p>
                        <a href="<?php echo e(route('packs')); ?>" class="btn-primary inline-block">
                            Voir tous les services
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="space-y-6">
                <div class="glass-card p-6 sticky top-4">
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-4">Votre sélection</h3>
                    <div id="pack-selected-list" class="space-y-2">
                        <p class="text-sm text-gray-600">Aucun service sélectionné.</p>
                    </div>

                    <div class="border-t border-gray-100 mt-5 pt-4 space-y-2 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Total</span>
                            <span class="font-semibold text-gray-900" id="pack-total">MAD 0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Remise</span>
                            <span class="font-semibold text-green-700" id="pack-discount">MAD 0</span>
                        </div>
                        <div class="flex items-center justify-between text-base">
                            <span class="text-gray-900 font-bold">À payer</span>
                            <span class="text-primary font-bold" id="pack-final">MAD 0</span>
                        </div>
                        <div class="text-xs text-gray-500" id="pack-promo-note"></div>
                    </div>

                    <!-- Formulaire de réservation -->
                    <div id="booking-form-section" class="hidden border-t border-gray-100 mt-5 pt-5">
                        <h4 class="font-semibold text-gray-900 mb-4">📅 Informations de réservation</h4>
                        <form id="booking-form" class="space-y-4">
                            <?php echo csrf_field(); ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                                <input type="date" id="booking-date" class="input-field" min="<?php echo e(now()->toDateString()); ?>" value="<?php echo e(now()->toDateString()); ?>" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Heure</label>
                                <select id="booking-time" class="input-field" required>
                                    <option value="">Choisir une heure</option>
                                    <option value="09:00">09:00</option>
                                    <option value="09:30">09:30</option>
                                    <option value="10:00">10:00</option>
                                    <option value="10:30">10:30</option>
                                    <option value="11:00">11:00</option>
                                    <option value="11:30">11:30</option>
                                    <option value="12:00">12:00</option>
                                    <option value="12:30">12:30</option>
                                    <option value="14:00">14:00</option>
                                    <option value="14:30">14:30</option>
                                    <option value="15:00">15:00</option>
                                    <option value="15:30">15:30</option>
                                    <option value="16:00">16:00</option>
                                    <option value="16:30">16:30</option>
                                    <option value="17:00">17:00</option>
                                    <option value="17:30">17:30</option>
                                    <option value="18:00">18:00</option>
                                    <option value="18:30">18:30</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Notes (optionnel)</label>
                                <textarea id="booking-notes" rows="2" class="input-field" placeholder="Demandes spéciales..."></textarea>
                            </div>
                        </form>
                    </div>

                    <button type="button" class="btn-primary w-full mt-5 disabled:opacity-50 disabled:cursor-not-allowed" id="pack-book-btn" disabled>
                        ✅ Confirmer ma réservation
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
  (function () {
    const cards = Array.from(document.querySelectorAll('.js-pack-service'));
    const list = document.getElementById('pack-selected-list');
    const totalEl = document.getElementById('pack-total');
    const discountEl = document.getElementById('pack-discount');
    const finalEl = document.getElementById('pack-final');
    const promoNoteEl = document.getElementById('pack-promo-note');
    const bookBtn = document.getElementById('pack-book-btn');

    const promotions = <?php echo json_encode($promoData, 15, 512) ?>;
    const STORAGE_KEY = 'pack_selected_services';
    const selected = new Map(); // id -> {id,name,category,price,duration,promo}

    // Charger les sélections depuis le localStorage
    const loadSelectedFromStorage = () => {
      try {
        const stored = localStorage.getItem(STORAGE_KEY);
        if (stored) {
          const data = JSON.parse(stored);
          Object.entries(data).forEach(([id, service]) => {
            selected.set(id, service);
          });
        }
      } catch (e) {
        console.error('Erreur lors du chargement des sélections:', e);
      }
    };

    // Sauvegarder les sélections dans le localStorage
    const saveSelectedToStorage = () => {
      try {
        const data = {};
        selected.forEach((service, id) => {
          data[id] = service;
        });
        localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
      } catch (e) {
        console.error('Erreur lors de la sauvegarde des sélections:', e);
      }
    };

    // Restaurer l'état visuel des cartes sélectionnées
    const restoreVisualState = () => {
      cards.forEach((card) => {
        const id = String(card.dataset.serviceId || '');
        if (selected.has(id)) {
          card.classList.add('ring-2', 'ring-primary');
          const badge = card.querySelector('.js-selected-badge');
          if (badge) badge.classList.remove('hidden');
        }
      });
    };

    const toNumber = (v) => {
      const n = Number(v);
      return Number.isFinite(n) ? n : 0;
    };

    const isPromotionApplicable = (promotion, service) => {
      const list = Array.isArray(promotion?.applicable_services) ? promotion.applicable_services : [];
      return list.some((x) => {
        if (typeof x === 'number') return String(x) === String(service.id);
        if (typeof x === 'string') return x === service.category || x === String(service.id);
        return false;
      });
    };

    const calcBestPromotion = (service) => {
      let best = null;
      let bestDiscount = 0;
      promotions.forEach((p) => {
        if (!isPromotionApplicable(p, service)) return;
        let amount = 0;
        if (p.type === 'percentage') amount = (service.price * toNumber(p.discount)) / 100;
        else amount = toNumber(p.discount);
        amount = Math.max(0, Math.min(amount, service.price));
        if (amount > bestDiscount) {
          bestDiscount = amount;
          best = p;
        }
      });
      return best ? { promo: best, discountAmount: bestDiscount } : { promo: null, discountAmount: 0 };
    };

    const render = () => {
      if (!list) return;
      if (selected.size === 0) {
        list.innerHTML = `<p class="text-sm text-gray-600">Aucun service sélectionné.</p>`;
        if (bookBtn) bookBtn.disabled = true;
        if (promoNoteEl) promoNoteEl.textContent = '';
        if (totalEl) totalEl.textContent = 'MAD 0';
        if (discountEl) discountEl.textContent = 'MAD 0';
        if (finalEl) finalEl.textContent = 'MAD 0';
        
        // Cacher le formulaire de réservation
        const bookingFormSection = document.getElementById('booking-form-section');
        if (bookingFormSection) bookingFormSection.classList.add('hidden');
        
        saveSelectedToStorage();
        return;
      }

      let total = 0;
      let discount = 0;
      const promoCodes = new Set();
      list.innerHTML = '';

      selected.forEach((s) => {
        total += s.price;
        discount += s.discountAmount || 0;
        if (s.promo?.code) promoCodes.add(s.promo.code);

        const row = document.createElement('div');
        row.className = 'flex items-start justify-between gap-3 bg-gray-50 rounded-lg px-3 py-2 text-sm';
        row.innerHTML = `
          <div class="min-w-0">
            <div class="font-medium text-gray-900 truncate">${s.name}</div>
            <div class="text-gray-500">${s.category} • ${s.duration} min</div>
          </div>
          <div class="text-right">
            <div class="font-semibold text-gray-900">MAD ${s.price.toFixed(2)}</div>
            ${s.discountAmount ? `<div class="text-xs text-green-700">- MAD ${s.discountAmount.toFixed(2)}</div>` : ''}
            <button type="button" class="text-red-500 hover:text-red-600 text-xs mt-1" data-remove="${s.id}">Retirer</button>
          </div>
        `;
        list.appendChild(row);
      });

      const final = Math.max(0, total - discount);
      if (totalEl) totalEl.textContent = `MAD ${total.toFixed(2)}`;
      if (discountEl) discountEl.textContent = `MAD ${discount.toFixed(2)}`;
      if (finalEl) finalEl.textContent = `MAD ${final.toFixed(2)}`;
      if (bookBtn) bookBtn.disabled = false;
      if (promoNoteEl) {
        promoNoteEl.textContent = promoCodes.size ? `Promotions: ${Array.from(promoCodes).join(', ')}` : '';
      }
      
      // Afficher le formulaire de réservation
      const bookingFormSection = document.getElementById('booking-form-section');
      if (bookingFormSection) bookingFormSection.classList.remove('hidden');
      
      // Sauvegarder après chaque modification
      saveSelectedToStorage();
    };

    if (list) {
      list.addEventListener('click', (event) => {
        const btn = event.target.closest('[data-remove]');
        if (!btn) return;
        const id = btn.getAttribute('data-remove');
        selected.delete(String(id));
        const card = cards.find((c) => String(c.dataset.serviceId) === String(id));
        if (card) {
          card.classList.remove('ring-2', 'ring-primary');
          const badge = card.querySelector('.js-selected-badge');
          if (badge) badge.classList.add('hidden');
        }
        render();
      });
    }

    cards.forEach((card) => {
      card.addEventListener('click', () => {
        const id = String(card.dataset.serviceId || '');
        if (!id) return;
        if (selected.has(id)) {
          selected.delete(id);
          card.classList.remove('ring-2', 'ring-primary');
          const badge = card.querySelector('.js-selected-badge');
          if (badge) badge.classList.add('hidden');
          render();
          return;
        }

        const service = {
          id,
          name: card.dataset.serviceName || '',
          category: card.dataset.serviceCategory || '',
          price: toNumber(card.dataset.servicePrice),
          duration: toNumber(card.dataset.serviceDuration),
        };
        const { promo, discountAmount } = calcBestPromotion(service);
        selected.set(id, { ...service, promo, discountAmount });
        card.classList.add('ring-2', 'ring-primary');
        const badge = card.querySelector('.js-selected-badge');
        if (badge) badge.classList.remove('hidden');
        render();
      });
    });

    if (bookBtn) {
      bookBtn.addEventListener('click', async () => {
        if (selected.size === 0) return;
        
        // Vérifier si l'utilisateur est connecté
        <?php if(auth()->guard()->guest()): ?>
        if (confirm('Vous devez être connecté pour réserver. Voulez-vous vous connecter maintenant ?')) {
          window.location.href = '<?php echo e(route('login')); ?>';
        }
        return;
        <?php endif; ?>
        
        // Récupérer les données du formulaire
        const date = document.getElementById('booking-date')?.value;
        const time = document.getElementById('booking-time')?.value;
        const notes = document.getElementById('booking-notes')?.value || '';
        
        if (!date || !time) {
          alert('Veuillez remplir la date et l\'heure de réservation');
          return;
        }
        
        // Préparer les données pour l'API
        const bookingData = {
          date: date,
          time: time,
          notes: notes,
          items: Array.from(selected.values()).map(service => ({
            service_id: parseInt(service.id),
            quantity: 1,
            notes: '',
            options: []
          }))
        };
        
        try {
          bookBtn.disabled = true;
          bookBtn.textContent = 'Création en cours...';
          
          const response = await fetch('/api/bookings', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify(bookingData)
          });
          
          const data = await response.json();
          
          if (response.ok && data.success) {
            // Vider le panier et le localStorage
            selected.clear();
            localStorage.removeItem(STORAGE_KEY);
            
            alert(`✅ Réservation créée avec succès!\nRéférence: ${data.data.booking_reference}`);
            window.location.href = '/client/dashboard';
          } else {
            throw new Error(data.message || 'Erreur lors de la création de la réservation');
          }
        } catch (error) {
          console.error('Erreur:', error);
          alert('❌ ' + (error.message || 'Une erreur est survenue lors de la création de la réservation'));
          bookBtn.disabled = false;
          bookBtn.textContent = '✅ Confirmer ma réservation';
        }
      });
    }

    // Ajouter un bouton pour vider la sélection
    const addClearButton = () => {
      if (selected.size === 0) return;
      const clearBtn = document.createElement('button');
      clearBtn.type = 'button';
      clearBtn.className = 'text-sm text-red-600 hover:text-red-700 mt-2';
      clearBtn.textContent = 'Vider la sélection';
      clearBtn.addEventListener('click', () => {
        if (confirm('Voulez-vous vraiment vider votre sélection ?')) {
          selected.clear();
          localStorage.removeItem(STORAGE_KEY);
          cards.forEach((card) => {
            card.classList.remove('ring-2', 'ring-primary');
            const badge = card.querySelector('.js-selected-badge');
            if (badge) badge.classList.add('hidden');
          });
          render();
        }
      });
      
      const existingBtn = list.parentElement.querySelector('.clear-selection-btn');
      if (existingBtn) existingBtn.remove();
      
      if (selected.size > 0) {
        clearBtn.classList.add('clear-selection-btn');
        list.parentElement.insertBefore(clearBtn, list);
      }
    };

    // Initialiser
    loadSelectedFromStorage();
    restoreVisualState();
    render();
    addClearButton();
  })();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/pages/packs.blade.php ENDPATH**/ ?>