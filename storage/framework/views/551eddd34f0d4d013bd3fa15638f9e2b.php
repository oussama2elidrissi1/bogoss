<?php $__env->startSection('title', 'Edit Staff - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6">
            <h1 class="font-serif text-3xl font-bold mb-6">Edit Staff</h1>
            <form method="POST" action="<?php echo e(route('admin.staff.update', $staff)); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                    <input type="text" name="name" class="input-field" value="<?php echo e($staff->name); ?>" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <input type="text" name="role" class="input-field" value="<?php echo e($staff->role); ?>" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Specialties (comma separated)</label>
                    <input type="text" name="specialties" class="input-field" value="<?php echo e(is_array($staff->specialties) ? implode(', ', $staff->specialties) : ''); ?>" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" class="input-field" value="<?php echo e($staff->email); ?>" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                    <input type="text" name="phone" class="input-field" value="<?php echo e($staff->phone); ?>" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Availability (comma separated days)</label>
                    <input type="text" name="availability" class="input-field" value="<?php echo e(is_array($staff->availability) ? implode(', ', $staff->availability) : ''); ?>" required>
                </div>
                <div class="pt-2 border-t border-gray-200">
                    <h2 class="text-sm font-semibold text-gray-800 mb-2">Service Payout Percentages</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $currentPercent = $staff->services->firstWhere('id', $service->id)?->pivot?->payout_percentage;
                            ?>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1"><?php echo e($service->name); ?></label>
                                <div class="flex items-center gap-2">
                                    <input
                                        type="number"
                                        name="payout_percentages[<?php echo e($service->id); ?>]"
                                        class="input-field"
                                        min="0"
                                        max="100"
                                        step="0.01"
                                        value="<?php echo e($currentPercent); ?>"
                                        placeholder="0"
                                    >
                                    <span class="text-xs text-gray-500">%</span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn-primary">Update</button>
                    <a href="<?php echo e(route('admin.staff.index')); ?>" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/admin/staff-edit.blade.php ENDPATH**/ ?>