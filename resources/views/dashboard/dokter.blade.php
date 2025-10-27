<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard Dokter
            </h2>
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                Dokter
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">Selamat Datang, dr. {{ Auth::user()->nama }}!</h3>
                    <p class="text-gray-600">Anda masuk sebagai Dokter. Kelola rekam medis dan tindakan medis pasien.</p>
                </div>
            </div>

            <!-- Statistics -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Medical Overview</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Total Patients -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Total Patients</p>
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $stats['total_patients'] }}</h4>
                                </div>
                                <div class="p-3 bg-indigo-50 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Appointments -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Today's Appointments</p>
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $stats['today_appointments'] }}</h4>
                                </div>
                                <div class="p-3 bg-indigo-50 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Diagnoses -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Completed Diagnoses</p>
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $stats['completed_diagnoses'] }}</h4>
                                </div>
                                <div class="p-3 bg-indigo-50 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Reviews -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Pending Reviews</p>
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $stats['pending_reviews'] }}</h4>
                                </div>
                                <div class="p-3 bg-indigo-50 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Patients -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h5 class="text-lg font-semibold text-gray-800 mb-4">Recent Patients</h5>
                    <div class="space-y-3">
                        @forelse($recent_patients as $patient)
                            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $patient->nama_hewan }}</p>
                                    <p class="text-sm text-gray-500">{{ $patient->jenis_hewan->nama_jenis ?? '-' }} • Owner: {{ $patient->pemilik->user->nama ?? '-' }}</p>
                                </div>
                                <span class="text-xs text-gray-500">
                                    {{ $patient->created_at ? $patient->created_at->diffForHumans() : '-' }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No recent patients</p>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Medical Records</span>
                            </div>
                        </a>
                        <a href="#" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Appointments</span>
                            </div>
                        </a>
                        <a href="#" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">New Diagnosis</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
