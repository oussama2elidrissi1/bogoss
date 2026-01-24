<?php $__env->startSection('title', __('pages.partner_dashboard.title')); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-white">
                <h1 class="font-serif text-4xl font-bold mb-2"><?php echo e(__('pages.partner_dashboard.title_short')); ?></h1>
                <p class="text-xl"><?php echo e(__('pages.partner_dashboard.welcome', ['name' => $partner->name])); ?></p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <?php if(session('success')): ?>
            <div class="glass-card p-4 mb-6 text-green-700 bg-green-50"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="glass-card p-6">
                <p class="text-sm text-gray-600"><?php echo e(__('pages.partner_dashboard.total_bookings')); ?></p>
                <p class="text-3xl font-bold text-gray-900"><?php echo e($totalBookings); ?></p>
            </div>
            <div class="glass-card p-6">
                <p class="text-sm text-gray-600"><?php echo e(__('pages.partner_dashboard.total_commission')); ?></p>
                <p class="text-3xl font-bold text-gray-900">MAD <?php echo e(number_format($totalCommission, 2)); ?></p>
            </div>
            <div class="glass-card p-6">
                <p class="text-sm text-gray-600"><?php echo e(__('pages.partner_dashboard.commission_rate')); ?></p>
                <p class="text-3xl font-bold text-gray-900"><?php echo e($partner->commission_rate); ?>%</p>
            </div>
        </div>

        <div class="flex items-center justify-between mb-4">
            <form method="GET" class="flex gap-3">
                <input type="date" name="from" value="<?php echo e($from); ?>" class="input-field">
                <input type="date" name="to" value="<?php echo e($to); ?>" class="input-field">
                <button class="btn-primary"><?php echo e(__('pages.common.filter')); ?></button>
            </form>
            <a href="<?php echo e(route('partner.bookings.create')); ?>" class="btn-secondary"><?php echo e(__('pages.partner_dashboard.new_booking')); ?></a>
        </div>

        <div class="glass-card p-6">
            <h2 class="font-serif text-2xl font-bold mb-4"><?php echo e(__('pages.partner_dashboard.bookings')); ?></h2>
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-gray-900"><?php echo e($booking->client_name); ?> - <?php echo e($booking->service); ?></p>
                                <p class="text-sm text-gray-600"><?php echo e(__('pages.partner_dashboard.booking_line', ['date' => $booking->date->format('M d, Y'), 'time' => $booking->time])); ?></p>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-primary">MAD <?php echo e($booking->price); ?></span>
                                <p class="text-sm text-gray-600"><?php echo e(__('pages.partner_dashboard.commission_line', ['amount' => $booking->commission_amount])); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500"><?php echo e(__('pages.partner_dashboard.no_bookings')); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views\partner\dashboard.blade.php ENDPATH**/ ?>