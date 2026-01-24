

<?php $__env->startSection('title', __('pages.packs.title')); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="font-serif text-5xl font-bold mb-4"><?php echo e(__('pages.packs.hero_title')); ?></h1>
                <p class="text-xl max-w-2xl mx-auto"><?php echo e(__('pages.packs.hero_subtitle')); ?></p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <?php
            $promoData = $promotions->map(function ($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'discount' => (float) $p->discount,
                    'type' => $p->type,
                    'applicable_services' => is_array($p->applicable_services) ? $p->applicable_services : [],
                    'code' => $p->code,
                ];
            })->values();
        ?>

        <?php if(($services ?? collect())->count() > 0): ?>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" id="pack-builder">
                <div class="lg:col-span-2">
                    <div class="glass-card p-6 mb-6">
                        <h2 class="font-serif text-2xl font-bold text-gray-900 mb-2">Composez votre pack</h2>
                        <p class="text-gray-600 text-sm">Sélectionnez plusieurs services. Si une promotion est active, la remise s’applique automatiquement.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button
                                type="button"
                                class="glass-card overflow-hidden text-left hover:ring-2 hover:ring-primary js-pack-service"
                                data-service-id="<?php echo e($service->id); ?>"
                                data-service-name="<?php echo e($service->name); ?>"
                                data-service-category="<?php echo e($service->category); ?>"
                                data-service-price="<?php echo e($service->price); ?>"
                                data-service-duration="<?php echo e($service->duration); ?>"
                            >
                                <div class="relative h-40 overflow-hidden">
                                    <img src="<?php echo e($service->image ?? 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400'); ?>" alt="<?php echo e($service->name); ?>" class="w-full h-full object-cover">
                                    <div class="absolute top-3 right-3">
                                        <span class="badge badge-primary"><?php echo e($service->category); ?></span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <h3 class="font-serif text-lg font-bold text-gray-900 mb-1"><?php echo e($service->name); ?></h3>
                                            <p class="text-gray-600 text-sm line-clamp-2"><?php echo e($service->description); ?></p>
                                        </div>
                                        <span class="badge badge-success js-selected-badge hidden">Selected</span>
                                    </div>
                                    <div class="flex items-center justify-between mt-3 text-sm text-gray-700">
                                        <span>⏱️ <?php echo e($service->duration); ?> <?php echo e(__('pages.common.minutes')); ?></span>
                                        <span class="text-primary font-bold">MAD <?php echo e($service->price); ?></span>
                                    </div>
                                </div>
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="glass-card p-6">
                        <h3 class="font-serif text-xl font-bold text-gray-900 mb-4">Votre pack</h3>
                        <div id="pack-selected-list" class="space-y-2">
                            <p class="text-sm text-gray-600">Aucun service sélectionné.</p>
                        </div>

                        <div class="border-t border-gray-100 mt-5 pt-4 space-y-2 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Total</span>
                                <span class="font-semibold text-gray-900" id="pack-total">MAD 0</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Remise</span>
                                <span class="font-semibold text-green-700" id="pack-discount">MAD 0</span>
                            </div>
                            <div class="flex items-center justify-between text-base">
                                <span class="text-gray-900 font-bold">À payer</span>
                                <span class="text-primary font-bold" id="pack-final">MAD 0</span>
                            </div>
                            <div class="text-xs text-gray-500" id="pack-promo-note"></div>
                        </div>

                        <button type="button" class="btn-primary w-full mt-5 disabled:opacity-50 disabled:cursor-not-allowed" id="pack-book-btn" disabled>
                            Réserver ce pack
                        </button>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-16">
                <div class="text-6xl mb-4">📦</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2"><?php echo e(__('pages.packs.none_title')); ?></h3>
                <p class="text-gray-600"><?php echo e(__('pages.packs.none_subtitle')); ?></p>
            </div>
        <?php endif; ?>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
  (function () {
    const cards = Array.from(document.querySelectorAll('.js-pack-service'));
    const list = document.getElementById('pack-selected-list');
    const totalEl = document.getElementById('pack-total');
    const discountEl = document.getElementById('pack-discount');
    const finalEl = document.getElementById('pack-final');
    const promoNoteEl = document.getElementById('pack-promo-note');
    const bookBtn = document.getElementById('pack-book-btn');

    const promotions = <?php echo json_encode($promoData, 15, 512) ?>;
    const selected = new Map(); // id -> {id,name,category,price,duration,promo}

    const toNumber = (v) => {
      const n = Number(v);
      return Number.isFinite(n) ? n : 0;
    };

    const isPromotionApplicable = (promotion, service) => {
      const list = Array.isArray(promotion?.applicable_services) ? promotion.applicable_services : [];
      return list.some((x) => {
        // allow numbers (service ids) or strings (categories)
        if (typeof x === 'number') return String(x) === String(service.id);
        if (typeof x === 'string') return x === service.category || x === String(service.id);
        return false;
      });
    };

    const calcBestPromotion = (service) => {
      let best = null;
      let bestDiscount = 0;
      promotions.forEach((p) => {
        if (!isPromotionApplicable(p, service)) return;
        let amount = 0;
        if (p.type === 'percentage') amount = (service.price * toNumber(p.discount)) / 100;
        else amount = toNumber(p.discount);
        amount = Math.max(0, Math.min(amount, service.price));
        if (amount > bestDiscount) {
          bestDiscount = amount;
          best = p;
        }
      });
      return best ? { promo: best, discountAmount: bestDiscount } : { promo: null, discountAmount: 0 };
    };

    const render = () => {
      if (!list) return;
      if (selected.size === 0) {
        list.innerHTML = `<p class="text-sm text-gray-600">Aucun service sélectionné.</p>`;
        if (bookBtn) bookBtn.disabled = true;
        if (promoNoteEl) promoNoteEl.textContent = '';
        if (totalEl) totalEl.textContent = 'MAD 0';
        if (discountEl) discountEl.textContent = 'MAD 0';
        if (finalEl) finalEl.textContent = 'MAD 0';
        return;
      }

      let total = 0;
      let discount = 0;
      const promoCodes = new Set();
      list.innerHTML = '';

      selected.forEach((s) => {
        total += s.price;
        discount += s.discountAmount || 0;
        if (s.promo?.code) promoCodes.add(s.promo.code);

        const row = document.createElement('div');
        row.className = 'flex items-start justify-between gap-3 bg-gray-50 rounded-lg px-3 py-2 text-sm';
        row.innerHTML = `
          <div class="min-w-0">
            <div class="font-medium text-gray-900 truncate">${s.name}</div>
            <div class="text-gray-500">${s.category} • ${s.duration} min</div>
          </div>
          <div class="text-right">
            <div class="font-semibold text-gray-900">MAD ${s.price.toFixed(2)}</div>
            ${s.discountAmount ? `<div class="text-xs text-green-700">- MAD ${s.discountAmount.toFixed(2)}</div>` : ''}
            <button type="button" class="text-red-500 hover:text-red-600 text-xs mt-1" data-remove="${s.id}">Remove</button>
          </div>
        `;
        list.appendChild(row);
      });

      const final = Math.max(0, total - discount);
      if (totalEl) totalEl.textContent = `MAD ${total.toFixed(2)}`;
      if (discountEl) discountEl.textContent = `MAD ${discount.toFixed(2)}`;
      if (finalEl) finalEl.textContent = `MAD ${final.toFixed(2)}`;
      if (bookBtn) bookBtn.disabled = false;
      if (promoNoteEl) {
        promoNoteEl.textContent = promoCodes.size ? `Promotions appliquées: ${Array.from(promoCodes).join(', ')}` : '';
      }
    };

    if (list) {
      list.addEventListener('click', (event) => {
        const btn = event.target.closest('[data-remove]');
        if (!btn) return;
        const id = btn.getAttribute('data-remove');
        selected.delete(String(id));
        const card = cards.find((c) => String(c.dataset.serviceId) === String(id));
        if (card) {
          card.classList.remove('ring-2', 'ring-primary');
          const badge = card.querySelector('.js-selected-badge');
          if (badge) badge.classList.add('hidden');
        }
        render();
      });
    }

    cards.forEach((card) => {
      card.addEventListener('click', () => {
        const id = String(card.dataset.serviceId || '');
        if (!id) return;
        if (selected.has(id)) {
          selected.delete(id);
          card.classList.remove('ring-2', 'ring-primary');
          const badge = card.querySelector('.js-selected-badge');
          if (badge) badge.classList.add('hidden');
          render();
          return;
        }

        const service = {
          id,
          name: card.dataset.serviceName || '',
          category: card.dataset.serviceCategory || '',
          price: toNumber(card.dataset.servicePrice),
          duration: toNumber(card.dataset.serviceDuration),
        };
        const { promo, discountAmount } = calcBestPromotion(service);
        selected.set(id, { ...service, promo, discountAmount });
        card.classList.add('ring-2', 'ring-primary');
        const badge = card.querySelector('.js-selected-badge');
        if (badge) badge.classList.remove('hidden');
        render();
      });
    });

    if (bookBtn) {
      bookBtn.addEventListener('click', () => {
        if (selected.size === 0) return;
        const params = new URLSearchParams();
        Array.from(selected.keys()).forEach((id) => params.append('service_ids[]', id));
        window.location.href = `<?php echo e(route('booking')); ?>?${params.toString()}`;
      });
    }

    render();
  })();
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views\pages\packs.blade.php ENDPATH**/ ?>