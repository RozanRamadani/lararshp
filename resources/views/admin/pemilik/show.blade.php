<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <x-back-button href="{{ route('admin.pemilik.index') }}" label="Kembali ke Data Pemilik" />
            <x-breadcrumb :items="[
                ['name' => 'Data Pemilik', 'url' => route('admin.pemilik.index')],
                ['name' => 'Detail Pemilik']
            ]" />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Profil Card -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex flex-col items-center">
                                <div class="w-24 h-24 rounded-full bg-gradient-to-r from-teal-400 to-blue-500 flex items-center justify-center text-white text-3xl font-bold mb-4">
                                    {{ strtoupper(substr($pemilik->user->nama ?? 'U', 0, 2)) }}
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 text-center">{{ $pemilik->user->nama ?? 'Nama tidak tersedia' }}</h3>
                                <p class="text-sm text-gray-500 mb-4">ID: P{{ str_pad($pemilik->idpemilik, 3, '0', STR_PAD_LEFT) }}</p>

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mb-6">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Aktif
                                </span>

                                <div class="w-full space-y-3">
                                    <a href="{{ route('admin.pemilik.edit', $pemilik->idpemilik) }}"
                                        class="w-full flex items-center justify-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit Profil
                                    </a>
                                    <form action="{{ route('admin.pemilik.destroy', $pemilik->idpemilik) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pemilik ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Information -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Informasi Kontak -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Informasi Kontak
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-xs text-gray-500 uppercase mb-1">Email</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $pemilik->user->email ?? 'Tidak tersedia' }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-xs text-gray-500 uppercase mb-1">No. WhatsApp</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $pemilik->no_wa ?? 'Tidak tersedia' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Alamat
                            </h4>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-800">{{ $pemilik->alamat ?? 'Alamat tidak tersedia' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Hewan Peliharaan -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                Hewan Peliharaan ({{ $pemilik->pets->count() }})
                            </h4>

                            @forelse($pemilik->pets as $pet)
                                <div class="mb-3 p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg border border-blue-100">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h5 class="font-semibold text-gray-800">{{ $pet->nama }}</h5>
                                            <p class="text-sm text-gray-600">
                                                {{ $pet->rasHewan->jenisHewan->nama_jenis_hewan ?? 'Unknown' }} - {{ $pet->rasHewan->nama_ras ?? 'Unknown' }}
                                            </p>
                                            <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500">
                                                <span>🎂 {{ $pet->tgl_lahir ? \Carbon\Carbon::parse($pet->tgl_lahir)->format('d M Y') : 'Tidak diketahui' }}</span>
                                                <span>⚧ {{ ucfirst($pet->jenis_kelamin ?? 'Tidak diketahui') }}</span>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            ID: {{ $pet->idpet }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    <p>Belum memiliki hewan peliharaan</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Informasi Tambahan
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-xs text-gray-500 uppercase mb-1">Terdaftar Sejak</p>
                                    <p class="text-sm font-medium text-gray-800">{{ optional($pemilik->created_at)->format('d M Y, H:i') ?? 'Tidak tersedia' }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-xs text-gray-500 uppercase mb-1">Terakhir Update</p>
                                    <p class="text-sm font-medium text-gray-800">{{ optional($pemilik->updated_at)->format('d M Y, H:i') ?? 'Tidak tersedia' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
