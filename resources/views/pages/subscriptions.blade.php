@extends('layouts.app')

@section('title', 'Membership Plans - Bogos Land Wellness')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="font-serif text-5xl font-bold mb-4">Membership Plans</h1>
                <p class="text-xl max-w-2xl mx-auto">Choose the perfect plan for your wellness journey and enjoy exclusive benefits</p>
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
                                <span>Most Popular</span>
                            </div>
                        </div>
                    @endif

                    <div class="text-center mb-6">
                        <h3 class="font-serif text-2xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>
                        <div class="flex items-baseline justify-center space-x-2">
                            <span class="text-5xl font-bold text-primary">${{ $plan->price }}</span>
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
                            Choose {{ $plan->name }}
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="mt-16 glass-card p-8">
            <h2 class="font-serif text-3xl font-bold text-gray-900 mb-6 text-center">Why Choose a Membership?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-2xl">💰</span>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-2">Save Money</h3>
                    <p class="text-gray-600">Enjoy significant discounts on all services and products</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-2xl">⭐</span>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-2">Priority Access</h3>
                    <p class="text-gray-600">Book your preferred time slots before non-members</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 gradient-wellness rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-2xl">🎁</span>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-2">Exclusive Perks</h3>
                    <p class="text-gray-600">Access member-only events and special birthday packages</p>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-gray-600 mb-4">Not sure which plan is right for you?</p>
            <button class="btn-outline">Contact Us for Guidance</button>
        </div>
    </section>
</div>
@endsection
