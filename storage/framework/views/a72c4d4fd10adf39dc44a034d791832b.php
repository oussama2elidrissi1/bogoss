

<?php $__env->startSection('title', __('admin.staff_history.title')); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-4xl font-bold mb-2 text-white"><?php echo e(__('admin.staff_history.title_short', ['name' => $staff->name])); ?></h1>
            <p class="text-xl text-white/90"><?php echo e(is_array($staff->role) ? implode(', ', $staff->role) : $staff->role); ?></p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-600"><?php echo e(__('admin.staff_history.day')); ?></p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e(\Carbon\Carbon::parse($date)->format('M d, Y')); ?></p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="<?php echo e(route('admin.staff.history', ['staff' => $staff->id, 'date' => \Carbon\Carbon::parse($date)->subDay()->toDateString()])); ?>" class="btn-secondary"><?php echo e(__('admin.staff_history.prev')); ?></a>
                    <a href="<?php echo e(route('admin.staff.history', ['staff' => $staff->id, 'date' => \Carbon\Carbon::parse($date)->addDay()->toDateString()])); ?>" class="btn-secondary"><?php echo e(__('admin.staff_history.next')); ?></a>
                    <a href="<?php echo e(route('admin.staff.history', ['staff' => $staff->id, 'date' => now()->toDateString()])); ?>" class="btn-primary"><?php echo e(__('admin.staff_history.today')); ?></a>
                </div>
            </div>
        </div>

        <div class="glass-card p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-600"><?php echo e(__('admin.staff_history.total_earnings')); ?></p>
                    <p class="text-3xl font-bold text-gray-900">MAD <?php echo e(number_format($totalEarnings, 2)); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600"><?php echo e(__('admin.staff_history.total_confirmed')); ?></p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($totalConfirmed); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600"><?php echo e(__('admin.staff_history.avg_earnings')); ?></p>
                    <p class="text-3xl font-bold text-gray-900">
                        MAD <?php echo e($totalConfirmed > 0 ? number_format($totalEarnings / $totalConfirmed, 2) : '0.00'); ?>

                    </p>
                </div>
                <div>
                    <a href="<?php echo e(route('admin.staff.index')); ?>" class="btn-secondary"><?php echo e(__('pages.common.cancel')); ?></a>
                </div>
            </div>
        </div>

        <div class="glass-card p-6">
            <h2 class="font-serif text-2xl font-bold text-gray-900 mb-4"><?php echo e(__('admin.staff_history.history_title')); ?></h2>
            <?php if($bookings->count() > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-semibold text-gray-900"><?php echo e($booking->service); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo e($booking->client_name); ?></p>
                                </div>
                                <span class="badge <?php echo e($booking->status === 'confirmed' ? 'badge-success' : ($booking->status === 'pending' ? 'badge-warning' : 'badge-error')); ?>">
                                    <?php echo e(__('admin.status.' . $booking->status)); ?>

                                </span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-600">
                                <div>📅 <?php echo e($booking->date->format('M d, Y')); ?></div>
                                <div>🕐 <?php echo e($booking->time); ?></div>
                                <div>⏱️ <?php echo e($booking->duration); ?> <?php echo e(__('pages.common.minutes')); ?></div>
                                <div>💰 MAD <?php echo e(number_format($booking->price, 2)); ?></div>
                                <div>💼 <?php echo e(__('admin.staff_history.staff_commission')); ?>: MAD <?php echo e(number_format($booking->staff_payout_amount ?? 0, 2)); ?></div>
                                <div>📈 <?php echo e(__('admin.staff_history.rate')); ?>: <?php echo e(number_format($booking->staff_payout_percentage ?? 0, 2)); ?>%</div>
                            </div>
                            <div class="text-sm text-gray-600">
                                <?php echo e(__('admin.staff_history.notes')); ?>: <span class="text-gray-900"><?php echo e($booking->notes ?: '-'); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-6">
                    <?php echo e($bookings->links()); ?>

                </div>
            <?php else: ?>
                <p class="text-sm text-gray-500"><?php echo e(__('admin.staff_history.none')); ?></p>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views\admin\staff-history.blade.php ENDPATH**/ ?>