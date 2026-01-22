@extends('layouts.app')

@section('title', __('admin.staff_form.create_title'))

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6">
            <h1 class="font-serif text-3xl font-bold mb-6">{{ __('admin.staff_form.create_title_short') }}</h1>
            <form method="POST" action="{{ route('admin.staff.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.staff_form.name') }}</label>
                    <input type="text" name="name" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.staff_form.roles') }}</label>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <select id="role-select" class="input-field">
                            <option value="">{{ __('admin.staff_form.choose_role') }}</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                        <input type="text" id="role-custom" class="input-field" placeholder="{{ __('admin.staff_form.add_role_placeholder') }}">
                        <button type="button" class="btn-secondary" id="add-role-btn">{{ __('pages.common.add') }}</button>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-3" id="role-list"></div>
                    <input type="hidden" name="roles_input" id="roles-input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.staff_form.specialties') }}</label>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <select id="specialty-select" class="input-field">
                            <option value="">{{ __('admin.staff_form.choose_specialty') }}</option>
                            @foreach($specialties as $specialty)
                                <option value="{{ $specialty }}">{{ $specialty }}</option>
                            @endforeach
                        </select>
                        <input type="text" id="specialty-custom" class="input-field" placeholder="{{ __('admin.staff_form.add_specialty_placeholder') }}">
                        <button type="button" class="btn-secondary" id="add-specialty-btn">{{ __('pages.common.add') }}</button>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-3" id="specialty-list"></div>
                    <input type="hidden" name="specialties_input" id="specialties-input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.auth.email') }}</label>
                    <input type="email" name="email" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.staff_form.phone') }}</label>
                    <input type="text" name="phone" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.staff_form.availability') }}</label>
                    <input type="text" name="availability" class="input-field" required>
                </div>
                <div class="pt-2 border-t border-gray-200">
                    <h2 class="text-sm font-semibold text-gray-800 mb-2">{{ __('admin.staff_form.payout_title') }}</h2>
                    <div class="flex flex-col sm:flex-row gap-3 mb-3">
                        <input type="text" id="service-search" class="input-field" placeholder="{{ __('pages.common.search_service') }}">
                        <select id="service-category" class="input-field sm:w-48">
                            <option value="all">{{ __('pages.booking.all_categories') }}</option>
                            @foreach($serviceCategories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="service-payout-grid">
                        @foreach($services as $service)
                            <div data-name="{{ strtolower($service->name) }}" data-category="{{ $service->category }}">
                                <label class="block text-xs text-gray-600 mb-1">{{ $service->name }}</label>
                                <div class="flex items-center gap-2">
                                    <input
                                        type="number"
                                        name="payout_percentages[{{ $service->id }}]"
                                        class="input-field"
                                        min="0"
                                        max="100"
                                        step="0.01"
                                        placeholder="0"
                                    >
                                    <span class="text-xs text-gray-500">%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn-primary">{{ __('pages.common.save') }}</button>
                    <a href="{{ route('admin.staff.index') }}" class="btn-secondary">{{ __('pages.common.cancel') }}</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
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
@endpush


