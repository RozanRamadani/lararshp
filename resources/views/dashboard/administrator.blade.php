<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard Administrator
            </h2>
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                Administrator
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">Selamat Datang, {{ Auth::user()->nama }}!</h3>
                    <p class="text-gray-600">Anda masuk sebagai Administrator dengan akses penuh ke seluruh sistem.</p>
                </div>
            </div>

            <!-- System Statistics -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">System Overview</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Total Users -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Total Users</p>
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</h4>
                                </div>
                                <div class="p-3 bg-indigo-50 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Roles -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Total Roles</p>
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $stats['total_roles'] }}</h4>
                                </div>
                                <div class="p-3 bg-indigo-50 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Pemilik -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Total Pemilik</p>
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $stats['total_pemilik'] }}</h4>
                                </div>
                                <div class="p-3 bg-indigo-50 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Pets -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Total Pets</p>
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $stats['total_pets'] }}</h4>
                                </div>
                                <div class="p-3 bg-indigo-50 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Recent Users -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h5 class="text-lg font-semibold text-gray-800 mb-4">Recent Users</h5>
                        <div class="space-y-3">
                            @forelse($recent_users as $user)
                                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $user->nama }}</p>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                    </div>
                                    <span class="text-xs text-gray-500">
                                        {{ $user->created_at ? $user->created_at->diffForHumans() : '-' }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm">No recent users</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Pemilik -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h5 class="text-lg font-semibold text-gray-800 mb-4">Recent Pemilik</h5>
                        <div class="space-y-3">
                            @forelse($recent_pemilik as $pemilik)
                                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $pemilik->user->nama ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-500">{{ $pemilik->no_wa }}</p>
                                    </div>
                                    <span class="text-xs text-gray-500">
                                        {{ $pemilik->created_at ? $pemilik->created_at->diffForHumans() : '-' }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm">No recent pemilik</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h5 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h5>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('admin.user.index') }}" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Manage Users</span>
                            </div>
                        </a>
                        <a href="{{ route('admin.role.index') }}" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Manage Roles</span>
                            </div>
                        </a>
                        <a href="{{ route('admin.data.index') }}" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Data Master</span>
                            </div>
                        </a>
                        <a href="{{ route('resepsionis.pet.index') }}" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Manage Pets</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
