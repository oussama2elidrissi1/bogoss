

<?php $__env->startSection('title', 'Inventory - Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-4xl font-bold mb-2 text-white">Inventory Management</h1>
            <p class="text-xl text-white/90">Track and manage your supplies</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6 mb-6">
            <form method="GET" action="<?php echo e(route('admin.inventory.index')); ?>" class="flex gap-4">
                <select name="category" class="input-field">
                    <option value="">All Categories</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category); ?>" <?php echo e(request('category') == $category ? 'selected' : ''); ?>><?php echo e($category); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <select name="status" class="input-field">
                    <option value="">All Status</option>
                    <option value="in-stock" <?php echo e(request('status') == 'in-stock' ? 'selected' : ''); ?>>In Stock</option>
                    <option value="low-stock" <?php echo e(request('status') == 'low-stock' ? 'selected' : ''); ?>>Low Stock</option>
                    <option value="critical" <?php echo e(request('status') == 'critical' ? 'selected' : ''); ?>>Critical</option>
                </select>
                <button type="submit" class="btn-primary">Filter</button>
                <a href="<?php echo e(route('admin.inventory.create')); ?>" class="btn-secondary">Add Item</a>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $inventory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="glass-card p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-serif text-xl font-bold text-gray-900"><?php echo e($item->name); ?></h3>
                        <span class="badge badge-primary"><?php echo e($item->category); ?></span>
                    </div>
                    <span class="badge <?php echo e($item->status === 'in-stock' ? 'badge-success' : ($item->status === 'low-stock' ? 'badge-warning' : 'badge-error')); ?>">
                        <?php echo e(ucfirst(str_replace('-', ' ', $item->status))); ?>

                    </span>
                </div>
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Current Stock</span>
                        <span class="text-2xl font-bold <?php echo e($item->quantity <= $item->min_quantity ? 'text-danger' : 'text-gray-900'); ?>">
                            <?php echo e($item->quantity); ?> <?php echo e($item->unit); ?>

                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full <?php echo e($item->quantity <= $item->min_quantity * 0.5 ? 'bg-danger' : ($item->quantity <= $item->min_quantity ? 'bg-warning' : 'bg-success')); ?>" 
                             style="width: <?php echo e(min(($item->quantity / ($item->min_quantity * 2)) * 100, 100)); ?>%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Min: <?php echo e($item->min_quantity); ?></span>
                        <span>Target: <?php echo e($item->min_quantity * 2); ?></span>
                    </div>
                </div>
                <div class="space-y-2 text-sm mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Unit Price</span>
                        <span class="font-medium">MAD <?php echo e($item->price); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Supplier</span>
                        <span class="font-medium"><?php echo e($item->supplier); ?></span>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="<?php echo e(route('admin.inventory.edit', $item)); ?>" class="btn-primary flex-1 text-center text-sm">Edit</a>
                    <form method="POST" action="<?php echo e(route('admin.inventory.destroy', $item)); ?>" onsubmit="return confirm('Are you sure?')" class="flex-1">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn-secondary bg-danger w-full text-sm">Delete</button>
                    </form>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">No inventory items found</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="mt-6">
            <?php echo e($inventory->links()); ?>

        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/admin/inventory.blade.php ENDPATH**/ ?>