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
            <!-- Breadcrumb -->
            <div class="mb-6">
                <x-breadcrumb :items="[
                    ['name' => 'Resepsionis Dashboard']
                ]" />
            </div>

            <!-- Welcome & Quick Appointment Card -->
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="p-6 text-white">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="mb-4 md:mb-0">
                            <h3 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->nama }}! 👋</h3>
                            <p class="text-teal-50">Kelola appointment dan data pasien dengan mudah</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('resepsionis.temu-dokter.create') }}" class="inline-flex items-center px-6 py-3 bg-white text-teal-600 font-semibold rounded-lg shadow-md hover:bg-teal-50 transition-all transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Buat Appointment
                            </a>
                            <a href="{{ route('resepsionis.temu-dokter.index') }}" class="inline-flex items-center px-6 py-3 bg-teal-700 text-white font-semibold rounded-lg shadow-md hover:bg-teal-800 transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Lihat Semua
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Appointment Statistics</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Today's Appointments -->
                    <a href="{{ route('resepsionis.temu-dokter.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow cursor-pointer">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Hari Ini</p>
                                    <h4 class="text-3xl font-bold text-teal-600">{{ $stats['today_appointments'] }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">Appointments</p>
                                </div>
                                <div class="p-3 bg-teal-50 rounded-lg">
                                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Pending Appointments -->
                    <a href="{{ route('resepsionis.temu-dokter.index') }}?status=pending" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow cursor-pointer">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Menunggu</p>
                                    <h4 class="text-3xl font-bold text-yellow-600">{{ $stats['pending_appointments'] }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">Appointments</p>
                                </div>
                                <div class="p-3 bg-yellow-50 rounded-lg">
                                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Total Pemilik -->
                    <a href="{{ route('resepsionis.pemilik.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow cursor-pointer">
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
                    </a>

                    <!-- Total Pets -->
                    <a href="{{ route('resepsionis.pet.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow cursor-pointer">
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
                    </a>
                </div>
            </div>

            <!-- Recent Data -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Today's Appointments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h5 class="text-lg font-semibold text-gray-800">Today's Appointments</h5>
                            <a href="{{ route('resepsionis.temu-dokter.index') }}" class="text-sm text-teal-600 hover:text-teal-800">Lihat Semua →</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($today_appointments as $appointment)
                                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                    <div class="flex items-center space-x-3">
                                        <span class="flex items-center justify-center w-10 h-10 rounded-full bg-teal-100 text-teal-600 font-bold text-sm">
                                            {{ $appointment->no_urut }}
                                        </span>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $appointment->pet->nama_hewan }}</p>
                                            <p class="text-xs text-gray-500">{{ $appointment->pet->pemilik->user->nama ?? '-' }} • {{ $appointment->waktu_daftar->format('H:i') }}</p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full
                                        @if($appointment->status_color == 'yellow') bg-yellow-100 text-yellow-800
                                        @elseif($appointment->status_color == 'blue') bg-blue-100 text-blue-800
                                        @elseif($appointment->status_color == 'green') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $appointment->status_label }}
                                    </span>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-sm">Belum ada appointment hari ini</p>
                                </div>
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

            <!-- Recent Pemilik -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h5 class="text-lg font-semibold text-gray-800 mb-4">Recent Pemilik</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($recent_pemilik as $pemilik)
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 truncate">{{ $pemilik->user->nama ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500 truncate">{{ $pemilik->no_wa }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm col-span-2">No recent pemilik</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h5 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <!-- Main Action: Buat Appointment -->
                        <a href="{{ route('resepsionis.temu-dokter.create') }}" class="flex items-center justify-center p-6 bg-gradient-to-r from-teal-500 to-teal-600 text-white rounded-lg hover:from-teal-600 hover:to-teal-700 transition-all transform hover:scale-105 shadow-lg">
                            <div class="text-center">
                                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <span class="text-lg font-bold">Buat Appointment Baru</span>
                                <p class="text-teal-100 text-sm mt-1">Daftar pasien baru</p>
                            </div>
                        </a>

                        <!-- Secondary Action: Kelola Appointment -->
                        <a href="{{ route('resepsionis.temu-dokter.index') }}" class="flex items-center justify-center p-6 border-2 border-teal-300 bg-teal-50 text-teal-700 rounded-lg hover:bg-teal-100 transition-all">
                            <div class="text-center">
                                <svg class="w-12 h-12 mx-auto mb-3 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                                <span class="text-lg font-bold">Kelola Appointments</span>
                                <p class="text-teal-600 text-sm mt-1">Lihat & edit appointments</p>
                            </div>
                        </a>
                    </div>

                    <!-- Other Actions -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
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
                        <a href="{{ route('resepsionis.pemilik.index') }}" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Owners List</span>
                            </div>
                        </a>
                        <a href="{{ route('resepsionis.pet.index') }}" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Pets List</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
