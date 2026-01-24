<aside class="hidden lg:flex lg:flex-col w-64 bg-gray-900 text-gray-100 border-r border-white/10">
    <div class="h-16 flex items-center px-6 border-b border-white/10">
        <span class="font-serif text-lg"><?php echo e(__('app.nav.admin.dashboard')); ?></span>
    </div>
    <nav class="flex-1 px-4 py-6 space-y-2 text-sm">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-4 py-2 rounded-lg hover:bg-white/10 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-white/10' : ''); ?>"><?php echo e(__('app.nav.admin.dashboard')); ?></a>
        <a href="<?php echo e(route('admin.clients.index')); ?>" class="block px-4 py-2 rounded-lg hover:bg-white/10 <?php echo e(str_starts_with(request()->route()->getName() ?? '', 'admin.clients') ? 'bg-white/10' : ''); ?>"><?php echo e(__('app.nav.admin.clients')); ?></a>
        <a href="<?php echo e(route('admin.bookings.index')); ?>" class="block px-4 py-2 rounded-lg hover:bg-white/10 <?php echo e(str_starts_with(request()->route()->getName() ?? '', 'admin.bookings') ? 'bg-white/10' : ''); ?>"><?php echo e(__('app.nav.admin.bookings')); ?></a>
        <a href="<?php echo e(route('admin.services.index')); ?>" class="block px-4 py-2 rounded-lg hover:bg-white/10 <?php echo e(str_starts_with(request()->route()->getName() ?? '', 'admin.services') ? 'bg-white/10' : ''); ?>"><?php echo e(__('app.nav.admin.services')); ?></a>
        <a href="<?php echo e(route('admin.staff.index')); ?>" class="block px-4 py-2 rounded-lg hover:bg-white/10 <?php echo e(str_starts_with(request()->route()->getName() ?? '', 'admin.staff') ? 'bg-white/10' : ''); ?>"><?php echo e(__('app.nav.admin.staff')); ?></a>
        <a href="<?php echo e(route('admin.inventory.index')); ?>" class="block px-4 py-2 rounded-lg hover:bg-white/10 <?php echo e(str_starts_with(request()->route()->getName() ?? '', 'admin.inventory') ? 'bg-white/10' : ''); ?>"><?php echo e(__('app.nav.admin.inventory')); ?></a>
        <a href="<?php echo e(route('admin.products.index')); ?>" class="block px-4 py-2 rounded-lg hover:bg-white/10 <?php echo e(str_starts_with(request()->route()->getName() ?? '', 'admin.products') ? 'bg-white/10' : ''); ?>"><?php echo e(__('app.nav.admin.products')); ?></a>
        <a href="<?php echo e(route('admin.promotions.index')); ?>" class="block px-4 py-2 rounded-lg hover:bg-white/10 <?php echo e(str_starts_with(request()->route()->getName() ?? '', 'admin.promotions') ? 'bg-white/10' : ''); ?>"><?php echo e(__('app.nav.admin.promotions')); ?></a>
        <a href="<?php echo e(route('admin.analytics')); ?>" class="block px-4 py-2 rounded-lg hover:bg-white/10 <?php echo e(str_starts_with(request()->route()->getName() ?? '', 'admin.analytics') ? 'bg-white/10' : ''); ?>"><?php echo e(__('app.nav.admin.analytics')); ?></a>
        <a href="<?php echo e(route('admin.partners.index')); ?>" class="block px-4 py-2 rounded-lg hover:bg-white/10 <?php echo e(str_starts_with(request()->route()->getName() ?? '', 'admin.partners') ? 'bg-white/10' : ''); ?>"><?php echo e(__('app.nav.admin.partners')); ?></a>
    </nav>
</aside>
<?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views\components\admin-sidebar.blade.php ENDPATH**/ ?>