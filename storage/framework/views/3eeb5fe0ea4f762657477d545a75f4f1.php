<?php $__env->startSection('title', __('pages.partner_booking_create.title')); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6">
            <h1 class="font-serif text-3xl font-bold mb-6"><?php echo e(__('pages.partner_booking_create.title_short')); ?></h1>
            <form method="POST" action="<?php echo e(route('partner.bookings.store')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('pages.partner_booking_create.client_name')); ?></label>
                    <input type="text" name="client_name" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('pages.partner_booking_create.client_email')); ?></label>
                    <input type="email" name="client_email" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('pages.partner_booking_create.client_phone')); ?></label>
                    <input type="text" name="client_phone" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('pages.partner_booking_create.service')); ?></label>
                    <select name="service_id" class="input-field" required>
                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('pages.partner_booking_create.staff_optional')); ?></label>
                    <select name="staff_id" class="input-field">
                        <option value=""><?php echo e(__('pages.partner_booking_create.any_staff')); ?></option>
                        <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($member->id); ?>"><?php echo e($member->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('pages.partner_booking_create.date')); ?></label>
                        <input type="date" name="date" class="input-field" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('pages.partner_booking_create.time')); ?></label>
                        <input type="time" name="time" class="input-field" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('pages.partner_booking_create.notes')); ?></label>
                    <textarea name="notes" class="input-field" rows="3"></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn-primary"><?php echo e(__('pages.partner_booking_create.submit')); ?></button>
                    <a href="<?php echo e(route('partner.dashboard')); ?>" class="btn-secondary"><?php echo e(__('pages.common.cancel')); ?></a>
                </div>
            </form>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views\partner\bookings-create.blade.php ENDPATH**/ ?>