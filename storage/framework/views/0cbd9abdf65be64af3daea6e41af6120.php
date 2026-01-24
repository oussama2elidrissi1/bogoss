

<?php $__env->startSection('title', __('pages.partner.title')); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="font-serif text-5xl font-bold mb-4"><?php echo e(__('pages.partner.hero_title')); ?></h1>
                <p class="text-xl max-w-2xl mx-auto"><?php echo e(__('pages.partner.hero_subtitle')); ?></p>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="glass-card p-8">
                <h2 class="font-serif text-3xl font-bold text-gray-900 mb-4"><?php echo e(__('pages.partner.why_title')); ?></h2>
                <ul class="space-y-4 text-gray-600">
                    <li>✔️ <?php echo e(__('pages.partner.why_points.catalog')); ?></li>
                    <li>✔️ <?php echo e(__('pages.partner.why_points.bookings')); ?></li>
                    <li>✔️ <?php echo e(__('pages.partner.why_points.commissions')); ?></li>
                    <li>✔️ <?php echo e(__('pages.partner.why_points.support')); ?></li>
                </ul>
            </div>
            <div class="glass-card p-8">
                <h2 class="font-serif text-3xl font-bold text-gray-900 mb-4"><?php echo e(__('pages.partner.form_title')); ?></h2>
                <p class="text-gray-600 mb-6"><?php echo e(__('pages.partner.form_subtitle')); ?></p>
                <form method="GET" action="<?php echo e(route('partner.info')); ?>" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('pages.partner.form.company_label')); ?></label>
                        <input type="text" class="input-field" placeholder="<?php echo e(__('pages.partner.form.company_placeholder')); ?>">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('pages.partner.form.contact_label')); ?></label>
                        <input type="text" class="input-field" placeholder="<?php echo e(__('pages.partner.form.contact_placeholder')); ?>">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('pages.partner.form.email_label')); ?></label>
                        <input type="email" class="input-field" placeholder="<?php echo e(__('pages.partner.form.email_placeholder')); ?>">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e(__('pages.partner.form.phone_label')); ?></label>
                        <input type="text" class="input-field" placeholder="<?php echo e(__('pages.partner.form.phone_placeholder')); ?>">
                    </div>
                    <button type="submit" class="btn-primary w-full"><?php echo e(__('pages.partner.form.submit')); ?></button>
                </form>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/pages/partner.blade.php ENDPATH**/ ?>