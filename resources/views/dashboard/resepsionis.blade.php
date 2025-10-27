<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard Resepsionis
            </h2>
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                Resepsionis
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">Selamat Datang, {{ Auth::user()->nama }}!</h3>
                    <p class="text-gray-600">Anda masuk sebagai Resepsionis. Kelola data pemilik dan hewan peliharaan.</p>
                </div>
            </div>

            <!-- Statistics -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Overview</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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

                    <!-- Today's Registrations -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Today's Registrations</p>
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $stats['today_registrations'] }}</h4>
                                </div>
                                <div class="p-3 bg-indigo-50 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Data -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
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

                <!-- Recent Pets -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h5 class="text-lg font-semibold text-gray-800 mb-4">Recent Pets</h5>
                        <div class="space-y-3">
                            @forelse($recent_pets as $pet)
                                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $pet->nama_hewan }}</p>
                                        <p class="text-sm text-gray-500">{{ $pet->jenis_hewan->nama_jenis ?? '-' }} • {{ $pet->pemilik->user->nama ?? '-' }}</p>
                                    </div>
                                    <span class="text-xs text-gray-500">
                                        {{ $pet->created_at ? $pet->created_at->diffForHumans() : '-' }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm">No recent pets</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h5 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h5>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <a href="{{ route('resepsionis.pemilik.create') }}" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Add Pemilik</span>
                            </div>
                        </a>
                        <a href="{{ route('resepsionis.pet.create') }}" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Add Pet</span>
                            </div>
                        </a>
                        <a href="{{ route('admin.data.index') }}" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Data Management</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
