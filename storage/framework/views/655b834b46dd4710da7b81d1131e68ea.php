<?php $__env->startSection('title', __('pages.shop.title')); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="font-serif text-5xl font-bold mb-4"><?php echo e(__('pages.shop.hero_title')); ?></h1>
                <p class="text-xl max-w-2xl mx-auto"><?php echo e(__('pages.shop.hero_subtitle')); ?></p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <?php if(session('success')): ?>
            <div class="glass-card p-4 mb-6 text-green-700 bg-green-50">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <form method="GET" class="flex-1 w-full md:w-auto">
                <div class="relative">
                    <input
                        type="text"
                        name="q"
                        placeholder="<?php echo e(__('pages.common.search_product')); ?>"
                        value="<?php echo e($searchQuery); ?>"
                        class="input-field pl-10 w-full"
                    />
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">🔍</span>
                    <input type="hidden" name="category" value="<?php echo e($selectedCategory); ?>">
                </div>
            </form>
            <a href="#cart" class="btn-primary relative flex items-center space-x-2">
                <span>🛒</span>
                <span><?php echo e(__('pages.shop.cart')); ?></span>
                <?php if($cartItemsCount > 0): ?>
                    <span class="absolute -top-2 -right-2 bg-accent text-white text-xs rounded-full w-6 h-6 flex items-center justify-center font-bold"><?php echo e($cartItemsCount); ?></span>
                <?php endif; ?>
            </a>
        </div>

        <div class="flex flex-wrap gap-3 mb-8">
            <a href="<?php echo e(route('shop', ['category' => 'All', 'q' => $searchQuery])); ?>" class="px-6 py-2 rounded-full font-medium transition-all duration-300 <?php echo e($selectedCategory === 'All' ? 'bg-primary text-white shadow-lg scale-105' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'); ?>"><?php echo e(__('pages.common.all')); ?></a>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('shop', ['category' => $category, 'q' => $searchQuery])); ?>" class="px-6 py-2 rounded-full font-medium transition-all duration-300 <?php echo e($selectedCategory === $category ? 'bg-primary text-white shadow-lg scale-105' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'); ?>"><?php echo e($category); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="glass-card overflow-hidden">
                    <div class="relative h-64 overflow-hidden">
                        <img src="<?php echo e($product->image ?? 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=400'); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                        <?php if(!$product->in_stock): ?>
                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                <span class="bg-red-500 text-white px-4 py-2 rounded-lg font-bold"><?php echo e(__('pages.shop.out_of_stock')); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-serif text-xl font-bold text-gray-900"><?php echo e($product->name); ?></h3>
                            <div class="flex items-center space-x-1">
                                <span class="text-yellow-500">★</span>
                                <span class="text-sm font-medium"><?php echo e($product->rating); ?></span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2"><?php echo e($product->description); ?></p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-primary">MAD <?php echo e($product->price); ?></span>
                            <form method="POST" action="<?php echo e(route('cart.add', $product)); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn-primary" <?php echo e($product->in_stock ? '' : 'disabled'); ?>><?php echo e(__('pages.common.add')); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <section id="cart" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="glass-card p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-serif text-2xl font-bold text-gray-900"><?php echo e(__('pages.shop.cart_title')); ?> (<?php echo e($cartItemsCount); ?>)</h2>
            </div>

            <?php if($cart->count() > 0): ?>
                <div class="space-y-4 mb-6">
                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center space-x-4 bg-gray-50 rounded-lg p-4">
                            <img src="<?php echo e($item['image'] ?? 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=200'); ?>" alt="<?php echo e($item['name']); ?>" class="w-20 h-20 object-cover rounded-lg">
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900"><?php echo e($item['name']); ?></h3>
                                <p class="text-sm text-gray-600">MAD <?php echo e($item['price']); ?> <?php echo e(__('pages.shop.each')); ?></p>
                            </div>
                            <form method="POST" action="<?php echo e(route('cart.update', $item['id'])); ?>" class="flex items-center space-x-2">
                                <?php echo csrf_field(); ?>
                                <input type="number" name="quantity" min="1" max="99" value="<?php echo e($item['quantity']); ?>" class="input-field w-20">
                                <button type="submit" class="px-3 py-2 bg-gray-100 rounded-lg"><?php echo e(__('pages.common.update')); ?></button>
                            </form>
                            <div class="text-right">
                                <p class="font-bold text-primary">MAD <?php echo e(number_format($item['price'] * $item['quantity'], 2)); ?></p>
                                <form method="POST" action="<?php echo e(route('cart.remove', $item['id'])); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-xs text-red-600 hover:text-red-700"><?php echo e(__('pages.common.remove')); ?></button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-medium text-gray-700"><?php echo e(__('pages.common.total')); ?></span>
                        <span class="text-2xl font-bold text-primary">MAD <?php echo e(number_format($cartTotal, 2)); ?></span>
                    </div>
                    <div class="flex space-x-3">
                        <form method="POST" action="<?php echo e(route('cart.clear')); ?>" class="flex-1">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full px-6 py-3 border-2 border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-colors"><?php echo e(__('pages.shop.clear_cart')); ?></button>
                        </form>
                        <form method="POST" action="<?php echo e(route('cart.checkout')); ?>" class="flex-1">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full btn-primary"><?php echo e(__('pages.shop.checkout')); ?></button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">🛒</div>
                    <p class="text-gray-600"><?php echo e(__('pages.shop.empty_cart')); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/pages/shop.blade.php ENDPATH**/ ?>