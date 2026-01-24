

<?php $__env->startSection('title', 'Réservation avec Panier'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50" id="booking-cart-page">
    <!-- Hero Section -->
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="font-serif text-5xl font-bold mb-4">Réservez vos Services</h1>
                <p class="text-xl max-w-2xl mx-auto">Sélectionnez plusieurs services et personnalisez votre expérience avec des options</p>
            </div>
        </div>
    </section>

    <!-- Messages -->
    <div id="message-container" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6"></div>

    <!-- Main Content -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Services Catalog -->
            <div class="lg:col-span-2">
                <!-- Filters -->
                <div class="mb-6">
                    <div class="flex flex-col sm:flex-row gap-4 mb-4">
                        <div class="relative flex-1">
                            <input
                                type="text"
                                id="service-search"
                                class="input-field pl-10"
                                placeholder="Rechercher un service..."
                            >
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">🔍</span>
                        </div>
                        <select id="category-filter" class="input-field sm:w-48">
                            <option value="">Toutes catégories</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category); ?>"><?php echo e($category); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <!-- Services Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="services-grid">
                    <!-- Services will be loaded here dynamically -->
                    <div class="col-span-full flex justify-center items-center py-12">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
                    </div>
                </div>
            </div>

            <!-- Cart Sidebar -->
            <div class="space-y-6">
                <!-- Cart -->
                <div class="glass-card p-6 sticky top-4">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-serif text-2xl font-bold text-gray-900">Votre Panier</h2>
                        <button id="clear-cart-btn" class="text-sm text-red-600 hover:text-red-700 hidden">
                            Vider
                        </button>
                    </div>

                    <!-- Cart Items -->
                    <div id="cart-items" class="space-y-4 mb-6">
                        <p class="text-gray-500 text-sm text-center py-8">Votre panier est vide</p>
                    </div>

                    <!-- Totals -->
                    <div id="cart-totals" class="border-t border-gray-200 pt-4 space-y-2 hidden">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Sous-total</span>
                            <span id="subtotal-amount">MAD 0.00</span>
                        </div>
                        <div class="flex justify-between text-sm text-green-600">
                            <span>Réduction</span>
                            <span id="discount-amount">- MAD 0.00</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t">
                            <span>Total</span>
                            <span id="total-amount">MAD 0.00</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Durée totale</span>
                            <span id="total-duration">0 min</span>
                        </div>
                    </div>

                    <!-- Booking Form -->
                    <div id="booking-form-section" class="hidden border-t border-gray-200 pt-4 mt-4">
                        <form id="booking-form" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                                <input
                                    type="date"
                                    id="booking-date"
                                    name="date"
                                    min="<?php echo e(now()->toDateString()); ?>"
                                    value="<?php echo e(now()->addDay()->toDateString()); ?>"
                                    class="input-field"
                                    required
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Heure</label>
                                <select id="booking-time" name="time" class="input-field" required>
                                    <?php $__currentLoopData = ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($time); ?>"><?php echo e($time); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Notes (optionnel)</label>
                                <textarea
                                    id="booking-notes"
                                    name="notes"
                                    rows="3"
                                    class="input-field"
                                    placeholder="Informations complémentaires..."
                                ></textarea>
                            </div>
                            <button type="submit" class="btn-primary w-full">
                                Confirmer la réservation
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Options -->
<div id="options-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-serif text-2xl font-bold text-gray-900" id="options-modal-title">Options disponibles</h3>
            <button type="button" class="text-gray-500 hover:text-gray-700" id="close-options-modal">✕</button>
        </div>

        <div id="options-list" class="space-y-4">
            <!-- Options will be loaded here -->
        </div>

        <div class="mt-6 pt-4 border-t border-gray-200">
            <button type="button" class="btn-primary w-full" id="confirm-options-btn">
                Confirmer les options
            </button>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/booking-cart.js')); ?>"></script>
