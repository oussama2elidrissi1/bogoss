

<?php $__env->startSection('title', 'Services - Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-4xl font-bold mb-2 text-white">Service Management</h1>
            <p class="text-xl text-white/90">Manage your service catalog</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6 mb-6">
            <form method="GET" action="<?php echo e(route('admin.services.index')); ?>" class="flex gap-4 mb-4">
                <input type="text" name="search" placeholder="Search services..." value="<?php echo e(request('search')); ?>" class="input-field flex-1">
                <select name="category" class="input-field">
                    <option value="">All Categories</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category); ?>" <?php echo e(request('category') == $category ? 'selected' : ''); ?>><?php echo e($category); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button type="submit" class="btn-primary">Search</button>
                <a href="<?php echo e(route('admin.services.create')); ?>" class="btn-secondary">Add Service</a>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="glass-card overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-serif text-xl font-bold text-gray-900"><?php echo e($service->name); ?></h3>
                            <span class="badge badge-primary"><?php echo e($service->category); ?></span>
                        </div>
                        <span class="badge <?php echo e($service->available ? 'badge-success' : 'badge-error'); ?>">
                            <?php echo e($service->available ? 'Available' : 'Unavailable'); ?>

                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-4"><?php echo e($service->description); ?></p>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-600">⏱️ <?php echo e($service->duration); ?> min</span>
                        <span class="text-2xl font-bold text-primary">MAD <?php echo e($service->price); ?></span>
                    </div>
                    <div class="flex space-x-2">
                        <a href="<?php echo e(route('admin.services.edit', $service)); ?>" class="btn-primary flex-1 text-center text-sm">Edit</a>
                        <form method="POST" action="<?php echo e(route('admin.services.destroy', $service)); ?>" onsubmit="return confirm('Are you sure?')" class="flex-1">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn-secondary bg-danger w-full text-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">No services found</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="mt-6">
            <?php echo e($services->links()); ?>

        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/admin/services.blade.php ENDPATH**/ ?>