<?php $__env->startSection('title', __('pages.subscriptions.title')); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="font-serif text-5xl font-bold mb-4"><?php echo e(__('pages.subscriptions.hero_title')); ?></h1>
                <p class="text-xl max-w-2xl mx-auto"><?php echo e(__('pages.subscriptions.hero_subtitle')); ?></p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <?php if(session('success')): ?>
            <div class="glass-card p-4 mb-6 text-green-700 bg-green-50">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="glass-card p-8 relative <?php echo e($plan->popular ? 'ring-4 ring-primary scale-105' : ''); ?>">
                    <?php if($plan->popular): ?>
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                            <div class="bg-primary text-white px-4 py-1 rounded-full text-sm font-bold flex items-center space-x-1">
                                <span>⭐</span>
                                <span><?php echo e(__('pages.subscriptions.most_popular')); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="text-center mb-6">
                        <h3 class="font-serif text-2xl font-bold text-gray-900 mb-2"><?php echo e($plan->name); ?></h3>
                        <div class="flex items-baseline justify-center space-x-2">
                            <span class="text-5xl font-bold text-primary">MAD <?php echo e($plan->price); ?></span>
                            <span class="text-gray-600">
                                <?php if($plan->months): ?>
                                    /<?php echo e($plan->months); ?> months
                                <?php else: ?>
                                    /<?php echo e($plan->duration); ?>

                                <?php endif; ?>
                            </span>
                        </div>
                        <?php if($plan->entries): ?>
                            <div class="mt-3 inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-full font-semibold">
                                <span><?php echo e($plan->entries); ?></span>
                                <span>entrées</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php
                        $benefits = is_array($plan->benefits) ? $plan->benefits : json_decode($plan->benefits ?? '[]', true);
                    ?>

                    <ul class="space-y-4 mb-8">
                        <?php $__currentLoopData = $benefits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-5 h-5 rounded-full bg-green-100 flex items-center justify-center mt-0.5">✔</div>
                                <span class="text-gray-700"><?php echo e($benefit); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>

                    <form method="POST" action="<?php echo e(route('subscriptions.subscribe', $plan)); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full py-3 rounded-lg font-medium transition-all duration-300 <?php echo e($plan->popular ? 'btn-primary' : 'bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white'); ?>">
                            <?php echo e(__('pages.subscriptions.choose_plan', ['plan' => $plan->name])); ?>

                        </button>
                    </form>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-16 glass-card p-8">
            <h2 class="font-serif text-3xl font-bold text-gray-900 mb-6 text-center"><?php echo e(__('pages.subscriptions.why_title')); ?></h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-2xl">💰</span>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-2"><?php echo e(__('pages.subscriptions.benefits.save_title')); ?></h3>
                    <p class="text-gray-600"><?php echo e(__('pages.subscriptions.benefits.save_desc')); ?></p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-2xl">⭐</span>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-2"><?php echo e(__('pages.subscriptions.benefits.priority_title')); ?></h3>
                    <p class="text-gray-600"><?php echo e(__('pages.subscriptions.benefits.priority_desc')); ?></p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-2xl">🎁</span>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-2"><?php echo e(__('pages.subscriptions.benefits.exclusive_title')); ?></h3>
                    <p class="text-gray-600"><?php echo e(__('pages.subscriptions.benefits.exclusive_desc')); ?></p>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-gray-600 mb-4"><?php echo e(__('pages.subscriptions.cta_question')); ?></p>
            <button class="btn-outline"><?php echo e(__('pages.subscriptions.cta_contact')); ?></button>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/pages/subscriptions.blade.php ENDPATH**/ ?>