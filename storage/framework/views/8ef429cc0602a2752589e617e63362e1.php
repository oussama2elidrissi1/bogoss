

<?php $__env->startSection('title', 'Clients - Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-4xl font-bold mb-2 text-white">Client Management</h1>
            <p class="text-xl text-white/90">Manage your client database</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6 mb-6">
            <form method="GET" action="<?php echo e(route('admin.clients.index')); ?>" class="flex gap-4">
                <input type="text" name="search" placeholder="Search clients..." value="<?php echo e(request('search')); ?>" class="input-field flex-1">
                <button type="submit" class="btn-primary">Search</button>
                <a href="<?php echo e(route('admin.clients.create')); ?>" class="btn-secondary">Add Client</a>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="glass-card p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-serif text-xl font-bold text-gray-900"><?php echo e($client->name); ?></h3>
                        <?php if($client->subscription): ?>
                            <span class="badge badge-primary"><?php echo e($client->subscription); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="flex space-x-2">
                        <a href="<?php echo e(route('admin.clients.edit', $client)); ?>" class="btn-primary text-sm">Edit</a>
                        <form method="POST" action="<?php echo e(route('admin.clients.destroy', $client)); ?>" onsubmit="return confirm('Are you sure?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn-secondary bg-danger text-sm">Delete</button>
                        </form>
                    </div>
                </div>
                <div class="space-y-2 text-sm text-gray-600">
                    <p>📧 <?php echo e($client->email); ?></p>
                    <p>📞 <?php echo e($client->phone); ?></p>
                    <p>📅 Joined <?php echo e($client->join_date->format('M d, Y')); ?></p>
                </div>
                <div class="grid grid-cols-3 gap-4 pt-4 border-t border-gray-200 mt-4">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-primary"><?php echo e($client->visits); ?></p>
                        <p class="text-xs text-gray-600">Visits</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-secondary">MAD <?php echo e($client->total_spent); ?></p>
                        <p class="text-xs text-gray-600">Spent</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm font-medium"><?php echo e($client->last_visit ? $client->last_visit->format('M d') : 'N/A'); ?></p>
                        <p class="text-xs text-gray-600">Last Visit</p>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-2 text-center py-12">
                <p class="text-gray-500">No clients found</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="mt-6">
            <?php echo e($clients->links()); ?>

        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/admin/clients.blade.php ENDPATH**/ ?>