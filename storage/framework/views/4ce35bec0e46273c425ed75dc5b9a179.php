

<?php $__env->startSection('title', 'Bookings - Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-4xl font-bold mb-2 text-white">Booking Management</h1>
            <p class="text-xl text-white/90">Manage appointments and schedules</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <?php if(session('success')): ?>
            <div class="glass-card p-4 mb-6 text-green-700 bg-green-50">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="glass-card p-4 mb-6 text-red-700 bg-red-50">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <div class="glass-card p-6 mb-6">
            <form method="GET" action="<?php echo e(route('admin.bookings.index')); ?>" class="flex gap-4">
                <select name="status" class="input-field">
                    <option value="">All Status</option>
                    <option value="confirmed" <?php echo e(request('status') == 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                </select>
                <input type="date" name="date" value="<?php echo e(request('date')); ?>" class="input-field">
                <input type="hidden" name="agenda_start" value="<?php echo e(request('agenda_start', $agendaStart->toDateString())); ?>">
                <button type="submit" class="btn-primary">Filter</button>
                <a href="<?php echo e(route('admin.bookings.create')); ?>" class="btn-secondary">Add Booking</a>
            </form>
        </div>

        <div class="glass-card p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="font-serif text-2xl font-bold text-gray-900">Weekly Agenda</h2>
                    <p class="text-sm text-gray-600">
                        <?php echo e($agendaStart->format('M d')); ?> - <?php echo e($agendaEnd->format('M d, Y')); ?>

                    </p>
                </div>
                <?php
                    $baseQuery = request()->query();
                ?>
                <div class="flex space-x-2">
                    <a href="<?php echo e(route('admin.bookings.index', array_merge($baseQuery, ['agenda_start' => $agendaPrev]))); ?>" class="px-4 py-2 bg-gray-100 rounded-lg text-sm hover:bg-gray-200">Prev</a>
                    <a href="<?php echo e(route('admin.bookings.index', array_merge($baseQuery, ['agenda_start' => $agendaNext]))); ?>" class="px-4 py-2 bg-gray-100 rounded-lg text-sm hover:bg-gray-200">Next</a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php $__currentLoopData = $agendaDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($day['date']->format('D')); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($day['date']->format('M d')); ?></div>
                        </div>
                        <?php if($day['bookings']->count() > 0): ?>
                            <div class="space-y-2">
                                <?php $__currentLoopData = $day['bookings']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div
                                        class="bg-white rounded-lg p-3 border border-gray-100 cursor-pointer hover:border-primary/40 hover:shadow-sm js-booking-card"
                                        data-booking="<?php echo e(json_encode([
                                            'id' => $booking->id,
                                            'client_id' => $booking->client_id,
                                            'service_id' => $booking->service_id,
                                            'staff_id' => $booking->staff_id,
                                            'service' => $booking->service,
                                            'client' => $booking->client_name,
                                            'staff' => $booking->staff_name,
                                            'date' => $booking->date->toDateString(),
                                            'time' => $booking->time,
                                            'duration' => $booking->duration,
                                            'price' => $booking->price,
                                            'status' => $booking->status,
                                            'notes' => $booking->notes,
                                        ])); ?>"
                                    >
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="font-medium"><?php echo e($booking->time); ?></span>
                                            <span class="badge <?php echo e($booking->status === 'confirmed' ? 'badge-success' : ($booking->status === 'pending' ? 'badge-warning' : 'badge-error')); ?>">
                                                <?php echo e($booking->status); ?>

                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-600 mt-1"><?php echo e($booking->service); ?></div>
                                        <div class="text-xs text-gray-500">Client: <?php echo e($booking->client_name); ?></div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-xs text-gray-500">No bookings</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="font-serif text-2xl font-bold text-gray-900">Réservations hors agenda</h3>
            <?php $__empty_1 = true; $__currentLoopData = $nonAgendaBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="glass-card p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-serif text-xl font-bold text-gray-900"><?php echo e($booking->service); ?></h3>
                        <p class="text-sm text-gray-600">Client: <?php echo e($booking->client_name); ?></p>
                    </div>
                    <span class="badge <?php echo e($booking->status === 'confirmed' ? 'badge-success' : ($booking->status === 'pending' ? 'badge-warning' : 'badge-error')); ?>">
                        <?php echo e($booking->status); ?>

                    </span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-600 mb-4">
                    <div>📅 <?php echo e($booking->date->format('M d, Y')); ?></div>
                    <div>🕐 <?php echo e($booking->time); ?> (<?php echo e($booking->duration); ?> min)</div>
                    <div>👤 <?php echo e($booking->staff_name ?? 'Any Available'); ?></div>
                    <div>💰 MAD <?php echo e($booking->price); ?></div>
                </div>
                <?php if($booking->staff_payout_percentage): ?>
                    <div class="text-xs text-gray-500 mb-4">
                        Staff payout: <?php echo e($booking->staff_payout_percentage); ?>% (<?php echo e(number_format($booking->staff_payout_amount, 2)); ?>)
                    </div>
                <?php endif; ?>
                <div class="flex space-x-2">
                    <button
                        type="button"
                        class="btn-primary text-sm js-booking-card"
                        data-booking="<?php echo e(json_encode([
                            'id' => $booking->id,
                            'client_id' => $booking->client_id,
                            'service_id' => $booking->service_id,
                            'staff_id' => $booking->staff_id,
                            'service' => $booking->service,
                            'client' => $booking->client_name,
                            'staff' => $booking->staff_name,
                            'date' => $booking->date->toDateString(),
                            'time' => $booking->time,
                            'duration' => $booking->duration,
                            'price' => $booking->price,
                            'status' => $booking->status,
                            'notes' => $booking->notes,
                        ])); ?>"
                    >
                        View / Edit
                    </button>
                    <form method="POST" action="<?php echo e(route('admin.bookings.destroy', $booking)); ?>" onsubmit="return confirm('Are you sure?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn-secondary bg-danger text-sm">Delete</button>
                    </form>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-12">
                <p class="text-gray-500">No bookings found</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="mt-6">
            <?php echo e($nonAgendaBookings->links()); ?>

        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<div id="booking-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 max-h-[90vh] overflow-hidden">
        <div class="max-h-[85vh] overflow-y-auto pr-1">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-serif text-2xl font-bold text-gray-900">Booking Details</h3>
                <button type="button" class="text-gray-500 hover:text-gray-700" data-close-modal>✕</button>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 mb-6 text-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Service</p>
                        <p class="font-semibold text-gray-900" id="modal-service"></p>
                    </div>
                    <span class="badge badge-warning" id="modal-status"></span>
                </div>
                <div class="grid grid-cols-2 gap-3 mt-4 text-gray-600">
                    <div>Client: <span class="text-gray-900" id="modal-client"></span></div>
                    <div>Staff: <span class="text-gray-900" id="modal-staff"></span></div>
                    <div>Date: <span class="text-gray-900" id="modal-date"></span></div>
                    <div>Time: <span class="text-gray-900" id="modal-time"></span></div>
                    <div>Duration: <span class="text-gray-900" id="modal-duration"></span> min</div>
                    <div>Price: <span class="text-gray-900">MAD </span><span id="modal-price"></span></div>
                </div>
                <div class="mt-3 text-gray-600">
                    Notes: <span class="text-gray-900" id="modal-notes"></span>
                </div>
            </div>

            <form method="POST" id="modal-edit-form" class="space-y-4">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Client</label>
                        <select name="client_id" class="input-field">
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($client->id); ?>"><?php echo e($client->name); ?> (<?php echo e($client->email); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Service</label>
                        <select name="service_id" class="input-field">
                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                        <input type="date" name="date" class="input-field" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Time</label>
                        <input type="time" name="time" class="input-field" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Staff</label>
                    <select name="staff_id" class="input-field">
                        <option value="">Any Available</option>
                        <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($member->id); ?>"><?php echo e($member->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="input-field">
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" rows="3" class="input-field"></textarea>
                </div>
                <button type="submit" class="btn-primary w-full">Update Booking</button>
            </form>
        </div>
    </div>
