<?php $__env->startSection('title', 'Edit Booking - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6">
            <h1 class="font-serif text-3xl font-bold mb-6">Edit Booking</h1>
            <?php if($errors->any()): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm mb-4">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>
            <form method="POST" action="<?php echo e(route('admin.bookings.update', $booking)); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Client</label>
                    <select name="client_id" class="input-field" required>
                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($client->id); ?>" <?php echo e(old('client_id', $booking->client_id) == $client->id ? 'selected' : ''); ?>>
                                <?php echo e($client->name); ?> (<?php echo e($client->email); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Service</label>
                    <select name="service_id" class="input-field" required>
                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($service->id); ?>" <?php echo e(old('service_id', $booking->service_id) == $service->id ? 'selected' : ''); ?>><?php echo e($service->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Staff (Optional)</label>
                    <select name="staff_id" class="input-field">
                        <option value="">Any Available</option>
                        <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($member->id); ?>" <?php echo e(old('staff_id', $booking->staff_id) == $member->id ? 'selected' : ''); ?>><?php echo e($member->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                        <input type="date" name="date" class="input-field" value="<?php echo e(old('date', $booking->date->toDateString())); ?>" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Time</label>
                        <input type="time" name="time" class="input-field" value="<?php echo e(old('time', $booking->time)); ?>" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="input-field">
                        <?php $__currentLoopData = ['pending', 'confirmed', 'cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($status); ?>" <?php echo e(old('status', $booking->status) === $status ? 'selected' : ''); ?>><?php echo e(ucfirst($status)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" class="input-field" rows="3"><?php echo e(old('notes', $booking->notes)); ?></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn-primary">Update</button>
                    <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/admin/bookings-edit.blade.php ENDPATH**/ ?>