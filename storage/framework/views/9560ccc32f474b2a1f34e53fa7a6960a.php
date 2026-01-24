

<?php $__env->startSection('title', __('app.auth.register') . ' - Bogos Land Wellness'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="glass-card p-8">
            <h2 class="font-serif text-3xl font-bold text-center mb-6"><?php echo e(__('app.auth.register')); ?></h2>
            
            <?php if($errors->any()): ?>
                <div class="bg-danger/10 text-danger p-4 rounded-lg mb-4">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.auth.name')); ?></label>
                    <input type="text" name="name" required class="input-field" value="<?php echo e(old('name')); ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.auth.email')); ?></label>
                    <input type="email" name="email" required class="input-field" value="<?php echo e(old('email')); ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.auth.password')); ?></label>
                    <input type="password" name="password" required class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('app.auth.confirm_password')); ?></label>
                    <input type="password" name="password_confirmation" required class="input-field">
                </div>
                <button type="submit" class="btn-primary w-full"><?php echo e(__('app.auth.register')); ?></button>
            </form>

            <p class="mt-4 text-center text-sm text-gray-600">
                <?php echo e(__('app.auth.have_account')); ?> <a href="<?php echo e(route('login')); ?>" class="text-primary hover:underline"><?php echo e(__('app.auth.sign_in')); ?></a>
            </p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views\auth\register.blade.php ENDPATH**/ ?>