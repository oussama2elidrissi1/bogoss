

<?php $__env->startSection('title', 'Packs - Bogos Land Homme'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="font-serif text-5xl font-bold mb-4">Packs disponibles</h1>
                <p class="text-xl max-w-2xl mx-auto">Choisissez un pack complet et réservez en un clic</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <?php if($packs->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $packs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pack): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="glass-card overflow-hidden">
                        <div class="relative h-48 overflow-hidden">
                            <img src="<?php echo e($pack->image ?? 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400'); ?>" alt="<?php echo e($pack->name); ?>" class="w-full h-full object-cover">
                            <div class="absolute top-3 right-3">
                                <span class="badge badge-primary"><?php echo e($pack->category); ?></span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-serif text-xl font-bold text-gray-900 mb-2"><?php echo e($pack->name); ?></h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e($pack->description); ?></p>
                            <div class="flex items-center justify-between mb-4 text-sm text-gray-700">
                                <span>⏱️ <?php echo e($pack->duration); ?> min</span>
                                <span class="text-primary font-bold">$<?php echo e($pack->price); ?></span>
                            </div>
                            <a href="<?php echo e(route('booking', ['service_id' => $pack->id])); ?>" class="w-full btn-primary inline-block text-center">Réserver ce pack</a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-16">
                <div class="text-6xl mb-4">📦</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Aucun pack disponible</h3>
                <p class="text-gray-600">Revenez plus tard pour découvrir nos packs.</p>
            </div>
        <?php endif; ?>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/pages/packs.blade.php ENDPATH**/ ?>