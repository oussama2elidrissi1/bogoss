<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bogos Land Wellness')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
    @include('components.navbar')

    @php
        $isAdminRoute = request()->routeIs('admin.*');
    @endphp

    @if($isAdminRoute)
        <div class="flex min-h-screen">
            @include('components.admin-sidebar')
            <main class="flex-1">
                @yield('content')
            </main>
        </div>
    @else
        <main>
            @yield('content')
        </main>
    @endif

    @include('components.footer')

    @stack('scripts')
</body>
</html>

