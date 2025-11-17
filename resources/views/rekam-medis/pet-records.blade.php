<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Medical History - {{ $pet->nama }}
            </h2>
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                Medical Records
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                @if(auth()->user()->hasRole('Pemilik'))
                    <a href="{{ route('pemilik.my-pets.show', $pet->idpet) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                @else
                    <a href="{{ route('perawat.pasien.show', $pet->idpet) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                @endif
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Pet Details
                </a>
            </div>

            <!-- Pet Information Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $pet->nama }}</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500">Species</p>
                                    <p class="font-medium text-gray-900">{{ $pet->jenis_hewan->nama_jenis ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Breed</p>
                                    <p class="font-medium text-gray-900">{{ $pet->ras_hewan->nama_ras ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Gender</p>
                                    <p class="font-medium text-gray-900">{{ $pet->jenis_kelamin ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Owner</p>
                                    <p class="font-medium text-gray-900">{{ $pet->pemilik->nama ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        @if(auth()->user()->hasAnyRole(['Administrator', 'Perawat']))
                            <a href="{{ route('perawat.rekam-medis.create', ['idpet' => $pet->idpet]) }}" class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add Record
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Medical Records Timeline -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Medical History Timeline</h3>

                    @if($rekamMedis->count() > 0)
                        <div class="space-y-6">
                            @foreach($rekamMedis as $record)
                                <div class="border-l-4 border-indigo-500 pl-4 py-2">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <h4 class="text-base font-semibold text-gray-900">
                                                {{ $record->tanggal_kunjungan->format('d F Y') }}
                                            </h4>
                                            <p class="text-sm text-gray-600">
                                                Doctor: {{ $record->dokter->name ?? 'Not assigned' }} |
                                                Nurse: {{ $record->perawat->name ?? 'Not assigned' }}
                                            </p>
                                        </div>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($record->status_color == 'yellow') bg-yellow-100 text-yellow-800
                                            @elseif($record->status_color == 'blue') bg-blue-100 text-blue-800
                                            @elseif($record->status_color == 'green') bg-green-100 text-green-800
                                            @elseif($record->status_color == 'red') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ $record->status_label }}
                                        </span>
                                    </div>

                                    <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @if($record->suhu || $record->berat_badan)
                                            <div class="bg-gray-50 p-3 rounded-md">
                                                <p class="text-xs font-medium text-gray-500 mb-2">Vital Signs</p>
                                                <div class="flex space-x-4 text-sm">
                                                    @if($record->suhu)
                                                        <div>
                                                            <span class="text-gray-600">Temp:</span>
                                                            <span class="font-medium text-gray-900">{{ $record->suhu }}°C</span>
                                                        </div>
                                                    @endif
                                                    @if($record->berat_badan)
                                                        <div>
                                                            <span class="text-gray-600">Weight:</span>
                                                            <span class="font-medium text-gray-900">{{ $record->berat_badan }} kg</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        @if($record->diagnosis)
                                            <div class="bg-gray-50 p-3 rounded-md">
                                                <p class="text-xs font-medium text-gray-500 mb-1">Diagnosis</p>
                                                <p class="text-sm text-gray-900">{{ Str::limit($record->diagnosis, 100) }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    @if($record->anamnesa)
                                        <div class="mt-3">
                                            <p class="text-xs font-medium text-gray-500 mb-1">Chief Complaint</p>
                                            <p class="text-sm text-gray-700">{{ Str::limit($record->anamnesa, 200) }}</p>
                                        </div>
                                    @endif

                                    @if($record->resep_obat)
                                        <div class="mt-3">
                                            <p class="text-xs font-medium text-gray-500 mb-1">Prescription</p>
                                            <p class="text-sm text-gray-700">{{ Str::limit($record->resep_obat, 150) }}</p>
                                        </div>
                                    @endif

                                    @if($record->tanggal_kontrol)
                                        <div class="mt-3">
                                            <p class="text-xs font-medium text-gray-500">Follow-up Date</p>
                                            <p class="text-sm font-medium text-indigo-600">{{ $record->tanggal_kontrol->format('d F Y') }}</p>
                                        </div>
                                    @endif

                                    <div class="mt-4 pt-3 border-t border-gray-200">
                                        @if(auth()->user()->hasRole('Pemilik'))
                                            <a href="{{ route('pemilik.my-pets.rekam-medis', $pet->idpet) }}#record-{{ $record->idrekam_medis }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                                View Full Details →
                                            </a>
                                        @elseif(auth()->user()->hasRole('Dokter'))
                                            <a href="{{ route('dokter.rekam-medis.show', $record) }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                                View Full Details →
                                            </a>
                                        @else
                                            <div class="flex space-x-3">
                                                <a href="{{ route('perawat.rekam-medis.show', ['rekam_medi' => $record->idrekam_medis]) }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                                    View Details
                                                </a>
                                                <a href="{{ route('perawat.rekam-medis.edit', ['rekam_medi' => $record->idrekam_medis]) }}" class="text-sm text-yellow-600 hover:text-yellow-800 font-medium">
                                                    Edit
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $rekamMedis->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Medical Records Yet</h3>
                            <p class="text-gray-600 mb-6">{{ $pet->nama }} hasn't had any medical visits recorded.</p>
                            @if(auth()->user()->hasAnyRole(['Administrator', 'Perawat']))
                                <a href="{{ route('perawat.rekam-medis.create', ['idpet' => $pet->idpet]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add First Medical Record
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
