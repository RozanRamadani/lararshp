<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <x-back-button href="{{ route('resepsionis.temu-dokter.index') }}" label="Kembali ke Daftar Appointment" />
            <x-breadcrumb :items="[
                ['name' => 'Appointment / Temu Dokter', 'url' => route('resepsionis.temu-dokter.index')],
                ['name' => 'Detail']
            ]" />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Detail Appointment</h3>
                <a href="{{ route('resepsionis.temu-dokter.edit', $temuDokter->idreservasi_dokter) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
            </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Appointment Info Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-900">Informasi Appointment</h2>
                    <span class="px-4 py-2 text-lg font-semibold rounded-full
                        @if($temuDokter->status_color == 'yellow') bg-yellow-100 text-yellow-800
                        @elseif($temuDokter->status_color == 'blue') bg-blue-100 text-blue-800
                        @elseif($temuDokter->status_color == 'green') bg-green-100 text-green-800
                        @elseif($temuDokter->status_color == 'red') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ $temuDokter->status_label }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Urut</label>
                        <p class="text-4xl font-bold text-teal-600">{{ $temuDokter->no_urut }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Waktu Daftar</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $temuDokter->waktu_daftar->format('d M Y') }}</p>
                        <p class="text-sm text-gray-600">{{ $temuDokter->waktu_daftar->format('H:i') }} WIB</p>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <label class="block text-sm font-medium text-gray-500 mb-2">Ditangani Oleh</label>
                    @if($temuDokter->roleUser)
                        <div class="flex items-center space-x-3">
                            <div class="bg-teal-100 p-3 rounded-full">
                                <i class="fas fa-user-md text-teal-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $temuDokter->roleUser->user->nama }}</p>
                                <p class="text-sm text-gray-600">{{ $temuDokter->roleUser->role->nama_role ?? '-' }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500 italic">Belum ditentukan</p>
                    @endif
                </div>
            </div>

            <!-- Pet Info Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pet</h2>

                <div class="space-y-4">
                    <div class="flex items-start space-x-4">
                        <div class="bg-teal-50 p-3 rounded-lg">
                            <i class="fas fa-paw text-teal-600 text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-500">Nama Pet</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $temuDokter->pet->nama_hewan }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Hewan</label>
                            <p class="text-gray-900">{{ $temuDokter->pet->rasHewan->jenisHewan->nama_jenis ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Ras</label>
                            <p class="text-gray-900">{{ $temuDokter->pet->rasHewan->nama_ras ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Kelamin</label>
                            <p class="text-gray-900">{{ $temuDokter->pet->jenis_kelamin }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Warna/Tanda</label>
                            <p class="text-gray-900">{{ $temuDokter->pet->warna_tanda ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Owner Info Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pemilik</h2>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Pemilik</label>
                        <p class="text-gray-900 font-medium">{{ $temuDokter->pet->pemilik->user->nama ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                        <p class="text-gray-900">{{ $temuDokter->pet->pemilik->user->email ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Telepon</label>
                        <p class="text-gray-900">{{ $temuDokter->pet->pemilik->telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Alamat</label>
                        <p class="text-gray-900">{{ $temuDokter->pet->pemilik->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>

                <div class="space-y-2">
                    <a href="{{ route('admin.pet.show', $temuDokter->pet->idpet) }}" class="block w-full px-4 py-2 bg-teal-50 hover:bg-teal-100 text-teal-700 rounded-lg transition-colors text-center">
                        <i class="fas fa-paw mr-2"></i>Lihat Detail Pet
                    </a>
                    <a href="{{ route('resepsionis.pemilik.show', $temuDokter->pet->pemilik->idpemilik) }}" class="block w-full px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition-colors text-center">
                        <i class="fas fa-user mr-2"></i>Lihat Profile Pemilik
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('resepsionis.temu-dokter.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Appointment
        </a>
        </div>
    </div>
</x-app-layout>
