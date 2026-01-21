<?php $__env->startSection('title', 'Products - Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-white">
                <h1 class="font-serif text-4xl font-bold mb-2">Product Management</h1>
                <p class="text-xl">Manage your shop products and inventory</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <form method="GET" class="mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <input type="text" name="q" placeholder="Search products..." value="<?php echo e($searchQuery); ?>" class="input-field pl-10 w-full">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">🔍</span>
                </div>
                <select name="stock" class="input-field md:w-48">
                    <option value="all" <?php echo e($stockFilter === 'all' ? 'selected' : ''); ?>>All Stock</option>
                    <option value="in-stock" <?php echo e($stockFilter === 'in-stock' ? 'selected' : ''); ?>>In Stock</option>
                    <option value="out-of-stock" <?php echo e($stockFilter === 'out-of-stock' ? 'selected' : ''); ?>>Out of Stock</option>
                </select>
                <button class="btn-primary">Filter</button>
            </div>
            <div class="flex flex-wrap gap-3 mt-4">
                <a href="<?php echo e(route('admin.products.index', ['category' => 'All', 'q' => $searchQuery, 'stock' => $stockFilter])); ?>" class="px-6 py-2 rounded-full font-medium transition-all duration-300 <?php echo e($selectedCategory === 'All' ? 'bg-primary text-white shadow-lg scale-105' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'); ?>">All</a>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('admin.products.index', ['category' => $category, 'q' => $searchQuery, 'stock' => $stockFilter])); ?>" class="px-6 py-2 rounded-full font-medium transition-all duration-300 <?php echo e($selectedCategory === $category ? 'bg-primary text-white shadow-lg scale-105' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'); ?>"><?php echo e($category); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="glass-card overflow-hidden">
                    <div class="relative h-48 overflow-hidden">
                        <img src="<?php echo e($product->image ?? 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=400'); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover">
                        <div class="absolute top-3 right-3">
                            <span class="badge <?php echo e($product->in_stock ? 'badge-success' : 'badge-error'); ?>"><?php echo e($product->in_stock ? 'In Stock' : 'Out of Stock'); ?></span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex-1">
                                <h3 class="font-serif text-xl font-bold text-gray-900 mb-1"><?php echo e($product->name); ?></h3>
                                <span class="badge badge-primary"><?php echo e($product->category); ?></span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <span class="text-yellow-500">★</span>
                                <span class="text-sm font-medium"><?php echo e($product->rating); ?></span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2"><?php echo e($product->description); ?></p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-primary font-bold">$<?php echo e($product->price); ?></span>
                        </div>
                        <div class="flex space-x-2">
                            <button class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors text-sm font-medium">Edit</button>
                            <button class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors text-sm">Delete</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-3 text-center py-16">
                    <div class="text-6xl mb-4">📦</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-600">Try adjusting your search or filter criteria</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/admin/products.blade.php ENDPATH**/ ?>