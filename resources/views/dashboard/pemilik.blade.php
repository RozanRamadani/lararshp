<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard Pemilik
            </h2>
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                Pemilik
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <x-breadcrumb :items="[
                    ['name' => 'Pemilik Dashboard']
                ]" />
            </div>

            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">Selamat Datang, {{ Auth::user()->nama }}!</h3>
                    <p class="text-gray-600">Kelola informasi hewan peliharaan Anda dan lihat riwayat medis.</p>
                </div>
            </div>

            <!-- Statistics -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">My Pets Overview</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Total My Pets -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">My Pets</p>
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $stats['my_pets'] }}</h4>
                                </div>
                                <div class="p-3 bg-indigo-50 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Appointments -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Upcoming Appointments</p>
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $stats['upcoming_appointments'] }}</h4>
                                </div>
                                <div class="p-3 bg-indigo-50 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Medical Visits -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Total Visits</p>
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $stats['total_visits'] }}</h4>
                                </div>
                                <div class="p-3 bg-indigo-50 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Pets List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h5 class="text-lg font-semibold text-gray-800">My Pets</h5>
                        <a href="{{ route('pemilik.my-pets') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            View All →
                        </a>
                    </div>
                    @if($my_pets->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($my_pets->take(3) as $pet)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <h6 class="font-semibold text-gray-900">{{ $pet->nama_hewan }}</h6>
                                            <p class="text-sm text-gray-500">{{ $pet->jenis_hewan->nama_jenis ?? '-' }}</p>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800">
                                            Active
                                        </span>
                                    </div>
                                    <div class="space-y-1 text-sm text-gray-600">
                                        <p><span class="font-medium">Breed:</span> {{ $pet->ras_hewan->nama_ras ?? '-' }}</p>
                                        <p><span class="font-medium">Color:</span> {{ $pet->warna ?? '-' }}</p>
                                        <p><span class="font-medium">Age:</span> {{ $pet->umur ?? '-' }} {{ $pet->satuan_umur ?? '' }}</p>
                                    </div>
                                    <div class="mt-4 pt-3 border-t border-gray-100">
                                        <a href="{{ route('pemilik.my-pets.show', $pet->idpet) }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View Details →</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">You don't have any registered pets yet.</p>
                    @endif
                </div>
            </div>

            <!-- Medical History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h5 class="text-lg font-semibold text-gray-800 mb-4">Recent Medical History</h5>
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p>Medical history feature coming soon...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
