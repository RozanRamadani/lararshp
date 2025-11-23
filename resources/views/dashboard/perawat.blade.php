<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard Perawat
            </h2>
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                Perawat
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <x-breadcrumb :items="[
                    ['name' => 'Perawat Dashboard']
                ]" />
            </div>

            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">Selamat Datang, {{ Auth::user()->nama }}!</h3>
                    <p class="text-gray-600">Anda masuk sebagai Perawat. Kelola perawatan dan monitoring pasien.</p>
                </div>
            </div>

            <!-- Statistics -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Care Overview</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Patients Under Care -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Under Care</p>
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $stats['under_care'] }}</h4>
                                </div>
                                <div class="p-3 bg-indigo-50 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Treatments -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Today's Treatments</p>
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $stats['today_treatments'] }}</h4>
                                </div>
                                <div class="p-3 bg-indigo-50 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Treatments -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Completed</p>
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $stats['completed_treatments'] }}</h4>
                                </div>
                                <div class="p-3 bg-indigo-50 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Treatments -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Pending Treatments</p>
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $stats['pending_treatments'] }}</h4>
                                </div>
                                <div class="p-3 bg-yellow-50 rounded-lg">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Patients Monitoring -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h5 class="text-lg font-semibold text-gray-800 mb-4">Patients Monitoring</h5>
                    <div class="space-y-3">
                        @forelse($monitoring_patients as $patient)
                            <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $patient->nama_hewan }}</p>
                                    <p class="text-sm text-gray-500">{{ $patient->jenis_hewan->nama_jenis ?? '-' }} • Owner: {{ $patient->pemilik->user->nama ?? '-' }}</p>
                                    <p class="text-xs text-gray-400 mt-1">Last checked: Coming soon...</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                        Stable
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No patients under monitoring</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h5 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h5>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <a href="#" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Treatment Log</span>
                            </div>
                        </a>
                        <a href="#" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Patient Records</span>
                            </div>
                        </a>
                        <a href="#" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Schedule</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
