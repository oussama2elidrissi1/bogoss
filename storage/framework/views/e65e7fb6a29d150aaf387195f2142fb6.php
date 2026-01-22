

<?php $__env->startSection('title', 'Staff - Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-4xl font-bold mb-2 text-white">Staff Management</h1>
            <p class="text-xl text-white/90">Manage your team</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6 mb-6">
            <form method="GET" action="<?php echo e(route('admin.staff.index')); ?>" class="flex gap-4">
                <input type="text" name="search" placeholder="Search staff..." value="<?php echo e(request('search')); ?>" class="input-field flex-1">
                <button type="submit" class="btn-primary">Search</button>
                <a href="<?php echo e(route('admin.staff.create')); ?>" class="btn-secondary">Add Staff</a>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="glass-card p-6">
                <div class="flex items-start space-x-4 mb-4">
                    <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        <?php echo e(substr($member->name, 0, 1)); ?>

                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-serif text-xl font-bold text-gray-900"><?php echo e($member->name); ?></h3>
                                <p class="text-sm text-gray-600"><?php echo e(is_array($member->role) ? implode(', ', $member->role) : $member->role); ?></p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="<?php echo e(route('admin.staff.history', $member)); ?>" class="btn-secondary text-sm">Voir situation</a>
                                <a href="<?php echo e(route('admin.staff.edit', $member)); ?>" class="btn-primary text-sm">Edit</a>
                                <form method="POST" action="<?php echo e(route('admin.staff.destroy', $member)); ?>" onsubmit="return confirm('Are you sure?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn-secondary bg-danger text-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="text-yellow-500">⭐</span>
                            <span class="text-sm font-bold"><?php echo e($member->rating); ?></span>
                            <span class="text-xs text-gray-500">(<?php echo e($member->completed_services); ?> services)</span>
                        </div>
                    </div>
                </div>
                <div class="space-y-2 text-sm text-gray-600">
                    <p>📧 <?php echo e($member->email); ?></p>
                    <p>📞 <?php echo e($member->phone); ?></p>
                </div>
                <div class="mt-4">
                    <p class="text-xs text-gray-600 mb-2">Specialties:</p>
                    <div class="flex flex-wrap gap-2">
                        <?php $__currentLoopData = $member->specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge badge-primary"><?php echo e($specialty); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-2 text-center py-12">
                <p class="text-gray-500">No staff members found</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="mt-6">
            <?php echo e($staff->links()); ?>

        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/admin/staff.blade.php ENDPATH**/ ?>