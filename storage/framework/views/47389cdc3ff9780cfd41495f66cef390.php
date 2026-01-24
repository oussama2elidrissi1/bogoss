<?php $__env->startSection('title', __('pages.booking.title')); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50" id="booking-page" data-auth="<?php echo e(auth()->check() ? '1' : '0'); ?>">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="font-serif text-5xl font-bold mb-4"><?php echo e(__('pages.booking.hero_title')); ?></h1>
                <p class="text-xl max-w-2xl mx-auto"><?php echo e(__('pages.booking.hero_subtitle')); ?></p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <?php if(session('success')): ?>
            <div class="glass-card p-4 mb-6 text-green-700 bg-green-50">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="mb-8">
                    <h2 class="font-serif text-2xl font-bold text-gray-900 mb-4"><?php echo e(__('pages.booking.choose_service')); ?></h2>

                    <?php if(!empty($serviceGroups)): ?>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                            <?php $__currentLoopData = $serviceGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $variants = ($group['variants'] ?? collect())->map(function ($s) {
                                        return [
                                            'id' => $s->id,
                                            'name' => $s->name,
                                            'price' => (float) $s->price,
                                            'duration' => (int) $s->duration,
                                        ];
                                    })->values();
                                ?>
                                <?php if($variants->count() > 0): ?>
                                    <div class="glass-card p-5">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="font-serif text-xl font-bold text-gray-900"><?php echo e($group['title']); ?></div>
                                            <div class="text-2xl"><?php echo e($group['icon'] ?? '✨'); ?></div>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-4">Choisissez le type après (classic/royal, durée, options...).</p>
                                        <button
                                            type="button"
                                            class="btn-primary w-full js-book-group"
                                            data-group-title="<?php echo e($group['title']); ?>"
                                            data-variants='<?php echo json_encode($variants, 15, 512) ?>'
                                        >
                                            Choisir <?php echo e($group['title']); ?>

                                        </button>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>

                    <div class="flex flex-wrap gap-3 mb-6">
                        <a href="<?php echo e(route('booking', ['category' => 'All', 'date' => $selectedDate->toDateString(), 'service_id' => optional($selectedService)->id])); ?>" class="px-6 py-2 rounded-full font-medium transition-all duration-300 <?php echo e($selectedCategory === 'All' ? 'bg-primary text-white shadow-lg scale-105' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'); ?>"><?php echo e(__('pages.common.all')); ?></a>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('booking', ['category' => $category, 'date' => $selectedDate->toDateString(), 'service_id' => optional($selectedService)->id])); ?>" class="px-6 py-2 rounded-full font-medium transition-all duration-300 <?php echo e($selectedCategory === $category ? 'bg-primary text-white shadow-lg scale-105' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'); ?>"><?php echo e($category); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="glass-card overflow-hidden">
                                <div class="relative h-40 overflow-hidden">
                                    <img src="<?php echo e($service->image ?? 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400'); ?>" alt="<?php echo e($service->name); ?>" class="w-full h-full object-cover">
                                    <div class="absolute top-3 right-3">
                                        <span class="badge badge-primary"><?php echo e($service->category); ?></span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-serif text-lg font-bold text-gray-900 mb-2"><?php echo e($service->name); ?></h3>
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2"><?php echo e($service->description); ?></p>
                                    <div class="flex items-center justify-between mb-3 text-sm text-gray-700">
                                        <span>⏱️ <?php echo e($service->duration); ?> <?php echo e(__('pages.common.minutes')); ?></span>
                                        <span class="text-primary font-bold">MAD <?php echo e($service->price); ?></span>
                                    </div>
                                    <button
                                        type="button"
                                        class="w-full btn-primary inline-block text-center js-book-service"
                                        data-service-id="<?php echo e($service->id); ?>"
                                        data-service-name="<?php echo e($service->name); ?>"
                                        data-service-price="<?php echo e($service->price); ?>"
                                        data-service-duration="<?php echo e($service->duration); ?>"
                                    >
                                        <?php echo e(__('pages.common.book')); ?>

                                    </button>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="glass-card p-6">
                    <h2 class="font-serif text-2xl font-bold text-gray-900 mb-4"><?php echo e(__('pages.booking.choose_date')); ?></h2>
                    <form method="GET" class="space-y-4">
                        <input type="hidden" name="category" value="<?php echo e($selectedCategory); ?>">
                        <input type="hidden" name="service_id" value="<?php echo e(optional($selectedService)->id); ?>">
                        <input type="date" name="date" min="<?php echo e(now()->toDateString()); ?>" value="<?php echo e($selectedDate->toDateString()); ?>" class="input-field" onchange="this.form.submit()">
                    </form>
                </div>

                <div class="glass-card p-6">
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-4"><?php echo e(__('pages.booking.bookings_of', ['date' => $selectedDate->format('M d, Y')])); ?></h3>
                    <?php if($dateBookings->count() > 0): ?>
                        <div class="space-y-3">
                            <?php $__currentLoopData = $dateBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="font-medium text-gray-900"><?php echo e($booking->service); ?></span>
                                        <span class="badge badge-primary"><?php echo e($booking->time); ?></span>
                                    </div>
                                    <p class="text-sm text-gray-600"><?php echo e($booking->client_name); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 text-sm"><?php echo e(__('pages.booking.no_bookings')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="glass-card p-6">
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-4"><?php echo e(__('pages.booking.available_staff')); ?></h3>
                    <?php if($availableStaff->count() > 0): ?>
                        <div class="space-y-3">
                            <?php $__currentLoopData = $availableStaff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center space-x-3 bg-gray-50 rounded-lg p-3">
                                    <img src="<?php echo e($staff->image ?? 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200'); ?>" alt="<?php echo e($staff->name); ?>" class="w-12 h-12 rounded-full object-cover">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900"><?php echo e($staff->name); ?></p>
                                        <p class="text-sm text-gray-600"><?php echo e(is_array($staff->role) ? implode(', ', $staff->role) : $staff->role); ?></p>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex items-center space-x-1">
                                            <span class="text-yellow-500">★</span>
                                            <span class="text-sm font-medium"><?php echo e($staff->rating); ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 text-sm"><?php echo e(__('pages.booking.no_staff')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="glass-card p-6">
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-4"><?php echo e(__('pages.booking.process_title')); ?></h3>
                    <ol class="text-sm text-gray-600 space-y-2 list-decimal list-inside">
                        <li><?php echo e(__('pages.booking.process_step1')); ?></li>
                        <li><?php echo e(__('pages.booking.process_step2')); ?></li>
                        <li><?php echo e(__('pages.booking.process_step3')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
</div>

<?php if(auth()->guard()->guest()): ?>
<div id="auth-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-serif text-2xl font-bold text-gray-900"><?php echo e(__('pages.booking.auth_title')); ?></h3>
            <button type="button" class="text-gray-500 hover:text-gray-700" data-close-modal>✕</button>
        </div>
        <div class="flex space-x-2 mb-6">
            <button type="button" class="px-4 py-2 rounded-full text-sm font-medium bg-primary text-white" data-auth-tab="login"><?php echo e(__('app.auth.sign_in')); ?></button>
            <button type="button" class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700" data-auth-tab="register"><?php echo e(__('app.auth.register')); ?></button>
        </div>

        <div id="auth-login-panel">
            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="redirect_to" value="<?php echo e(url()->current()); ?>">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.auth.email')); ?></label>
                    <input type="email" name="email" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.auth.password')); ?></label>
                    <input type="password" name="password" class="input-field" required>
                </div>
                <button type="submit" class="btn-primary w-full"><?php echo e(__('app.auth.sign_in')); ?></button>
            </form>
        </div>

        <div id="auth-register-panel" class="hidden">
            <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="redirect_to" value="<?php echo e(url()->current()); ?>">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.auth.name')); ?></label>
                    <input type="text" name="name" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.auth.email')); ?></label>
                    <input type="email" name="email" class="input-field" required>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.auth.password')); ?></label>
                        <input type="password" name="password" class="input-field" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.auth.confirm_password')); ?></label>
                        <input type="password" name="password_confirmation" class="input-field" required>
                    </div>
                </div>
                <button type="submit" class="btn-primary w-full"><?php echo e(__('app.auth.register')); ?></button>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if(auth()->guard()->check()): ?>
<div id="booking-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 max-h-[90vh] overflow-hidden">
        <div class="max-h-[85vh] overflow-y-auto pr-1">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-serif text-2xl font-bold text-gray-900"><?php echo e(__('pages.booking.modal_title')); ?></h3>
            <button type="button" class="text-gray-500 hover:text-gray-700" data-close-modal>✕</button>
        </div>

        <div id="group-variant-panel" class="hidden border border-gray-200 rounded-xl p-4 bg-white mb-4">
            <div class="flex items-center justify-between mb-3">
                <h4 class="font-serif text-lg font-bold text-gray-900" id="group-variant-title">Choose type</h4>
                <button type="button" class="text-gray-500 hover:text-gray-700" id="close-group-variant">✕</button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="sm:col-span-2">
                    <select id="group-variant-select" class="input-field"></select>
                </div>
                <button type="button" class="btn-primary" id="group-variant-add">Add</button>
            </div>
            <p class="text-xs text-gray-500 mt-2">Vous sélectionnez d’abord le service, puis le type (classic/royal, durée...).</p>
        </div>

        <div class="bg-gray-50 rounded-xl p-4 mb-6">
            <p class="text-sm text-gray-500"><?php echo e(__('pages.booking.selected_services')); ?></p>
            <div class="space-y-2" id="booking-service-list">
                <p class="text-sm text-gray-600"><?php echo e(__('pages.booking.no_selected_services')); ?></p>
            </div>
        </div>
        <form method="POST" action="<?php echo e(route('booking.store')); ?>" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('pages.booking.service_label')); ?></label>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="button" class="btn-primary" id="add-service-btn"><?php echo e(__('pages.booking.add_service')); ?></button>
                </div>
                <p class="text-xs text-gray-500 mt-2"><?php echo e(__('pages.booking.add_service_hint')); ?></p>
            </div>

            <div id="service-picker-panel" class="hidden border border-gray-200 rounded-xl p-4 bg-white">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-serif text-lg font-bold text-gray-900"><?php echo e(__('pages.booking.choose_another_service')); ?></h4>
                    <button type="button" class="text-gray-500 hover:text-gray-700" id="close-service-panel">✕</button>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 mb-4">
                    <div class="relative flex-1">
                        <input
                            type="text"
                            id="service-filter-input"
                            class="input-field pl-10"
                            placeholder="<?php echo e(__('pages.common.search_service')); ?>"
                        >
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">🔍</span>
                    </div>
                    <select id="service-filter-category" class="input-field sm:w-48">
                        <option value="all"><?php echo e(__('pages.booking.all_categories')); ?></option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category); ?>"><?php echo e($category); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-64 overflow-y-auto" id="service-cards-grid">
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button
                            type="button"
                            class="glass-card overflow-hidden text-left hover:ring-2 hover:ring-primary js-add-service-card"
                            data-service-id="<?php echo e($service->id); ?>"
                            data-service-name="<?php echo e($service->name); ?>"
                            data-service-price="<?php echo e($service->price); ?>"
                            data-service-duration="<?php echo e($service->duration); ?>"
                            data-service-category="<?php echo e($service->category); ?>"
                        >
                            <div class="relative h-28 overflow-hidden">
                                <img src="<?php echo e($service->image ?? 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400'); ?>" alt="<?php echo e($service->name); ?>" class="w-full h-full object-cover">
                                <div class="absolute top-2 right-2">
                                    <span class="badge badge-primary text-xs"><?php echo e($service->category); ?></span>
                                </div>
                            </div>
                            <div class="p-3">
                                <p class="font-semibold text-gray-900 text-sm"><?php echo e($service->name); ?></p>
                                <div class="flex items-center justify-between text-xs text-gray-600 mt-1">
                                    <span>⏱️ <?php echo e($service->duration); ?> <?php echo e(__('pages.common.minutes')); ?></span>
                                    <span class="text-primary font-bold">MAD <?php echo e($service->price); ?></span>
                                </div>
                            </div>
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('pages.booking.date_label')); ?></label>
                    <input type="date" name="date" class="input-field" value="<?php echo e($selectedDate->toDateString()); ?>" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('pages.booking.time_label')); ?></label>
                    <select name="time" class="input-field" required>
                        <?php $__currentLoopData = $timeSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($time); ?>"><?php echo e($time); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('pages.booking.staff_optional')); ?></label>
                <select name="staff_id" class="input-field">
                    <option value=""><?php echo e(__('pages.booking.auto_assign')); ?></option>
                    <?php $__currentLoopData = $availableStaff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staffMember): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($staffMember->id); ?>"><?php echo e($staffMember->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('pages.booking.notes_label')); ?></label>
                <textarea name="notes" rows="3" class="input-field" placeholder="<?php echo e(__('pages.booking.notes_placeholder')); ?>"></textarea>
            </div>
            <button type="submit" class="btn-primary w-full"><?php echo e(__('pages.booking.confirm_booking')); ?></button>
        </form>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
  (function () {
    const page = document.getElementById('booking-page');
    if (!page) return;
    const isAuth = page.dataset.auth === '1';
    const authModal = document.getElementById('auth-modal');
    const bookingModal = document.getElementById('booking-modal');
    const serviceButtons = document.querySelectorAll('.js-book-service');
    const groupButtons = document.querySelectorAll('.js-book-group');
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
    const prefill = <?php echo json_encode($prefillData ?? [], 15, 512) ?>;

    const groupVariantPanel = document.getElementById('group-variant-panel');
    const groupVariantTitle = document.getElementById('group-variant-title');
    const groupVariantSelect = document.getElementById('group-variant-select');
    const groupVariantAdd = document.getElementById('group-variant-add');
    const closeGroupVariant = document.getElementById('close-group-variant');
    let activeGroupVariants = [];
    const labels = {
      noServiceSelected: <?php echo json_encode(__('pages.booking.no_selected_services'), 15, 512) ?>,
      remove: <?php echo json_encode(__('pages.common.remove'), 15, 512) ?>,
      minutes: <?php echo json_encode(__('pages.common.minutes'), 15, 512) ?>,
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

    const showGroupVariants = (title, variants) => {
      if (!groupVariantPanel || !groupVariantSelect || !groupVariantTitle) return;
      activeGroupVariants = Array.isArray(variants) ? variants : [];
      groupVariantTitle.textContent = `${title}: choisir le type`;
      groupVariantSelect.innerHTML = '';
      activeGroupVariants.forEach((v) => {
        const opt = document.createElement('option');
        opt.value = String(v.id);
        opt.textContent = `${v.name} • MAD ${Number(v.price).toFixed(2)} • ${v.duration} ${labels.minutes}`;
        groupVariantSelect.appendChild(opt);
      });
      groupVariantPanel.classList.remove('hidden');
    };

    const hideGroupVariants = () => {
      if (!groupVariantPanel) return;
      groupVariantPanel.classList.add('hidden');
      activeGroupVariants = [];
      if (groupVariantSelect) groupVariantSelect.innerHTML = '';
    };

    if (closeGroupVariant) {
      closeGroupVariant.addEventListener('click', hideGroupVariants);
    }

    if (groupVariantAdd) {
      groupVariantAdd.addEventListener('click', () => {
        const id = groupVariantSelect?.value;
        if (!id) return;
        const v = activeGroupVariants.find((x) => String(x.id) === String(id));
        if (!v) return;
        selectedServices.clear();
        selectedServices.set(String(v.id), {
          id: String(v.id),
          name: v.name || '',
          price: `MAD ${Number(v.price).toFixed(2)}`,
          duration: `${v.duration} ${labels.minutes}`,
        });
        renderSelected();
        hideGroupVariants();
      });
    }

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

    groupButtons.forEach((btn) => {
      btn.addEventListener('click', () => {
        const title = btn.dataset.groupTitle || 'Service';
        let variants = [];
        try {
          variants = JSON.parse(btn.dataset.variants || '[]');
        } catch (e) {
          variants = [];
        }
        if (isAuth) {
          openModal(bookingModal);
          showGroupVariants(title, variants);
        } else {
          setAuthTab('login');
          openModal(authModal);
        }
      });
    });

    // Prefill from packs (service_ids[])
    if (Array.isArray(prefill) && prefill.length) {
      prefill.forEach((s) => {
        const id = String(s.id);
        selectedServices.set(id, {
          id,
          name: s.name || '',
          price: s.price != null ? `MAD ${Number(s.price).toFixed(2)}` : '',
          duration: s.duration != null ? `${Number(s.duration)} ${labels.minutes}` : '',
        });
      });
      renderSelected();
      if (isAuth) openModal(bookingModal);
      else {
        setAuthTab('login');
        openModal(authModal);
      }
    }
  })();
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/pages/booking.blade.php ENDPATH**/ ?>