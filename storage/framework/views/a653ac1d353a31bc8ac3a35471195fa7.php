<?php $__env->startSection('title', 'Add Partner - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6">
            <h1 class="font-serif text-3xl font-bold mb-6">Add Partner</h1>
            <form method="POST" action="<?php echo e(route('admin.partners.store')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Partner Name</label>
                    <input type="text" name="name" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <input type="text" name="type" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact Name</label>
                    <input type="text" name="contact_name" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact Email</label>
                    <input type="email" name="contact_email" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact Phone</label>
                    <input type="text" name="contact_phone" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Commission Rate (%)</label>
                    <input type="number" step="0.01" name="commission_rate" class="input-field" required>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="active" value="1" checked>
                        <span class="ml-2 text-sm">Active</span>
                    </label>
                </div>

                <div class="border-t pt-4">
                    <h2 class="font-serif text-xl font-bold mb-2">Partner Login</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">User Name</label>
                        <input type="text" name="user_name" class="input-field" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">User Email</label>
                        <input type="email" name="user_email" class="input-field" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="user_password" class="input-field" required>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="btn-primary">Save</button>
                    <a href="<?php echo e(route('admin.partners.index')); ?>" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views\admin\partners-create.blade.php ENDPATH**/ ?>