<script>
(async function() {
    const cart = window.bookingCart;
    if (!cart) {
        console.error('BookingCart non initialisé');
        return;
    }

    // Éléments DOM
    const servicesGrid = document.getElementById('services-grid');
    const cartItems = document.getElementById('cart-items');
    const cartTotals = document.getElementById('cart-totals');
    const bookingFormSection = document.getElementById('booking-form-section');
    const bookingForm = document.getElementById('booking-form');
    const clearCartBtn = document.getElementById('clear-cart-btn');
    const serviceSearch = document.getElementById('service-search');
    const categoryFilter = document.getElementById('category-filter');
    const messageContainer = document.getElementById('message-container');
    const optionsModal = document.getElementById('options-modal');
    const closeOptionsModal = document.getElementById('close-options-modal');
    const optionsList = document.getElementById('options-list');
    const optionsModalTitle = document.getElementById('options-modal-title');
    const confirmOptionsBtn = document.getElementById('confirm-options-btn');

    let currentItemIndex = -1;

    // Initialiser le panier
    await cart.init();

    // Charger les services au démarrage
    loadServices();

    // Event listeners pour les filtres
    let searchTimeout;
    serviceSearch?.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => loadServices(), 300);
    });

    categoryFilter?.addEventListener('change', () => loadServices());

    // Charger les services
    async function loadServices() {
        const search = serviceSearch?.value || null;
        const category = categoryFilter?.value || null;

        try {
            const services = await cart.loadServices(category, search);
            renderServices(services);
        } catch (error) {
            showMessage('Erreur lors du chargement des services', 'error');
        }
    }

    // Render les services
    function renderServices(services) {
        if (!servicesGrid) return;

        if (services.length === 0) {
            servicesGrid.innerHTML = '<div class="col-span-full text-center text-gray-500 py-12">Aucun service trouvé</div>';
            return;
        }

        servicesGrid.innerHTML = services.map(service => `
            <div class="glass-card overflow-hidden">
                <div class="relative h-40 overflow-hidden">
                    <img src="${service.image || 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400'}" 
                         alt="${service.name}" 
                         class="w-full h-full object-cover">
                    <div class="absolute top-3 right-3">
                        <span class="badge badge-primary">${service.category}</span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-serif text-lg font-bold text-gray-900 mb-2">${service.name}</h3>
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">${service.description || ''}</p>
                    <div class="flex items-center justify-between mb-3 text-sm text-gray-700">
                        <span>⏱️ ${service.duration} min</span>
                        <span class="text-primary font-bold">MAD ${service.price}</span>
                    </div>
                    ${service.options && service.options.length > 0 ? `
                        <p class="text-xs text-gray-500 mb-2">✨ ${service.options.length} option(s) disponible(s)</p>
                    ` : ''}
                    <button
                        type="button"
                        class="w-full btn-primary"
                        data-add-service="${service.id}"
                    >
                        Ajouter au panier
                    </button>
                </div>
            </div>
        `).join('');

        // Attacher les événements
        servicesGrid.querySelectorAll('[data-add-service]').forEach(btn => {
            btn.addEventListener('click', () => {
                const serviceId = parseInt(btn.getAttribute('data-add-service'));
                cart.addService(serviceId);
            });
        });
    }

    // Event listener: panier mis à jour
    document.addEventListener('cartUpdated', (e) => {
        const { cart: cartData, itemCount } = e.detail;
        renderCartItems(cartData);
        
        // Afficher/masquer le bouton vider le panier
        if (clearCartBtn) {
            clearCartBtn.classList.toggle('hidden', itemCount === 0);
        }

        // Afficher/masquer le formulaire de réservation
        if (bookingFormSection) {
            bookingFormSection.classList.toggle('hidden', itemCount === 0);
        }

        // Calculer les totaux
        cart.calculateTotals();
    });

    // Event listener: totaux mis à jour
    document.addEventListener('totalsUpdated', (e) => {
        const totals = e.detail;
        renderTotals(totals);
    });

    // Event listener: afficher les options
    document.addEventListener('showServiceOptions', (e) => {
        const { serviceId, itemIndex, options, currentOptions } = e.detail;
        currentItemIndex = itemIndex;
        showOptionsModal(serviceId, options, currentOptions);
    });

    // Event listener: erreur
    document.addEventListener('cartError', (e) => {
        showMessage(e.detail.message, 'error');
    });

    // Event listener: succès
    document.addEventListener('cartSuccess', (e) => {
        showMessage(e.detail.message, 'success');
        
        // Rediriger vers la page de confirmation après 2 secondes
        setTimeout(() => {
            window.location.href = '/bookings';
        }, 2000);
    });

    // Render les items du panier
    function renderCartItems(cartData) {
        if (!cartItems) return;

        if (cartData.length === 0) {
            cartItems.innerHTML = '<p class="text-gray-500 text-sm text-center py-8">Votre panier est vide</p>';
            if (cartTotals) cartTotals.classList.add('hidden');
            return;
        }

        cartItems.innerHTML = cartData.map((item, index) => `
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-900">${item.service_name}</h4>
                        <p class="text-sm text-gray-600">MAD ${item.service_price} × ${item.quantity}</p>
                    </div>
                    <button
                        type="button"
                        class="text-red-500 hover:text-red-700 text-sm"
                        data-remove-item="${index}"
                    >
                        ✕
                    </button>
                </div>

                ${item.options.length > 0 ? `
                    <div class="mt-2 space-y-1">
                        ${item.options.map((opt, optIndex) => `
                            <div class="flex justify-between items-center text-xs text-gray-600 pl-4">
                                <span>+ ${opt.option_name} (×${opt.quantity})</span>
                                <div class="flex items-center gap-2">
                                    <span>MAD ${(opt.option_price * opt.quantity).toFixed(2)}</span>
                                    <button
                                        type="button"
                                        class="text-red-500 hover:text-red-700"
                                        data-remove-option="${index}-${optIndex}"
                                    >
                                        ✕
                                    </button>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                ` : ''}

                <button
                    type="button"
                    class="text-xs text-primary hover:text-primary-dark mt-2"
                    data-show-options="${index}"
                >
                    + Ajouter des options
                </button>
            </div>
        `).join('');

        // Attacher les événements
        cartItems.querySelectorAll('[data-remove-item]').forEach(btn => {
            btn.addEventListener('click', () => {
                const index = parseInt(btn.getAttribute('data-remove-item'));
                cart.removeService(index);
            });
        });

        cartItems.querySelectorAll('[data-remove-option]').forEach(btn => {
            btn.addEventListener('click', () => {
                const [itemIndex, optIndex] = btn.getAttribute('data-remove-option').split('-').map(Number);
                cart.removeOptionFromItem(itemIndex, optIndex);
            });
        });

        cartItems.querySelectorAll('[data-show-options]').forEach(btn => {
            btn.addEventListener('click', () => {
                const index = parseInt(btn.getAttribute('data-show-options'));
                const item = cartData[index];
                cart.showServiceOptions(item.service_id);
            });
        });
    }

    // Render les totaux
    function renderTotals(totals) {
        if (!cartTotals) return;

        cartTotals.classList.remove('hidden');
        
        const subtotalEl = document.getElementById('subtotal-amount');
        const discountEl = document.getElementById('discount-amount');
        const totalEl = document.getElementById('total-amount');
        const durationEl = document.getElementById('total-duration');

        if (subtotalEl) subtotalEl.textContent = `MAD ${totals.subtotal.toFixed(2)}`;
        if (discountEl) discountEl.textContent = `- MAD ${totals.discount_total.toFixed(2)}`;
        if (totalEl) totalEl.textContent = `MAD ${totals.total.toFixed(2)}`;
        if (durationEl) durationEl.textContent = `${totals.total_duration} min`;
    }

    // Afficher la modal des options
    function showOptionsModal(serviceId, options, currentOptions) {
        if (!optionsModal || !optionsList) return;

        const service = cart.services.get(serviceId);
        if (!service) return;

        optionsModalTitle.textContent = `Options pour ${service.name}`;

        optionsList.innerHTML = options.map(option => {
            const currentOpt = currentOptions.find(opt => opt.option_id === option.id);
            const currentQty = currentOpt ? currentOpt.quantity : 0;

            return `
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h4 class="font-semibold text-gray-900">${option.name}</h4>
                            ${option.description ? `<p class="text-sm text-gray-600">${option.description}</p>` : ''}
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-primary">MAD ${option.price}</p>
                            ${option.duration > 0 ? `<p class="text-xs text-gray-500">+${option.duration} min</p>` : ''}
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Max: ${option.max_quantity}</span>
                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center"
                                data-option-decrease="${option.id}"
                                ${currentQty === 0 ? 'disabled' : ''}
                            >
                                −
                            </button>
                            <span class="w-8 text-center font-semibold" data-option-qty="${option.id}">${currentQty}</span>
                            <button
                                type="button"
                                class="w-8 h-8 rounded-full bg-primary hover:bg-primary-dark text-white flex items-center justify-center"
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
        optionsList.querySelectorAll('[data-option-increase]').forEach(btn => {
            btn.addEventListener('click', () => {
                const optionId = parseInt(btn.getAttribute('data-option-increase'));
                cart.addOptionToItem(currentItemIndex, optionId, 1);
                // Actualiser l'affichage
                const qtyEl = optionsList.querySelector(`[data-option-qty="${optionId}"]`);
                if (qtyEl) qtyEl.textContent = parseInt(qtyEl.textContent) + 1;
                updateOptionButtons(optionId);
            });
        });

        optionsList.querySelectorAll('[data-option-decrease]').forEach(btn => {
            btn.addEventListener('click', () => {
                const optionId = parseInt(btn.getAttribute('data-option-decrease'));
                const item = cart.cart[currentItemIndex];
                const optIndex = item.options.findIndex(opt => opt.option_id === optionId);
                if (optIndex >= 0) {
                    const currentQty = item.options[optIndex].quantity;
                    if (currentQty > 1) {
                        cart.updateOptionQuantity(currentItemIndex, optIndex, currentQty - 1);
                    } else {
                        cart.removeOptionFromItem(currentItemIndex, optIndex);
                    }
                    // Actualiser l'affichage
                    const qtyEl = optionsList.querySelector(`[data-option-qty="${optionId}"]`);
                    if (qtyEl) qtyEl.textContent = Math.max(0, parseInt(qtyEl.textContent) - 1);
                    updateOptionButtons(optionId);
                }
            });
        });

        optionsModal.classList.remove('hidden');
        optionsModal.classList.add('flex');
    }

    function updateOptionButtons(optionId) {
        const qtyEl = optionsList.querySelector(`[data-option-qty="${optionId}"]`);
        const qty = parseInt(qtyEl?.textContent || 0);
        const option = Array.from(cart.serviceOptions.values()).flat().find(opt => opt.id === optionId);
        
        const increaseBtn = optionsList.querySelector(`[data-option-increase="${optionId}"]`);
        const decreaseBtn = optionsList.querySelector(`[data-option-decrease="${optionId}"]`);
        
        if (increaseBtn) increaseBtn.disabled = qty >= option.max_quantity;
        if (decreaseBtn) decreaseBtn.disabled = qty === 0;
    }

    // Fermer la modal des options
    closeOptionsModal?.addEventListener('click', () => {
        optionsModal.classList.add('hidden');
        optionsModal.classList.remove('flex');
    });

    confirmOptionsBtn?.addEventListener('click', () => {
        optionsModal.classList.add('hidden');
        optionsModal.classList.remove('flex');
    });

    // Vider le panier
    clearCartBtn?.addEventListener('click', () => {
        if (confirm('Êtes-vous sûr de vouloir vider le panier ?')) {
            cart.clearCart();
        }
    });

    // Soumettre la réservation
    bookingForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const date = document.getElementById('booking-date')?.value;
        const time = document.getElementById('booking-time')?.value;
        const notes = document.getElementById('booking-notes')?.value;

        if (!date || !time) {
            showMessage('Veuillez remplir tous les champs obligatoires', 'error');
            return;
        }

        try {
            const submitBtn = bookingForm.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Création en cours...';

            await cart.createBooking(date, time, notes);
        } catch (error) {
            const submitBtn = bookingForm.querySelector('button[type="submit"]');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Confirmer la réservation';
        }
    });

    // Afficher un message
    function showMessage(message, type = 'info') {
        if (!messageContainer) return;

        const bgColor = type === 'error' ? 'bg-red-50 text-red-700' : 
                       type === 'success' ? 'bg-green-50 text-green-700' : 
                       'bg-blue-50 text-blue-700';

        const messageEl = document.createElement('div');
        messageEl.className = `glass-card p-4 mb-4 ${bgColor} animate-fade-in`;
        messageEl.textContent = message;
        messageContainer.appendChild(messageEl);

        setTimeout(() => {
            messageEl.remove();
        }, 5000);
    }
})();
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/pages/booking-cart.blade.php ENDPATH**/ ?>