@extends('layouts.app')

@section('title', __('pages.packs.title'))

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="font-serif text-5xl font-bold mb-4">{{ __('pages.packs.hero_title') }}</h1>
                <p class="text-xl max-w-2xl mx-auto">{{ __('pages.packs.hero_subtitle') }}</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($packs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($packs as $pack)
                    <div class="glass-card overflow-hidden">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $pack->image ?? 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400' }}" alt="{{ $pack->name }}" class="w-full h-full object-cover">
                            <div class="absolute top-3 right-3">
                                <span class="badge badge-primary">{{ $pack->category }}</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-serif text-xl font-bold text-gray-900 mb-2">{{ $pack->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $pack->description }}</p>
                            <div class="flex items-center justify-between mb-4 text-sm text-gray-700">
                                <span>⏱️ {{ $pack->duration }} {{ __('pages.common.minutes') }}</span>
                                <span class="text-primary font-bold">MAD {{ $pack->price }}</span>
                            </div>
                            <a href="{{ route('booking', ['service_id' => $pack->id]) }}" class="w-full btn-primary inline-block text-center">{{ __('pages.packs.book_pack') }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="text-6xl mb-4">📦</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('pages.packs.none_title') }}</h3>
                <p class="text-gray-600">{{ __('pages.packs.none_subtitle') }}</p>
            </div>
        @endif
    </section>
</div>
@endsection

