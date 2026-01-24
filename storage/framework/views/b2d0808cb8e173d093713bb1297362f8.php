

<?php $__env->startSection('title', __('admin.dashboard.title')); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-4xl font-bold mb-2 text-white"><?php echo e(__('admin.dashboard.title_short')); ?></h1>
            <p class="text-xl text-white/90"><?php echo e(__('admin.dashboard.subtitle')); ?></p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1"><?php echo e(__('admin.dashboard.total_revenue')); ?></p>
                        <p class="text-2xl font-bold text-gray-900">MAD <?php echo e(number_format($totalRevenue, 2)); ?></p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1"><?php echo e(__('admin.dashboard.total_bookings')); ?></p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($totalBookings); ?></p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1"><?php echo e(__('admin.dashboard.total_clients')); ?></p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($totalClients); ?></p>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1"><?php echo e(__('admin.dashboard.low_stock')); ?></p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($lowStockItems); ?></p>
                    </div>
                    <div class="bg-yellow-50 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-card p-6">
            <h2 class="font-serif text-2xl font-bold mb-4"><?php echo e(__('admin.dashboard.recent_bookings')); ?></h2>
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-bold text-gray-900"><?php echo e($booking->client_name); ?></h3>
                            <p class="text-sm text-gray-600">
                                Réf: <?php echo e($booking->booking_reference); ?> • <?php echo e($booking->items->count()); ?> service(s)
                            </p>
                            <?php if($booking->items->count() > 0): ?>
                                <div class="mt-2 space-y-1">
                                    <?php $__currentLoopData = $booking->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p class="text-xs text-gray-500">→ <?php echo e($item->service_name); ?></p>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <span class="badge <?php echo e($booking->status === 'confirmed' ? 'badge-success' : 'badge-warning'); ?>">
                            <?php echo e(__('admin.status.' . $booking->status)); ?>

                        </span>
                    </div>
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <span>📅 <?php echo e($booking->date->format('M d, Y')); ?></span>
                        <span>🕐 <?php echo e($booking->time); ?></span>
                        <span>💰 MAD <?php echo e(number_format($booking->total, 2)); ?></span>
                        <span>⏱️ <?php echo e($booking->total_duration); ?> min</span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-500 text-center py-8"><?php echo e(__('admin.dashboard.no_bookings')); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>