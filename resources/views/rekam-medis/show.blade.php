<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Medical Record Details
            </h2>
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                @if($rekamMedis->status_color == 'yellow') bg-yellow-100 text-yellow-800
                @elseif($rekamMedis->status_color == 'blue') bg-blue-100 text-blue-800
                @elseif($rekamMedis->status_color == 'green') bg-green-100 text-green-800
                @elseif($rekamMedis->status_color == 'red') bg-red-100 text-red-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ $rekamMedis->status_label }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ auth()->user()->hasRole('Dokter') ? route('dokter.rekam-medis.index') : route('perawat.rekam-medis.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Medical Records
                </a>

                @if(!$isReadOnly)
                    <div class="flex space-x-2">
                        <a href="{{ route('perawat.rekam-medis.edit', $rekamMedis->idrekam_medis) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('perawat.rekam-medis.destroy', $rekamMedis->idrekam_medis) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this medical record?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Patient & Staff Info -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Patient Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Patient Information
                            </h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Pet Name</label>
                                    <p class="text-base text-gray-900 font-semibold">{{ $rekamMedis->pet->nama ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Species</label>
                                    <p class="text-base text-gray-900">{{ $rekamMedis->pet->jenis_hewan->nama_jenis ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Breed</label>
                                    <p class="text-base text-gray-900">{{ $rekamMedis->pet->ras_hewan->nama_ras ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Gender</label>
                                    <p class="text-base text-gray-900">{{ $rekamMedis->pet->jenis_kelamin ?? '-' }}</p>
                                </div>
                                <div class="pt-3 border-t border-gray-200">
                                    <label class="block text-sm font-medium text-gray-500">Owner</label>
                                    <p class="text-base text-gray-900">{{ $rekamMedis->pet->pemilik->nama ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Medical Staff -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Medical Staff
                            </h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Doctor</label>
                                    <p class="text-base text-gray-900">{{ $rekamMedis->dokter->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Nurse</label>
                                    <p class="text-base text-gray-900">{{ $rekamMedis->perawat->name ?? '-' }}</p>
                                </div>
                                <div class="pt-3 border-t border-gray-200">
                                    <label class="block text-sm font-medium text-gray-500">Visit Date</label>
                                    <p class="text-base text-gray-900">{{ $rekamMedis->tanggal_kunjungan->format('d F Y') }}</p>
                                </div>
                                @if($rekamMedis->tanggal_kontrol)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Follow-up Date</label>
                                        <p class="text-base text-gray-900">{{ $rekamMedis->tanggal_kontrol->format('d F Y') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Vital Signs -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Vital Signs
                            </h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center p-3 bg-blue-50 rounded-lg">
                                    <p class="text-xs text-gray-500 mb-1">Temperature</p>
                                    <p class="text-2xl font-bold text-blue-600">{{ $rekamMedis->suhu ?? '-' }}</p>
                                    <p class="text-xs text-gray-500">°C</p>
                                </div>
                                <div class="text-center p-3 bg-green-50 rounded-lg">
                                    <p class="text-xs text-gray-500 mb-1">Weight</p>
                                    <p class="text-2xl font-bold text-green-600">{{ $rekamMedis->berat_badan ?? '-' }}</p>
                                    <p class="text-xs text-gray-500">kg</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Medical Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Anamnesa -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Anamnesa / Chief Complaint</h3>
                            <p class="text-gray-700 whitespace-pre-line">{{ $rekamMedis->anamnesa ?? 'Not recorded' }}</p>
                        </div>
                    </div>

                    <!-- Physical Examination -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Physical Examination</h3>
                            <p class="text-gray-700 whitespace-pre-line">{{ $rekamMedis->pemeriksaan_fisik ?? 'Not recorded' }}</p>
                        </div>
                    </div>

                    <!-- Diagnosis -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Diagnosis</h3>
                            <p class="text-gray-700 whitespace-pre-line">{{ $rekamMedis->diagnosis ?? 'Not recorded' }}</p>
                        </div>
                    </div>

                    <!-- Treatment -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Treatment / Procedure</h3>
                            <p class="text-gray-700 whitespace-pre-line">{{ $rekamMedis->tindakan ?? 'Not recorded' }}</p>
                        </div>
                    </div>

                    <!-- Prescription -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Prescription</h3>
                            <p class="text-gray-700 whitespace-pre-line">{{ $rekamMedis->resep_obat ?? 'No prescription' }}</p>
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    @if($rekamMedis->catatan)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Additional Notes</h3>
                                <p class="text-gray-700 whitespace-pre-line">{{ $rekamMedis->catatan }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Timestamps -->
                    <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4">
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>Created: {{ $rekamMedis->created_at?->format('d M Y H:i') ?? '-' }}</span>
                                <span>Updated: {{ $rekamMedis->updated_at?->format('d M Y H:i') ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
