<footer class="bg-gray-900 text-white mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="font-serif text-xl font-bold mb-4">Bogos Land</h3>
                <p class="text-gray-400 text-sm">{{ __('pages.footer.tagline') }}</p>
            </div>
            <div>
                <h4 class="font-semibold mb-4">{{ __('pages.footer.services') }}</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-white">{{ __('pages.footer.items.hammam') }}</a></li>
                    <li><a href="#" class="hover:text-white">{{ __('pages.footer.items.massage') }}</a></li>
                    <li><a href="#" class="hover:text-white">{{ __('pages.footer.items.hair') }}</a></li>
                    <li><a href="#" class="hover:text-white">{{ __('pages.footer.items.nails') }}</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">{{ __('pages.footer.company') }}</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-white">{{ __('pages.footer.links.about') }}</a></li>
                    <li><a href="#" class="hover:text-white">{{ __('pages.footer.links.contact') }}</a></li>
                    <li><a href="#" class="hover:text-white">{{ __('pages.footer.links.privacy') }}</a></li>
                    <li><a href="#" class="hover:text-white">{{ __('pages.footer.links.terms') }}</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">{{ __('pages.footer.contact') }}</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>{{ __('pages.footer.email') }}: info@bogosland.com</li>
                    <li>{{ __('pages.footer.phone') }}: +1 234 567 8900</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
            <p>&copy; {{ date('Y') }} Bogos Land Wellness. {{ __('pages.footer.rights') }}</p>
        </div>
    </div>
</footer>

