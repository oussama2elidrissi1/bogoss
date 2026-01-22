<?php $__env->startSection('title', 'Add Staff - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6">
            <h1 class="font-serif text-3xl font-bold mb-6">Add Staff</h1>
            <form method="POST" action="<?php echo e(route('admin.staff.store')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                    <input type="text" name="name" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Roles</label>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <select id="role-select" class="input-field">
                            <option value="">Choose role</option>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($role); ?>"><?php echo e($role); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <input type="text" id="role-custom" class="input-field" placeholder="Add new role">
                        <button type="button" class="btn-secondary" id="add-role-btn">Add</button>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-3" id="role-list"></div>
                    <input type="hidden" name="roles_input" id="roles-input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Specialties</label>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <select id="specialty-select" class="input-field">
                            <option value="">Choose specialty</option>
                            <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($specialty); ?>"><?php echo e($specialty); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <input type="text" id="specialty-custom" class="input-field" placeholder="Add new specialty">
                        <button type="button" class="btn-secondary" id="add-specialty-btn">Add</button>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-3" id="specialty-list"></div>
                    <input type="hidden" name="specialties_input" id="specialties-input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                    <input type="text" name="phone" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Availability (comma separated days)</label>
                    <input type="text" name="availability" class="input-field" required>
                </div>
                <div class="pt-2 border-t border-gray-200">
                    <h2 class="text-sm font-semibold text-gray-800 mb-2">Service Payout Percentages</h2>
                    <div class="flex flex-col sm:flex-row gap-3 mb-3">
                        <input type="text" id="service-search" class="input-field" placeholder="Search service...">
                        <select id="service-category" class="input-field sm:w-48">
                            <option value="all">All categories</option>
                            <?php $__currentLoopData = $serviceCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category); ?>"><?php echo e($category); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="service-payout-grid">
                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div data-name="<?php echo e(strtolower($service->name)); ?>" data-category="<?php echo e($service->category); ?>">
                                <label class="block text-xs text-gray-600 mb-1"><?php echo e($service->name); ?></label>
                                <div class="flex items-center gap-2">
                                    <input
                                        type="number"
                                        name="payout_percentages[<?php echo e($service->id); ?>]"
                                        class="input-field"
                                        min="0"
                                        max="100"
                                        step="0.01"
                                        placeholder="0"
                                    >
                                    <span class="text-xs text-gray-500">%</span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn-primary">Save</button>
                    <a href="<?php echo e(route('admin.staff.index')); ?>" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
  (function () {
    const roleSelect = document.getElementById('role-select');
    const roleCustom = document.getElementById('role-custom');
    const roleList = document.getElementById('role-list');
    const rolesInput = document.getElementById('roles-input');
    const addRoleBtn = document.getElementById('add-role-btn');
    const specialtySelect = document.getElementById('specialty-select');
    const specialtyCustom = document.getElementById('specialty-custom');
    const specialtyList = document.getElementById('specialty-list');
    const specialtiesInput = document.getElementById('specialties-input');
    const addSpecialtyBtn = document.getElementById('add-specialty-btn');
    const serviceSearch = document.getElementById('service-search');
    const serviceCategory = document.getElementById('service-category');
    const serviceItems = document.querySelectorAll('#service-payout-grid > div');

    const roles = new Set();
    const specialties = new Set();

    const renderRoles = () => {
      roleList.innerHTML = '';
      roles.forEach((item) => {
        const chip = document.createElement('span');
        chip.className = 'px-3 py-1 rounded-full bg-gray-100 text-sm text-gray-700 flex items-center gap-2';
        chip.innerHTML = `${item} <button type="button" data-remove-role="${item}" class="text-gray-500">✕</button>`;
        roleList.appendChild(chip);
      });
      rolesInput.value = Array.from(roles).join(', ');
    };

    const renderSpecialties = () => {
      specialtyList.innerHTML = '';
      specialties.forEach((item) => {
        const chip = document.createElement('span');
        chip.className = 'px-3 py-1 rounded-full bg-gray-100 text-sm text-gray-700 flex items-center gap-2';
        chip.innerHTML = `${item} <button type="button" data-remove="${item}" class="text-gray-500">✕</button>`;
        specialtyList.appendChild(chip);
      });
      specialtiesInput.value = Array.from(specialties).join(', ');
    };

    if (addRoleBtn) {
      addRoleBtn.addEventListener('click', () => {
        const value = roleCustom.value.trim() || roleSelect.value;
        if (!value) return;
        roles.add(value);
        if (roleCustom.value.trim()) {
          const option = document.createElement('option');
          option.value = value;
          option.textContent = value;
          roleSelect.appendChild(option);
        }
        roleCustom.value = '';
        roleSelect.value = '';
        renderRoles();
      });
    }

    if (roleList) {
      roleList.addEventListener('click', (event) => {
        const btn = event.target.closest('[data-remove-role]');
        if (!btn) return;
        roles.delete(btn.dataset.removeRole);
        renderRoles();
      });
    }

    if (addSpecialtyBtn) {
      addSpecialtyBtn.addEventListener('click', () => {
        const value = specialtyCustom.value.trim() || specialtySelect.value;
        if (!value) return;
        specialties.add(value);
        if (specialtyCustom.value.trim()) {
          const option = document.createElement('option');
          option.value = value;
          option.textContent = value;
          specialtySelect.appendChild(option);
        }
        specialtyCustom.value = '';
        specialtySelect.value = '';
        renderSpecialties();
      });
    }

    if (specialtyList) {
      specialtyList.addEventListener('click', (event) => {
        const btn = event.target.closest('[data-remove]');
        if (!btn) return;
        specialties.delete(btn.dataset.remove);
        renderSpecialties();
      });
    }

    const applyServiceFilter = () => {
      const query = (serviceSearch?.value || '').toLowerCase().trim();
      const category = serviceCategory?.value || 'all';
      serviceItems.forEach((item) => {
        const name = item.dataset.name || '';
        const itemCategory = item.dataset.category || '';
        const matchesQuery = !query || name.includes(query);
        const matchesCategory = category === 'all' || itemCategory === category;
        item.classList.toggle('hidden', !(matchesQuery && matchesCategory));
      });
    };

    if (serviceSearch) serviceSearch.addEventListener('input', applyServiceFilter);
    if (serviceCategory) serviceCategory.addEventListener('change', applyServiceFilter);
  })();
</script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oussa\Desktop\bogoss\resources\views/admin/staff-create.blade.php ENDPATH**/ ?>