<nav class="glass-card sticky top-0 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 gap-6">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full overflow-hidden bg-white flex items-center justify-center border border-gray-200">
                    @if(file_exists(public_path('images/bogos-land-logo.png')))
                        <img src="{{ asset('images/bogos-land-logo.png') }}" alt="Bogos Land" class="w-10 h-10 object-contain">
                    @else
                        <span class="text-primary font-bold text-xl">B</span>
                    @endif
                </div>
                <span class="font-serif text-2xl font-bold text-primary">Bogos Land</span>
            </a>

            @php
                $currentRoute = request()->route() ? request()->route()->getName() : '';
                $user = auth()->user();
                $isAdmin = $user && $user->is_admin;
                $isAdminRoute = str_starts_with($currentRoute, 'admin.');
                $currentLocale = app()->getLocale();
                $cartItemsCount = collect(session('cart', []))->sum('quantity');
            @endphp

            <div class="hidden md:flex items-center space-x-6 flex-1 justify-center">
                @if($user && $user->role === 'partner')
                    <a href="{{ route('partner.dashboard') }}" class="text-sm font-medium {{ str_starts_with($currentRoute, 'partner.') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }}">{{ __('app.nav.partner.dashboard') }}</a>
                    <a href="{{ route('partner.bookings.create') }}" class="text-sm font-medium {{ str_starts_with($currentRoute, 'partner.bookings') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }}">{{ __('app.nav.partner.new_booking') }}</a>
                @else
                    <a href="{{ route('home') }}" class="text-sm font-medium {{ $currentRoute === 'home' ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }}">{{ __('app.nav.home') }}</a>
                    <a href="{{ route('services') }}" class="text-sm font-medium {{ $currentRoute === 'services' ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }}">{{ __('app.nav.services') }}</a>
                    <a href="{{ route('packs') }}" class="text-sm font-medium {{ $currentRoute === 'packs' ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }}">📅 Réserver</a>
                    <a href="{{ route('subscriptions') }}" class="text-sm font-medium {{ $currentRoute === 'subscriptions' ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }}">{{ __('app.nav.memberships') }}</a>
                    <a href="{{ route('partner.info') }}" class="text-sm font-medium {{ $currentRoute === 'partner.info' ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }}">Partenaire</a>
                    <a href="{{ route('shop') }}" class="text-sm font-medium {{ $currentRoute === 'shop' ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }}">
                        {{ __('app.nav.shop') }}
                        @if($cartItemsCount > 0)
                            <span class="ml-1 inline-flex items-center justify-center bg-accent text-white text-xs rounded-full w-5 h-5 align-middle">{{ $cartItemsCount }}</span>
                        @endif
                    </a>
                @endif
            </div>

            <div class="hidden md:flex items-center space-x-3">
                <details class="relative">
                    <summary class="btn-secondary text-xs px-2.5 py-2 cursor-pointer list-none">
                        {{ strtoupper($currentLocale) }}
                    </summary>
                    <div class="absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden z-50">
                        <a href="{{ route('locale.switch', 'fr') }}" class="block px-4 py-2 text-sm {{ $currentLocale === 'fr' ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">FR</a>
                        <a href="{{ route('locale.switch', 'en') }}" class="block px-4 py-2 text-sm {{ $currentLocale === 'en' ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">EN</a>
                        <a href="{{ route('locale.switch', 'ar') }}" class="block px-4 py-2 text-sm {{ $currentLocale === 'ar' ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">AR</a>
                    </div>
                </details>
                @auth
                    @php
                        $currentUser = auth()->user();
                        $dashboardRoute = $currentUser?->is_admin
                            ? route('admin.dashboard')
                            : ($currentUser?->role === 'partner' ? route('partner.dashboard') : route('client.dashboard'));
                    @endphp
                    @if($currentUser)
                        <div class="flex items-center space-x-2">
                            <div class="hidden lg:flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-semibold text-gray-600">
                                    {{ strtoupper(substr($currentUser->name ?? 'U', 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ $currentUser->name }}</span>
                            </div>
                            <a href="{{ $dashboardRoute }}" class="btn-secondary px-3 py-2 text-sm">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn-primary px-3 py-2 text-sm">{{ __('app.auth.logout') }}</button>
                            </form>
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-primary">{{ __('app.auth.sign_in') }}</a>
                @endauth
            </div>

            <button
                type="button"
                id="mobile-menu-button"
                class="md:hidden p-2 text-gray-700 hover:text-primary"
                aria-controls="mobile-menu"
                aria-expanded="false"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="md:hidden hidden border-t border-gray-200 bg-white">
            <div class="px-4 py-4 space-y-3">
                @if($user && $user->role === 'partner')
                    <a href="{{ route('partner.dashboard') }}" class="block px-4 py-2 rounded-lg {{ str_starts_with($currentRoute, 'partner.') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">{{ __('app.nav.partner.dashboard') }}</a>
                    <a href="{{ route('partner.bookings.create') }}" class="block px-4 py-2 rounded-lg {{ str_starts_with($currentRoute, 'partner.bookings') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">{{ __('app.nav.partner.new_booking') }}</a>
                @else
                    <a href="{{ route('home') }}" class="block px-4 py-2 rounded-lg {{ $currentRoute === 'home' ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">{{ __('app.nav.home') }}</a>
                    <a href="{{ route('services') }}" class="block px-4 py-2 rounded-lg {{ $currentRoute === 'services' ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">{{ __('app.nav.services') }}</a>
                    <a href="{{ route('packs') }}" class="block px-4 py-2 rounded-lg {{ $currentRoute === 'packs' ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">📅 Réserver</a>
                    <a href="{{ route('subscriptions') }}" class="block px-4 py-2 rounded-lg {{ $currentRoute === 'subscriptions' ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">{{ __('app.nav.memberships') }}</a>
                    <a href="{{ route('partner.info') }}" class="block px-4 py-2 rounded-lg {{ $currentRoute === 'partner.info' ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">Partenaire</a>
                    <a href="{{ route('shop') }}" class="block px-4 py-2 rounded-lg {{ $currentRoute === 'shop' ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        {{ __('app.nav.shop') }}
                        @if($cartItemsCount > 0)
                            <span class="ml-1 inline-flex items-center justify-center bg-accent text-white text-xs rounded-full w-5 h-5 align-middle">{{ $cartItemsCount }}</span>
                        @endif
                    </a>
                @endif

                <div class="pt-2 border-t border-gray-200">
                    <div class="text-xs text-gray-500 mb-3">{{ __('app.language') }}</div>
                    <div class="flex items-center space-x-2 mb-3">
                        <a href="{{ route('locale.switch', 'fr') }}" class="px-3 py-1 rounded-full text-xs border {{ $currentLocale === 'fr' ? 'bg-primary text-white border-primary' : 'text-gray-700 border-gray-200' }}">FR</a>
                        <a href="{{ route('locale.switch', 'en') }}" class="px-3 py-1 rounded-full text-xs border {{ $currentLocale === 'en' ? 'bg-primary text-white border-primary' : 'text-gray-700 border-gray-200' }}">EN</a>
                        <a href="{{ route('locale.switch', 'ar') }}" class="px-3 py-1 rounded-full text-xs border {{ $currentLocale === 'ar' ? 'bg-primary text-white border-primary' : 'text-gray-700 border-gray-200' }}">AR</a>
                    </div>
                    @auth
                        @php
                            $dashboardRoute = $user?->is_admin
                                ? route('admin.dashboard')
                                : ($user?->role === 'partner' ? route('partner.dashboard') : route('client.dashboard'));
                        @endphp
                        <div class="flex flex-col gap-2">
                            <span class="text-sm font-medium">{{ $user->name }}</span>
                            <a href="{{ $dashboardRoute }}" class="btn-secondary text-center">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn-primary w-full">{{ __('app.auth.logout') }}</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary block text-center">{{ __('app.auth.sign_in') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
  (function () {
    const button = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');
    if (!button || !menu) return;
    button.addEventListener('click', function () {
      const isHidden = menu.classList.toggle('hidden');
      button.setAttribute('aria-expanded', (!isHidden).toString());
    });
  })();
</script>

