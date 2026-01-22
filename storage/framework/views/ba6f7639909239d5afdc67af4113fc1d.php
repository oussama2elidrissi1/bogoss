<?php $__env->startSection('title', 'Accueil - Bogos Land Homme'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen">
    <section class="relative h-[600px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 gradient-wellness opacity-90"></div>
        <div class="absolute inset-0 bg-cover bg-center opacity-25" style="background-image: url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=1920')"></div>
        <div class="relative z-10 text-center text-white px-4 max-w-4xl">
            <h1 class="font-serif text-5xl md:text-6xl font-bold mb-6 text-shadow-lg">Bogos Land Homme</h1>
            <p class="text-xl md:text-2xl mb-8 text-shadow">Bien‑être, grooming & détente dédiés aux hommes</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo e(route('booking')); ?>" class="btn-primary text-lg px-8 py-4">Réserver maintenant</a>
                <a href="<?php echo e(route('services')); ?>" class="btn-outline text-lg px-8 py-4">Découvrir les services</a>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h2 class="font-serif text-4xl font-bold text-gray-900 mb-4">Pourquoi Bogos Land pour hommes ?</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Des soins pensés pour les hommes, avec des résultats visibles</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            <div class="glass-card p-6 text-center">
                <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-2xl">✨</span>
                </div>
                <h3 class="font-serif text-xl font-bold text-gray-900 mb-2">Grooming Premium</h3>
                <p class="text-gray-600 text-sm">Coupe, barbe, soins visage et corps sur‑mesure</p>
            </div>
            <div class="glass-card p-6 text-center">
                <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-2xl">👥</span>
                </div>
                <h3 class="font-serif text-xl font-bold text-gray-900 mb-2">Experts masculins</h3>
                <p class="text-gray-600 text-sm">Une équipe formée aux besoins spécifiques des hommes</p>
            </div>
            <div class="glass-card p-6 text-center">
                <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-2xl">🏆</span>
                </div>
                <h3 class="font-serif text-xl font-bold text-gray-900 mb-2">Produits adaptés</h3>
                <p class="text-gray-600 text-sm">Soins et produits pensés pour la peau masculine</p>
            </div>
            <div class="glass-card p-6 text-center">
                <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-2xl">⏰</span>
                </div>
                <h3 class="font-serif text-xl font-bold text-gray-900 mb-2">Horaires flexibles</h3>
                <p class="text-gray-600 text-sm">Avant ou après le travail, on s’adapte</p>
            </div>
        </div>
    </section>

    <section class="bg-gradient-to-b from-white to-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="font-serif text-4xl font-bold text-gray-900 mb-4">Services populaires pour hommes</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Les meilleurs soins masculins, du grooming au bien‑être</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__empty_1 = true; $__currentLoopData = $services ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="glass-card overflow-hidden">
                    <div class="relative h-48 overflow-hidden">
                        <img src="<?php echo e($service->image ?? 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400'); ?>" alt="<?php echo e($service->name); ?>" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                        <div class="absolute top-3 right-3">
                            <span class="badge badge-primary"><?php echo e($service->category); ?></span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-serif text-xl font-bold text-gray-900 mb-2"><?php echo e($service->name); ?></h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e($service->description); ?></p>
                        <div class="flex items-center justify-between mb-4 text-sm text-gray-700">
                            <span>⏱️ <?php echo e($service->duration); ?> min</span>
                            <span class="text-primary font-bold">MAD <?php echo e($service->price); ?></span>
                        </div>
                        <a href="<?php echo e(route('booking', ['service_id' => $service->id])); ?>" class="w-full btn-primary inline-block text-center">Réserver</a>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500">Aucun service disponible pour le moment.</p>
                </div>
                <?php endif; ?>
            </div>

            <div class="text-center mt-12">
                <a href="<?php echo e(route('services')); ?>" class="btn-primary text-lg px-8 py-4">Voir tous les services</a>
            </div>
        </div>
    </section>

    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h2 class="font-serif text-4xl font-bold mb-6">Prêt pour votre routine homme ?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Détente, style et confiance, au même endroit</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo e(route('subscriptions')); ?>" class="btn-accent text-lg px-8 py-4">Voir les abonnements</a>
                <a href="<?php echo e(route('booking')); ?>" class="bg-white text-primary hover:bg-gray-100 px-8 py-4 rounded-lg font-medium text-lg transition-all duration-300">Réserver un soin</a>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/home.blade.php ENDPATH**/ ?>