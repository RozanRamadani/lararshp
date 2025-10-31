<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pet Details - {{ $pet->nama_hewan ?? $pet->nama }}
            </h2>
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                Pemilik
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('pemilik.my-pets') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to My Pets
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Pet Information Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Pet Information</h3>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Pet Name</label>
                                    <p class="text-base text-gray-900 font-semibold">{{ $pet->nama_hewan ?? $pet->nama }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Species (Jenis Hewan)</label>
                                    <p class="text-base text-gray-900">{{ $pet->jenis_hewan->nama_jenis ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Breed (Ras Hewan)</label>
                                    <p class="text-base text-gray-900">{{ $pet->ras_hewan->nama_ras ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Gender</label>
                                    <p class="text-base text-gray-900">{{ $pet->jenis_kelamin ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Color/Markings</label>
                                    <p class="text-base text-gray-900">{{ $pet->warna_tanda ?? $pet->warna ?? '-' }}</p>
                                </div>

                                @if($pet->tanggal_lahir)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Birth Date</label>
                                        <p class="text-base text-gray-900">{{ \Carbon\Carbon::parse($pet->tanggal_lahir)->format('d F Y') }}</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Age</label>
                                        <p class="text-base text-gray-900">
                                            {{ \Carbon\Carbon::parse($pet->tanggal_lahir)->diffForHumans(['parts' => 2]) }}
                                        </p>
                                    </div>
                                @endif

                                @if($pet->ciri_khas)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Special Characteristics</label>
                                        <p class="text-base text-gray-900">{{ $pet->ciri_khas }}</p>
                                    </div>
                                @endif

                                @if($pet->created_at)
                                    <div class="pt-4 border-t border-gray-200">
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Registered Date</label>
                                        <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($pet->created_at)->format('d F Y') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medical History & Appointments -->
                <div class="lg:col-span-2">
                    <!-- Medical History -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Medical History</h3>
                            
                            <!-- Placeholder for medical records -->
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-gray-600 mb-2">Medical history will be displayed here</p>
                                <p class="text-sm text-gray-500">All medical records and treatment history for {{ $pet->nama_hewan ?? $pet->nama }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Appointments -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Upcoming Appointments</h3>
                            
                            <!-- Placeholder for appointments -->
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-gray-600 mb-2">No upcoming appointments</p>
                                <p class="text-sm text-gray-500">Contact reception to schedule an appointment</p>
                            </div>
                        </div>
                    </div>

                    <!-- Vaccination History -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Vaccination History</h3>
                            
                            <!-- Placeholder for vaccinations -->
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                                <p class="text-gray-600 mb-2">Vaccination records will be displayed here</p>
                                <p class="text-sm text-gray-500">Complete vaccination history for {{ $pet->nama_hewan ?? $pet->nama }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
