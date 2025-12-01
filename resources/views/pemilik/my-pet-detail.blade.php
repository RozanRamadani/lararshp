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
            <!-- Breadcrumb -->
            <div class="mb-6">
                <x-breadcrumb :items="[
                    ['name' => 'My Pets', 'url' => route('pemilik.my-pets')],
                    ['name' => $pet->nama_hewan ?? $pet->nama]
                ]" />
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

                            @if($pet->rekamMedis && $pet->rekamMedis->count() > 0)
                                <div class="space-y-4">
                                    @foreach($pet->rekamMedis as $rekam)
                                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                            <div class="flex justify-between items-start mb-3">
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">
                                                        {{ $rekam->created_at ? \Carbon\Carbon::parse($rekam->created_at)->format('d F Y') : '-' }}
                                                    </h4>
                                                    <p class="text-sm text-gray-600">
                                                        Dokter: {{ optional($rekam->dokter)->nama ?? optional(optional($rekam->dokter)->user)->nama ?? 'Unknown' }}
                                                    </p>
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    RM{{ str_pad($rekam->idrekam_medis, 4, '0', STR_PAD_LEFT) }}
                                                </span>
                                            </div>

                                            @if($rekam->anamnesa)
                                                <div class="mb-2">
                                                    <span class="text-sm font-medium text-gray-700">Anamnesa:</span>
                                                    <p class="text-sm text-gray-600">{{ $rekam->anamnesa }}</p>
                                                </div>
                                            @endif

                                            @if($rekam->diagnosa)
                                                <div class="mb-2">
                                                    <span class="text-sm font-medium text-gray-700">Diagnosa:</span>
                                                    <p class="text-sm text-gray-600">{{ $rekam->diagnosa }}</p>
                                                </div>
                                            @endif

                                            @if($rekam->detailRekamMedis && $rekam->detailRekamMedis->count() > 0)
                                                <div class="mt-3 pt-3 border-t border-gray-200">
                                                    <span class="text-sm font-medium text-gray-700">Tindakan:</span>
                                                    <ul class="mt-1 space-y-1">
                                                        @foreach($rekam->detailRekamMedis as $detail)
                                                            <li class="text-sm text-gray-600 flex items-start">
                                                                <span class="mr-2">•</span>
                                                                <span>{{ $detail->keterangan ?? 'Tindakan medis' }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach

                                    <div class="text-center pt-4">
                                        <a href="{{ route('pemilik.my-pets.rekam-medis', $pet->idpet) }}" class="text-teal-600 hover:text-teal-900 text-sm font-medium">
                                            Lihat Semua Riwayat Medis →
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-gray-600 mb-2">Belum ada riwayat medis</p>
                                    <p class="text-sm text-gray-500">Riwayat medis akan muncul setelah {{ $pet->nama_hewan ?? $pet->nama }} melakukan kunjungan</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Upcoming Appointments -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Upcoming Appointments</h3>

                            @if($pet->temuDokter && $pet->temuDokter->count() > 0)
                                <div class="space-y-3">
                                    @foreach($pet->temuDokter as $appointment)
                                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">
                                                        {{ $appointment->waktu_daftar ? \Carbon\Carbon::parse($appointment->waktu_daftar)->format('d F Y') : '-' }}
                                                    </h4>
                                                    <p class="text-sm text-gray-600">
                                                        Waktu: {{ $appointment->waktu_daftar ? \Carbon\Carbon::parse($appointment->waktu_daftar)->format('H:i') : '-' }}
                                                    </p>
                                                    <p class="text-sm text-gray-600">
                                                        Dokter: {{ $appointment->dokter->user->nama ?? 'Belum ditentukan' }}
                                                    </p>
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $appointment->status == 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($appointment->status ?? 'Pending') }}
                                                </span>
                                            </div>
                                            @if($appointment->keluhan)
                                                <div class="mt-3 pt-3 border-t border-gray-200">
                                                    <span class="text-sm font-medium text-gray-700">Keluhan:</span>
                                                    <p class="text-sm text-gray-600">{{ $appointment->keluhan }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-gray-600 mb-2">Tidak ada janji temu mendatang</p>
                                    <p class="text-sm text-gray-500">Hubungi resepsionis untuk membuat janji temu</p>
                                </div>
                            @endif
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
