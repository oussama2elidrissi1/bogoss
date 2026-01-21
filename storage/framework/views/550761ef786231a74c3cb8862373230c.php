<nav class="glass-card sticky top-0 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="<?php echo e(route('home')); ?>" class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full overflow-hidden bg-white flex items-center justify-center border border-gray-200">
                    <?php if(file_exists(public_path('images/bogos-land-logo.png'))): ?>
                        <img src="<?php echo e(asset('images/bogos-land-logo.png')); ?>" alt="Bogos Land" class="w-10 h-10 object-contain">
                    <?php else: ?>
                        <span class="text-primary font-bold text-xl">B</span>
                    <?php endif; ?>
                </div>
                <span class="font-serif text-2xl font-bold text-primary">Bogos Land</span>
            </a>

            <?php
                $currentRoute = request()->route() ? request()->route()->getName() : '';
                $user = auth()->user();
                $isAdmin = $user && $user->is_admin;
                $currentLocale = app()->getLocale();
                $cartItemsCount = collect(session('cart', []))->sum('quantity');
            ?>

            <div class="hidden md:flex items-center space-x-8">
                <?php if($isAdmin): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-sm font-medium <?php echo e(str_starts_with($currentRoute, 'admin.dashboard') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'); ?>"><?php echo e(__('app.nav.admin.dashboard')); ?></a>
                    <a href="<?php echo e(route('admin.clients.index')); ?>" class="text-sm font-medium <?php echo e(str_starts_with($currentRoute, 'admin.clients') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'); ?>"><?php echo e(__('app.nav.admin.clients')); ?></a>
                    <a href="<?php echo e(route('admin.bookings.index')); ?>" class="text-sm font-medium <?php echo e(str_starts_with($currentRoute, 'admin.bookings') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'); ?>"><?php echo e(__('app.nav.admin.bookings')); ?></a>
                    <a href="<?php echo e(route('admin.services.index')); ?>" class="text-sm font-medium <?php echo e(str_starts_with($currentRoute, 'admin.services') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'); ?>"><?php echo e(__('app.nav.admin.services')); ?></a>
                    <a href="<?php echo e(route('admin.staff.index')); ?>" class="text-sm font-medium <?php echo e(str_starts_with($currentRoute, 'admin.staff') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'); ?>"><?php echo e(__('app.nav.admin.staff')); ?></a>
                    <a href="<?php echo e(route('admin.inventory.index')); ?>" class="text-sm font-medium <?php echo e(str_starts_with($currentRoute, 'admin.inventory') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'); ?>"><?php echo e(__('app.nav.admin.inventory')); ?></a>
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="text-sm font-medium <?php echo e(str_starts_with($currentRoute, 'admin.products') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'); ?>"><?php echo e(__('app.nav.admin.products')); ?></a>
                    <a href="<?php echo e(route('admin.promotions.index')); ?>" class="text-sm font-medium <?php echo e(str_starts_with($currentRoute, 'admin.promotions') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'); ?>"><?php echo e(__('app.nav.admin.promotions')); ?></a>
                    <a href="<?php echo e(route('admin.analytics')); ?>" class="text-sm font-medium <?php echo e(str_starts_with($currentRoute, 'admin.analytics') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'); ?>"><?php echo e(__('app.nav.admin.analytics')); ?></a>
                    <a href="<?php echo e(route('admin.partners.index')); ?>" class="text-sm font-medium <?php echo e(str_starts_with($currentRoute, 'admin.partners') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'); ?>"><?php echo e(__('app.nav.admin.partners')); ?></a>
                <?php elseif($user && $user->role === 'partner'): ?>
                    <a href="<?php echo e(route('partner.dashboard')); ?>" class="text-sm font-medium <?php echo e(str_starts_with($currentRoute, 'partner.') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'); ?>"><?php echo e(__('app.nav.partner.dashboard')); ?></a>
                    <a href="<?php echo e(route('partner.bookings.create')); ?>" class="text-sm font-medium <?php echo e(str_starts_with($currentRoute, 'partner.bookings') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'); ?>"><?php echo e(__('app.nav.partner.new_booking')); ?></a>
                <?php else: ?>
                    <a href="<?php echo e(route('home')); ?>" class="text-sm font-medium <?php echo e($currentRoute === 'home' ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'); ?>"><?php echo e(__('app.nav.home')); ?></a>
                    <a href="<?php echo e(route('services')); ?>" class="text-sm font-medium <?php echo e($currentRoute === 'services' ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'); ?>"><?php echo e(__('app.nav.services')); ?></a>
                    <a href="<?php echo e(route('booking')); ?>" class="text-sm font-medium <?php echo e($currentRoute === 'booking' ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'); ?>"><?php echo e(__('app.nav.book_now')); ?></a>
                    <a href="<?php echo e(route('subscriptions')); ?>" class="text-sm font-medium <?php echo e($currentRoute === 'subscriptions' ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'); ?>"><?php echo e(__('app.nav.memberships')); ?></a>
                    <a href="<?php echo e(route('shop')); ?>" class="text-sm font-medium <?php echo e($currentRoute === 'shop' ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary'); ?>">
                        <?php echo e(__('app.nav.shop')); ?>

                        <?php if($cartItemsCount > 0): ?>
                            <span class="ml-1 inline-flex items-center justify-center bg-accent text-white text-xs rounded-full w-5 h-5 align-middle"><?php echo e($cartItemsCount); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="hidden md:flex items-center space-x-4">
                <details class="relative">
                    <summary class="btn-secondary text-xs px-3 py-2 cursor-pointer list-none">
                        <?php echo e(__('app.language')); ?>: <?php echo e(strtoupper($currentLocale)); ?>

                    </summary>
                    <div class="absolute right-0 mt-2 w-36 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden z-50">
                        <a href="<?php echo e(route('locale.switch', 'fr')); ?>" class="block px-4 py-2 text-sm <?php echo e($currentLocale === 'fr' ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">FR</a>
                        <a href="<?php echo e(route('locale.switch', 'en')); ?>" class="block px-4 py-2 text-sm <?php echo e($currentLocale === 'en' ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">EN</a>
                        <a href="<?php echo e(route('locale.switch', 'ar')); ?>" class="block px-4 py-2 text-sm <?php echo e($currentLocale === 'ar' ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">AR</a>
                    </div>
                </details>
                <?php if(auth()->guard()->check()): ?>
                    <?php
                        $currentUser = auth()->user();
                    ?>
                    <?php if($currentUser): ?>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm font-medium"><?php echo e($currentUser->name); ?></span>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn-primary"><?php echo e(__('app.auth.logout')); ?></button>
                            </form>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn-primary"><?php echo e(__('app.auth.sign_in')); ?></a>
                <?php endif; ?>
            </div>

            <button
                type="button"
                id="mobile-menu-button"
                class="md:hidden p-2 text-gray-700 hover:text-primary"
                aria-controls="mobile-menu"
                aria-expanded="false"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="md:hidden hidden border-t border-gray-200 bg-white">
            <div class="px-4 py-4 space-y-3">
                <?php if($isAdmin): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-4 py-2 rounded-lg <?php echo e(str_starts_with($currentRoute, 'admin.dashboard') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>"><?php echo e(__('app.nav.admin.dashboard')); ?></a>
                    <a href="<?php echo e(route('admin.clients.index')); ?>" class="block px-4 py-2 rounded-lg <?php echo e(str_starts_with($currentRoute, 'admin.clients') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>"><?php echo e(__('app.nav.admin.clients')); ?></a>
                    <a href="<?php echo e(route('admin.bookings.index')); ?>" class="block px-4 py-2 rounded-lg <?php echo e(str_starts_with($currentRoute, 'admin.bookings') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>"><?php echo e(__('app.nav.admin.bookings')); ?></a>
                    <a href="<?php echo e(route('admin.services.index')); ?>" class="block px-4 py-2 rounded-lg <?php echo e(str_starts_with($currentRoute, 'admin.services') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>"><?php echo e(__('app.nav.admin.services')); ?></a>
                    <a href="<?php echo e(route('admin.staff.index')); ?>" class="block px-4 py-2 rounded-lg <?php echo e(str_starts_with($currentRoute, 'admin.staff') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>"><?php echo e(__('app.nav.admin.staff')); ?></a>
                    <a href="<?php echo e(route('admin.inventory.index')); ?>" class="block px-4 py-2 rounded-lg <?php echo e(str_starts_with($currentRoute, 'admin.inventory') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>"><?php echo e(__('app.nav.admin.inventory')); ?></a>
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="block px-4 py-2 rounded-lg <?php echo e(str_starts_with($currentRoute, 'admin.products') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>"><?php echo e(__('app.nav.admin.products')); ?></a>
                    <a href="<?php echo e(route('admin.promotions.index')); ?>" class="block px-4 py-2 rounded-lg <?php echo e(str_starts_with($currentRoute, 'admin.promotions') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>"><?php echo e(__('app.nav.admin.promotions')); ?></a>
                    <a href="<?php echo e(route('admin.analytics')); ?>" class="block px-4 py-2 rounded-lg <?php echo e(str_starts_with($currentRoute, 'admin.analytics') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>"><?php echo e(__('app.nav.admin.analytics')); ?></a>
                    <a href="<?php echo e(route('admin.partners.index')); ?>" class="block px-4 py-2 rounded-lg <?php echo e(str_starts_with($currentRoute, 'admin.partners') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>"><?php echo e(__('app.nav.admin.partners')); ?></a>
                <?php elseif($user && $user->role === 'partner'): ?>
                    <a href="<?php echo e(route('partner.dashboard')); ?>" class="block px-4 py-2 rounded-lg <?php echo e(str_starts_with($currentRoute, 'partner.') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>"><?php echo e(__('app.nav.partner.dashboard')); ?></a>
                    <a href="<?php echo e(route('partner.bookings.create')); ?>" class="block px-4 py-2 rounded-lg <?php echo e(str_starts_with($currentRoute, 'partner.bookings') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>"><?php echo e(__('app.nav.partner.new_booking')); ?></a>
                <?php else: ?>
                    <a href="<?php echo e(route('home')); ?>" class="block px-4 py-2 rounded-lg <?php echo e($currentRoute === 'home' ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>"><?php echo e(__('app.nav.home')); ?></a>
                    <a href="<?php echo e(route('services')); ?>" class="block px-4 py-2 rounded-lg <?php echo e($currentRoute === 'services' ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>"><?php echo e(__('app.nav.services')); ?></a>
                    <a href="<?php echo e(route('booking')); ?>" class="block px-4 py-2 rounded-lg <?php echo e($currentRoute === 'booking' ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>"><?php echo e(__('app.nav.book_now')); ?></a>
                    <a href="<?php echo e(route('subscriptions')); ?>" class="block px-4 py-2 rounded-lg <?php echo e($currentRoute === 'subscriptions' ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>"><?php echo e(__('app.nav.memberships')); ?></a>
                    <a href="<?php echo e(route('shop')); ?>" class="block px-4 py-2 rounded-lg <?php echo e($currentRoute === 'shop' ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                        <?php echo e(__('app.nav.shop')); ?>

                        <?php if($cartItemsCount > 0): ?>
                            <span class="ml-1 inline-flex items-center justify-center bg-accent text-white text-xs rounded-full w-5 h-5 align-middle"><?php echo e($cartItemsCount); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>

                <div class="pt-2 border-t border-gray-200">
                    <div class="text-xs text-gray-500 mb-3"><?php echo e(__('app.language')); ?></div>
                    <div class="flex items-center space-x-2 mb-3">
                        <a href="<?php echo e(route('locale.switch', 'fr')); ?>" class="px-3 py-1 rounded-full text-xs border <?php echo e($currentLocale === 'fr' ? 'bg-primary text-white border-primary' : 'text-gray-700 border-gray-200'); ?>">FR</a>
                        <a href="<?php echo e(route('locale.switch', 'en')); ?>" class="px-3 py-1 rounded-full text-xs border <?php echo e($currentLocale === 'en' ? 'bg-primary text-white border-primary' : 'text-gray-700 border-gray-200'); ?>">EN</a>
                        <a href="<?php echo e(route('locale.switch', 'ar')); ?>" class="px-3 py-1 rounded-full text-xs border <?php echo e($currentLocale === 'ar' ? 'bg-primary text-white border-primary' : 'text-gray-700 border-gray-200'); ?>">AR</a>
                    </div>
                    <?php if(auth()->guard()->check()): ?>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium"><?php echo e($user->name); ?></span>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn-primary"><?php echo e(__('app.auth.logout')); ?></button>
                            </form>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn-primary block text-center"><?php echo e(__('app.auth.sign_in')); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
  (function () {
    const button = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');
    if (!button || !menu) return;
    button.addEventListener('click', function () {
      const isHidden = menu.classList.toggle('hidden');
      button.setAttribute('aria-expanded', (!isHidden).toString());
    });
  })();
</script>
<?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/components/navbar.blade.php ENDPATH**/ ?>