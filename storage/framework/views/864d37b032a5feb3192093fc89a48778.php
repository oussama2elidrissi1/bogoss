<?php $__env->startSection('title', 'Partners - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-white">
                <h1 class="font-serif text-4xl font-bold mb-2">Partners</h1>
                <p class="text-xl">Manage partner accounts and commissions</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between mb-6">
            <form method="GET" class="flex gap-3">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search partners..." class="input-field">
                <button class="btn-primary">Search</button>
            </form>
            <a href="<?php echo e(route('admin.partners.create')); ?>" class="btn-secondary">Add Partner</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="glass-card p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-serif text-xl font-bold"><?php echo e($partner->name); ?></h3>
                        <span class="badge <?php echo e($partner->active ? 'badge-success' : 'badge-error'); ?>"><?php echo e($partner->active ? 'Active' : 'Inactive'); ?></span>
                    </div>
                    <p class="text-sm text-gray-600">Type: <?php echo e($partner->type); ?></p>
                    <p class="text-sm text-gray-600">Commission: <?php echo e($partner->commission_rate); ?>%</p>
                    <p class="text-sm text-gray-600">Contact: <?php echo e($partner->contact_name ?? 'N/A'); ?></p>
                    <div class="flex gap-2 mt-4">
                        <a href="<?php echo e(route('admin.partners.edit', $partner)); ?>" class="btn-primary text-sm">Edit</a>
                        <form method="POST" action="<?php echo e(route('admin.partners.destroy', $partner)); ?>" onsubmit="return confirm('Delete this partner?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn-secondary text-sm">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-500">No partners found.</p>
            <?php endif; ?>
        </div>

        <div class="mt-6"><?php echo e($partners->links()); ?></div>
    </section>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views\admin\partners.blade.php ENDPATH**/ ?>