@extends('layouts.app')

@section('title', __('app.auth.register') . ' - Bogos Land Wellness')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="glass-card p-8">
            <h2 class="font-serif text-3xl font-bold text-center mb-6">{{ __('app.auth.register') }}</h2>
            
            @if($errors->any())
                <div class="bg-danger/10 text-danger p-4 rounded-lg mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.auth.name') }}</label>
                    <input type="text" name="name" required class="input-field" value="{{ old('name') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.auth.email') }}</label>
                    <input type="email" name="email" required class="input-field" value="{{ old('email') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.auth.password') }}</label>
                    <input type="password" name="password" required class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('app.auth.confirm_password') }}</label>
                    <input type="password" name="password_confirmation" required class="input-field">
                </div>
                <button type="submit" class="btn-primary w-full">{{ __('app.auth.register') }}</button>
            </form>

            <p class="mt-4 text-center text-sm text-gray-600">
                {{ __('app.auth.have_account') }} <a href="{{ route('login') }}" class="text-primary hover:underline">{{ __('app.auth.sign_in') }}</a>
            </p>
        </div>
    </div>
</div>
@endsection

