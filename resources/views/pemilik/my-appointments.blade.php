<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <x-back-button href="{{ route('dashboard') }}" label="Kembali ke Dashboard" />
            <x-breadcrumb :items="[
                ['name' => 'Appointment Saya']
            ]" />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <p class="text-gray-600">Daftar jadwal appointment untuk hewan peliharaan Anda</p>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Error Messages --}}
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-yellow-600">Menunggu</p>
                    <p class="text-2xl font-bold text-yellow-700">{{ $appointments->where('status', \App\Models\TemuDokter::STATUS_MENUNGGU)->count() }}</p>
                </div>
                <div class="bg-yellow-200 p-3 rounded-full">
                    <i class="fas fa-clock text-yellow-700 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-600">Dalam Proses</p>
                    <p class="text-2xl font-bold text-blue-700">{{ $appointments->whereIn('status', [\App\Models\TemuDokter::STATUS_CHECKIN, \App\Models\TemuDokter::STATUS_PEMERIKSAAN, \App\Models\TemuDokter::STATUS_TREATMENT])->count() }}</p>
                </div>
                <div class="bg-blue-200 p-3 rounded-full">
                    <i class="fas fa-user-md text-blue-700 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-600">Selesai</p>
                    <p class="text-2xl font-bold text-green-700">{{ $appointments->where('status', \App\Models\TemuDokter::STATUS_SELESAI)->count() }}</p>
                </div>
                <div class="bg-green-200 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-700 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-red-600">Batal</p>
                    <p class="text-2xl font-bold text-red-700">{{ $appointments->where('status', \App\Models\TemuDokter::STATUS_BATAL)->count() }}</p>
                </div>
                <div class="bg-red-200 p-3 rounded-full">
                    <i class="fas fa-times-circle text-red-700 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointments List -->
    <div class="space-y-4">
        @forelse($appointments as $appointment)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4 flex-1">
                        <!-- Queue Number -->
                        <div class="bg-teal-50 rounded-lg p-4 text-center min-w-[80px]">
                            <p class="text-xs text-teal-600 font-medium mb-1">No. Urut</p>
                            <p class="text-3xl font-bold text-teal-600">{{ $appointment->no_urut }}</p>
                        </div>

                        <!-- Appointment Details -->
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h3 class="text-xl font-semibold text-gray-900">{{ $appointment->pet->nama }}</h3>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($appointment->status_color == 'yellow') bg-yellow-100 text-yellow-800
                                    @elseif($appointment->status_color == 'blue') bg-blue-100 text-blue-800
                                    @elseif($appointment->status_color == 'green') bg-green-100 text-green-800
                                    @elseif($appointment->status_color == 'red') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $appointment->status_label }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <label class="text-gray-500 block mb-1">
                                        <i class="fas fa-calendar mr-1"></i>Tanggal
                                    </label>
                                    <p class="text-gray-900 font-medium">{{ $appointment->waktu_daftar->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <label class="text-gray-500 block mb-1">
                                        <i class="fas fa-clock mr-1"></i>Waktu
                                    </label>
                                    <p class="text-gray-900 font-medium">{{ $appointment->waktu_daftar->format('H:i') }} WIB</p>
                                </div>
                                <div>
                                    <label class="text-gray-500 block mb-1">
                                        <i class="fas fa-paw mr-1"></i>Jenis
                                    </label>
                                    <p class="text-gray-900 font-medium">{{ $appointment->pet->rasHewan->jenisHewan->nama_jenis_hewan ?? '-' }}</p>
                                </div>
                            </div>

                            @if($appointment->roleUser)
                                <div class="mt-3 flex items-center space-x-2 text-sm">
                                    <div class="bg-teal-100 p-2 rounded">
                                        <i class="fas fa-user-md text-teal-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Ditangani oleh:</p>
                                        <p class="text-gray-900 font-medium">{{ $appointment->roleUser->nama }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="ml-4 flex flex-col space-y-2">
                        <a href="{{ route('pemilik.my-pets.show', $appointment->pet->idpet) }}" class="inline-flex items-center px-4 py-2 bg-teal-50 hover:bg-teal-100 text-teal-700 rounded-lg transition-colors text-sm">
                            <i class="fas fa-eye mr-2"></i>Lihat Pet
                        </a>

                        {{-- Cancel Button - only show if not completed or already canceled --}}
                        @if(!in_array($appointment->status, [\App\Models\TemuDokter::STATUS_SELESAI, \App\Models\TemuDokter::STATUS_BATAL]))
                            <form action="{{ route('pemilik.my-appointments.cancel', $appointment->idreservasi_dokter) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan appointment ini?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg transition-colors text-sm w-full">
                                    <i class="fas fa-times-circle mr-2"></i>Batalkan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Additional Info -->
                @if($appointment->status == \App\Models\TemuDokter::STATUS_MENUNGGU)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 rounded">
                            <p class="text-sm text-yellow-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                Mohon datang 15 menit sebelum jadwal. Bawa kartu kesehatan hewan jika ada.
                            </p>
                        </div>
                    </div>
                @elseif(in_array($appointment->status, [\App\Models\TemuDokter::STATUS_CHECKIN, \App\Models\TemuDokter::STATUS_PEMERIKSAAN, \App\Models\TemuDokter::STATUS_TREATMENT]))
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-3 rounded">
                            <p class="text-sm text-blue-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                Hewan peliharaan Anda sedang dalam {{ strtolower($appointment->status_label) }}. Mohon menunggu.
                            </p>
                        </div>
                    </div>
                @elseif($appointment->status == \App\Models\TemuDokter::STATUS_SELESAI)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="bg-green-50 border-l-4 border-green-400 p-3 rounded flex items-center justify-between">
                            <p class="text-sm text-green-800">
                                <i class="fas fa-check-circle mr-2"></i>
                                Pemeriksaan selesai. Terima kasih telah berkunjung.
                            </p>
                            <a href="{{ route('pemilik.my-pets.rekam-medis', $appointment->pet->idpet) }}" class="text-green-700 hover:text-green-900 font-medium text-sm">
                                Lihat Rekam Medis <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @elseif($appointment->status == \App\Models\TemuDokter::STATUS_BATAL)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="bg-red-50 border-l-4 border-red-400 p-3 rounded">
                            <p class="text-sm text-red-800">
                                <i class="fas fa-times-circle mr-2"></i>
                                Appointment ini telah dibatalkan.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-calendar-times text-6xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Appointment</h3>
                <p class="text-gray-600 mb-6">Anda belum memiliki jadwal appointment untuk hewan peliharaan Anda.</p>
                <p class="text-sm text-gray-500">Hubungi resepsionis kami untuk membuat appointment baru.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($appointments->hasPages())
        <div class="mt-6">
            {{ $appointments->links() }}
        </div>
    @endif
        </div>
    </div>
</x-app-layout>
