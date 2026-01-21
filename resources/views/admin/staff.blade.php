@extends('layouts.app')

@section('title', 'Staff - Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <section class="gradient-wellness py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-4xl font-bold mb-2 text-white">Staff Management</h1>
            <p class="text-xl text-white/90">Manage your team</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card p-6 mb-6">
            <form method="GET" action="{{ route('admin.staff.index') }}" class="flex gap-4">
                <input type="text" name="search" placeholder="Search staff..." value="{{ request('search') }}" class="input-field flex-1">
                <button type="submit" class="btn-primary">Search</button>
                <a href="{{ route('admin.staff.create') }}" class="btn-secondary">Add Staff</a>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse($staff as $member)
            <div class="glass-card p-6">
                <div class="flex items-start space-x-4 mb-4">
                    <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        {{ substr($member->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-serif text-xl font-bold text-gray-900">{{ $member->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $member->role }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.staff.edit', $member) }}" class="btn-primary text-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.staff.destroy', $member) }}" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-secondary bg-danger text-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="text-yellow-500">⭐</span>
                            <span class="text-sm font-bold">{{ $member->rating }}</span>
                            <span class="text-xs text-gray-500">({{ $member->completed_services }} services)</span>
                        </div>
                    </div>
                </div>
                <div class="space-y-2 text-sm text-gray-600">
                    <p>📧 {{ $member->email }}</p>
                    <p>📞 {{ $member->phone }}</p>
                </div>
                <div class="mt-4">
                    <p class="text-xs text-gray-600 mb-2">Specialties:</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($member->specialties as $specialty)
                            <span class="badge badge-primary">{{ $specialty }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-2 text-center py-12">
                <p class="text-gray-500">No staff members found</p>
            </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $staff->links() }}
        </div>
    </section>
</div>
@endsection
