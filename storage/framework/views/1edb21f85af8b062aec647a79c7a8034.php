

<?php $__env->startSection('title', 'Bookings - Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-4xl font-bold mb-2 text-white">Booking Management</h1>
            <p class="text-xl text-white/90">Manage appointments and schedules</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <?php if(session('success')): ?>
            <div class="glass-card p-4 mb-6 text-green-700 bg-green-50">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="glass-card p-4 mb-6 text-red-700 bg-red-50">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <div class="glass-card p-6 mb-6">
            <form method="GET" action="<?php echo e(route('admin.bookings.index')); ?>" class="flex gap-4">
                <select name="status" class="input-field">
                    <option value="">All Status</option>
                    <option value="confirmed" <?php echo e(request('status') == 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                </select>
                <input type="date" name="date" value="<?php echo e(request('date')); ?>" class="input-field">
                <input type="hidden" name="agenda_start" value="<?php echo e(request('agenda_start', $agendaStart->toDateString())); ?>">
                <button type="submit" class="btn-primary">Filter</button>
                <a href="<?php echo e(route('admin.bookings.create')); ?>" class="btn-secondary">Add Booking</a>
            </form>
        </div>

        <div class="glass-card p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="font-serif text-2xl font-bold text-gray-900">Weekly Agenda</h2>
                    <p class="text-sm text-gray-600">
                        <?php echo e($agendaStart->format('M d')); ?> - <?php echo e($agendaEnd->format('M d, Y')); ?>

                    </p>
                </div>
                <?php
                    $baseQuery = request()->query();
                ?>
                <div class="flex space-x-2">
                    <a href="<?php echo e(route('admin.bookings.index', array_merge($baseQuery, ['agenda_start' => $agendaPrev]))); ?>" class="px-4 py-2 bg-gray-100 rounded-lg text-sm hover:bg-gray-200">Prev</a>
                    <a href="<?php echo e(route('admin.bookings.index', array_merge($baseQuery, ['agenda_start' => $agendaNext]))); ?>" class="px-4 py-2 bg-gray-100 rounded-lg text-sm hover:bg-gray-200">Next</a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php $__currentLoopData = $agendaDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($day['date']->format('D')); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($day['date']->format('M d')); ?></div>
                        </div>
                        <?php if($day['bookings']->count() > 0): ?>
                            <div class="space-y-2">
                                <?php $__currentLoopData = $day['bookings']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="bg-white rounded-lg p-3 border border-gray-100">
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="font-medium"><?php echo e($booking->time); ?></span>
                                            <span class="badge <?php echo e($booking->status === 'confirmed' ? 'badge-success' : ($booking->status === 'pending' ? 'badge-warning' : 'badge-error')); ?>">
                                                <?php echo e($booking->status); ?>

                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-600 mt-1"><?php echo e($booking->service); ?></div>
                                        <div class="text-xs text-gray-500">Client: <?php echo e($booking->client_name); ?></div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-xs text-gray-500">No bookings</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="space-y-4">
            <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="glass-card p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-serif text-xl font-bold text-gray-900"><?php echo e($booking->service); ?></h3>
                        <p class="text-sm text-gray-600">Client: <?php echo e($booking->client_name); ?></p>
                    </div>
                    <span class="badge <?php echo e($booking->status === 'confirmed' ? 'badge-success' : ($booking->status === 'pending' ? 'badge-warning' : 'badge-error')); ?>">
                        <?php echo e($booking->status); ?>

                    </span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-600 mb-4">
                    <div>📅 <?php echo e($booking->date->format('M d, Y')); ?></div>
                    <div>🕐 <?php echo e($booking->time); ?> (<?php echo e($booking->duration); ?> min)</div>
                    <div>👤 <?php echo e($booking->staff_name ?? 'Any Available'); ?></div>
                    <div>💰 $<?php echo e($booking->price); ?></div>
                </div>
                <?php if($booking->staff_payout_percentage): ?>
                    <div class="text-xs text-gray-500 mb-4">
                        Staff payout: <?php echo e($booking->staff_payout_percentage); ?>% (<?php echo e(number_format($booking->staff_payout_amount, 2)); ?>)
                    </div>
                <?php endif; ?>
                <div class="flex space-x-2">
                    <a href="<?php echo e(route('admin.bookings.edit', $booking)); ?>" class="btn-primary text-sm">Edit</a>
                    <form method="POST" action="<?php echo e(route('admin.bookings.destroy', $booking)); ?>" onsubmit="return confirm('Are you sure?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn-secondary bg-danger text-sm">Delete</button>
                    </form>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-12">
                <p class="text-gray-500">No bookings found</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="mt-6">
            <?php echo e($bookings->links()); ?>

        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/admin/bookings.blade.php ENDPATH**/ ?>