</div>

<script>
  (function () {
    const modal = document.getElementById('booking-modal');
    const closeBtns = document.querySelectorAll('[data-close-modal]');
    const cards = document.querySelectorAll('.js-booking-card');
    const form = document.getElementById('modal-edit-form');

    const setBadgeClass = (statusEl, status) => {
      statusEl.classList.remove('badge-success', 'badge-warning', 'badge-error');
      if (status === 'confirmed') statusEl.classList.add('badge-success');
      else if (status === 'cancelled') statusEl.classList.add('badge-error');
      else statusEl.classList.add('badge-warning');
    };

    const openModal = () => {
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    };

    const closeModal = () => {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    };

    closeBtns.forEach((btn) => btn.addEventListener('click', closeModal));

    cards.forEach((card) => {
      card.addEventListener('click', () => {
        const data = card.dataset.booking ? JSON.parse(card.dataset.booking) : null;
        if (!data || !form) return;

        document.getElementById('modal-service').textContent = data.service || '-';
        document.getElementById('modal-client').textContent = data.client || '-';
        document.getElementById('modal-staff').textContent = data.staff || 'Any Available';
        document.getElementById('modal-date').textContent = data.date || '-';
        document.getElementById('modal-time').textContent = data.time || '-';
        document.getElementById('modal-duration').textContent = data.duration || '-';
        document.getElementById('modal-price').textContent = data.price || '-';
        document.getElementById('modal-notes').textContent = data.notes || '-';

        const statusEl = document.getElementById('modal-status');
        statusEl.textContent = data.status || 'pending';
        setBadgeClass(statusEl, data.status);

        form.action = `<?php echo e(url('admin/bookings')); ?>/${data.id}`;
        if (form.querySelector('select[name="client_id"]')) {
          form.querySelector('select[name="client_id"]').value = data.client_id || '';
        }
        if (form.querySelector('select[name="service_id"]')) {
          form.querySelector('select[name="service_id"]').value = data.service_id || '';
        }
        form.querySelector('input[name="date"]').value = data.date || '';
        form.querySelector('input[name="time"]').value = data.time || '';
        if (form.querySelector('select[name="staff_id"]')) {
          form.querySelector('select[name="staff_id"]').value = data.staff_id || '';
        }
        form.querySelector('select[name="status"]').value = data.status || 'pending';
        form.querySelector('textarea[name="notes"]').value = data.notes || '';

        openModal();
      });
    });
  })();
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views\admin\bookings.blade.php ENDPATH**/ ?>