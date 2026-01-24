<?php $__env->startSection('title', 'Promotions - Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-white">
                <h1 class="font-serif text-4xl font-bold mb-2">Promotion Management</h1>
                <p class="text-xl">Manage discounts and special offers</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <form method="GET" class="mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <input type="text" name="q" placeholder="Search promotions..." value="<?php echo e($searchQuery); ?>" class="input-field pl-10 w-full">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">🔍</span>
                </div>
                <select name="status" class="input-field md:w-48">
                    <?php $__currentLoopData = ['All', 'active', 'expired', 'inactive']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($status); ?>" <?php echo e($statusFilter === $status ? 'selected' : ''); ?>><?php echo e(ucfirst($status)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button class="btn-primary">Filter</button>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $promotions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="glass-card overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-serif text-xl font-bold text-gray-900"><?php echo e($promo->title); ?></h3>
                                <span class="badge <?php echo e($promo->status === 'active' ? 'badge-success' : 'badge-error'); ?>"><?php echo e($promo->status); ?></span>
                            </div>
                        </div>

                        <p class="text-sm text-gray-600 mb-4"><?php echo e($promo->description); ?></p>

                        <div class="bg-gray-50 rounded-lg p-4 mb-4 space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Discount</span>
                                <span class="font-bold text-primary">
                                    <?php echo e($promo->type === 'percentage' ? $promo->discount.'%' : '$'.$promo->discount); ?>

                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Code</span>
                                <span class="font-mono font-medium"><?php echo e($promo->code); ?></span>
                            </div>
                            <div class="flex items-center space-x-2 text-gray-600">
                                <span>📅</span>
                                <span><?php echo e($promo->valid_from); ?> - <?php echo e($promo->valid_until); ?></span>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <button class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors text-sm font-medium">Edit</button>
                            <button class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors text-sm">Delete</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-3 text-center py-16">
                    <div class="text-6xl mb-4">🏷️</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No promotions found</h3>
                    <p class="text-gray-600">Try adjusting your search or filter criteria</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views\admin\promotions.blade.php ENDPATH**/ ?>