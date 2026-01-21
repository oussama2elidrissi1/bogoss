<?php $__env->startSection('title', 'Book Appointment - Bogos Land Wellness'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="font-serif text-5xl font-bold mb-4">Book Your Appointment</h1>
                <p class="text-xl max-w-2xl mx-auto">Choose your service and preferred date to get started</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <?php if(session('success')): ?>
            <div class="glass-card p-4 mb-6 text-green-700 bg-green-50">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="mb-8">
                    <h2 class="font-serif text-2xl font-bold text-gray-900 mb-4">Select a Service</h2>
                    <div class="flex flex-wrap gap-3 mb-6">
                        <a href="<?php echo e(route('booking', ['category' => 'All', 'date' => $selectedDate->toDateString(), 'service_id' => optional($selectedService)->id])); ?>" class="px-6 py-2 rounded-full font-medium transition-all duration-300 <?php echo e($selectedCategory === 'All' ? 'bg-primary text-white shadow-lg scale-105' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'); ?>">All</a>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('booking', ['category' => $category, 'date' => $selectedDate->toDateString(), 'service_id' => optional($selectedService)->id])); ?>" class="px-6 py-2 rounded-full font-medium transition-all duration-300 <?php echo e($selectedCategory === $category ? 'bg-primary text-white shadow-lg scale-105' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'); ?>"><?php echo e($category); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="glass-card overflow-hidden">
                                <div class="relative h-40 overflow-hidden">
                                    <img src="<?php echo e($service->image ?? 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400'); ?>" alt="<?php echo e($service->name); ?>" class="w-full h-full object-cover">
                                    <div class="absolute top-3 right-3">
                                        <span class="badge badge-primary"><?php echo e($service->category); ?></span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-serif text-lg font-bold text-gray-900 mb-2"><?php echo e($service->name); ?></h3>
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2"><?php echo e($service->description); ?></p>
                                    <div class="flex items-center justify-between mb-3 text-sm text-gray-700">
                                        <span>⏱️ <?php echo e($service->duration); ?> min</span>
                                        <span class="text-primary font-bold">$<?php echo e($service->price); ?></span>
                                    </div>
                                    <a href="<?php echo e(route('booking', ['service_id' => $service->id, 'category' => $selectedCategory, 'date' => $selectedDate->toDateString()])); ?>" class="w-full btn-primary inline-block text-center">Select Service</a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="glass-card p-6">
                    <h2 class="font-serif text-2xl font-bold text-gray-900 mb-4">Select Date</h2>
                    <form method="GET" class="space-y-4">
                        <input type="hidden" name="category" value="<?php echo e($selectedCategory); ?>">
                        <input type="hidden" name="service_id" value="<?php echo e(optional($selectedService)->id); ?>">
                        <input type="date" name="date" min="<?php echo e(now()->toDateString()); ?>" value="<?php echo e($selectedDate->toDateString()); ?>" class="input-field" onchange="this.form.submit()">
                    </form>
                </div>

                <div class="glass-card p-6">
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-4">Bookings on <?php echo e($selectedDate->format('M d, Y')); ?></h3>
                    <?php if($dateBookings->count() > 0): ?>
                        <div class="space-y-3">
                            <?php $__currentLoopData = $dateBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="font-medium text-gray-900"><?php echo e($booking->service); ?></span>
                                        <span class="badge badge-primary"><?php echo e($booking->time); ?></span>
                                    </div>
                                    <p class="text-sm text-gray-600"><?php echo e($booking->client_name); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 text-sm">No bookings for this date</p>
                    <?php endif; ?>
                </div>

                <div class="glass-card p-6">
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-4">Available Staff</h3>
                    <?php if($availableStaff->count() > 0): ?>
                        <div class="space-y-3">
                            <?php $__currentLoopData = $availableStaff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center space-x-3 bg-gray-50 rounded-lg p-3">
                                    <img src="<?php echo e($staff->image ?? 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200'); ?>" alt="<?php echo e($staff->name); ?>" class="w-12 h-12 rounded-full object-cover">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900"><?php echo e($staff->name); ?></p>
                                        <p class="text-sm text-gray-600"><?php echo e($staff->role); ?></p>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex items-center space-x-1">
                                            <span class="text-yellow-500">★</span>
                                            <span class="text-sm font-medium"><?php echo e($staff->rating); ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 text-sm">No staff available on this day</p>
                    <?php endif; ?>
                </div>

                <div class="glass-card p-6">
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-4">Confirm Booking</h3>
                    <?php if(auth()->guard()->guest()): ?>
                        <div class="text-sm text-gray-600 space-y-3">
                            <p>Please sign in to book an appointment.</p>
                            <a href="<?php echo e(route('login')); ?>" class="btn-primary inline-block">Sign In</a>
                        </div>
                    <?php else: ?>
                        <?php if($selectedService): ?>
                            <form method="POST" action="<?php echo e(route('booking.store')); ?>" class="space-y-4">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="service_id" value="<?php echo e($selectedService->id); ?>">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                                    <input type="date" name="date" min="<?php echo e(now()->toDateString()); ?>" value="<?php echo e($selectedDate->toDateString()); ?>" class="input-field" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Time</label>
                                    <select name="time" class="input-field" required>
                                        <option value="">Choose a time slot</option>
                                        <?php $__currentLoopData = $timeSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($slot); ?>"><?php echo e($slot); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Staff (Optional)</label>
                                    <select name="staff_id" class="input-field">
                                        <option value="">Any Available</option>
                                        <?php $__currentLoopData = $availableStaff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($staff->id); ?>"><?php echo e($staff->name); ?> - <?php echo e($staff->role); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                                    <textarea name="notes" rows="3" class="input-field resize-none" placeholder="Any special requests or preferences..."></textarea>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Service</span>
                                        <span class="font-medium"><?php echo e($selectedService->name); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Duration</span>
                                        <span class="font-medium"><?php echo e($selectedService->duration); ?> minutes</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Price</span>
                                        <span class="font-bold text-primary">$<?php echo e($selectedService->price); ?></span>
                                    </div>
                                </div>
                                <button type="submit" class="w-full btn-primary">Confirm Booking</button>
                            </form>
                        <?php else: ?>
                            <p class="text-sm text-gray-600">Select a service to continue.</p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/pages/booking.blade.php ENDPATH**/ ?>