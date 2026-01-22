@extends('layouts.app')

@section('title', __('pages.subscriptions.title'))

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="font-serif text-5xl font-bold mb-4">{{ __('pages.subscriptions.hero_title') }}</h1>
                <p class="text-xl max-w-2xl mx-auto">{{ __('pages.subscriptions.hero_subtitle') }}</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if(session('success'))
            <div class="glass-card p-4 mb-6 text-green-700 bg-green-50">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($plans as $plan)
                <div class="glass-card p-8 relative {{ $plan->popular ? 'ring-4 ring-primary scale-105' : '' }}">
                    @if($plan->popular)
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                            <div class="bg-primary text-white px-4 py-1 rounded-full text-sm font-bold flex items-center space-x-1">
                                <span>⭐</span>
                                <span>{{ __('pages.subscriptions.most_popular') }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="text-center mb-6">
                        <h3 class="font-serif text-2xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>
                        <div class="flex items-baseline justify-center space-x-2">
                            <span class="text-5xl font-bold text-primary">MAD {{ $plan->price }}</span>
                            <span class="text-gray-600">/{{ $plan->duration }}</span>
                        </div>
                    </div>

                    @php
                        $benefits = is_array($plan->benefits) ? $plan->benefits : json_decode($plan->benefits ?? '[]', true);
                    @endphp

                    <ul class="space-y-4 mb-8">
                        @foreach($benefits as $benefit)
                            <li class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-5 h-5 rounded-full bg-green-100 flex items-center justify-center mt-0.5">✔</div>
                                <span class="text-gray-700">{{ $benefit }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <form method="POST" action="{{ route('subscriptions.subscribe', $plan) }}">
                        @csrf
                        <button type="submit" class="w-full py-3 rounded-lg font-medium transition-all duration-300 {{ $plan->popular ? 'btn-primary' : 'bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white' }}">
                            {{ __('pages.subscriptions.choose_plan', ['plan' => $plan->name]) }}
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="mt-16 glass-card p-8">
            <h2 class="font-serif text-3xl font-bold text-gray-900 mb-6 text-center">{{ __('pages.subscriptions.why_title') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-2xl">💰</span>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-2">{{ __('pages.subscriptions.benefits.save_title') }}</h3>
                    <p class="text-gray-600">{{ __('pages.subscriptions.benefits.save_desc') }}</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-2xl">⭐</span>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-2">{{ __('pages.subscriptions.benefits.priority_title') }}</h3>
                    <p class="text-gray-600">{{ __('pages.subscriptions.benefits.priority_desc') }}</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-2xl">🎁</span>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-2">{{ __('pages.subscriptions.benefits.exclusive_title') }}</h3>
                    <p class="text-gray-600">{{ __('pages.subscriptions.benefits.exclusive_desc') }}</p>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-gray-600 mb-4">{{ __('pages.subscriptions.cta_question') }}</p>
            <button class="btn-outline">{{ __('pages.subscriptions.cta_contact') }}</button>
        </div>
    </section>
</div>
@endsection

