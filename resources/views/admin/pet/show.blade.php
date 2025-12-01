<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <!-- Back Button -->
                <x-back-button href="{{ (request()->routeIs('resepsionis.pet.*') || request()->is('resepsionis/*')) ? route('resepsionis.pet.index') : route('admin.pet.index') }}" label="Kembali" />

                <!-- Breadcrumb -->
                <x-breadcrumb :items="[
                    ['name' => 'Data Pet', 'url' => (request()->routeIs('resepsionis.pet.*') || request()->is('resepsionis/*')) ? route('resepsionis.pet.index') : route('admin.pet.index')],
                    ['name' => $pet->nama_pet ?? $pet->nama]
                ]" />
            </div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pet') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Pet Info Card -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Informasi Pet</h3>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $pet->jenis_kelamin == 'J' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ $pet->jenis_kelamin == 'J' ? 'Jantan' : 'Betina' }}
                                </span>
                            </div>

                            <!-- Pet Icon -->
                            <div class="flex justify-center mb-6">
                                <div class="h-24 w-24 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                    <i class="fi fi-rr-paw text-blue-600" style="font-size: 48px;"></i>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">ID Pet</label>
                                    <p class="text-base text-gray-900 font-semibold">PT{{ str_pad($pet->idpet, 3, '0', STR_PAD_LEFT) }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Pet</label>
                                    <p class="text-base text-gray-900 font-semibold">{{ $pet->nama_pet ?? $pet->nama }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Ras</label>
                                    <p class="text-base text-gray-900">{{ $pet->rasHewan->nama_ras ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Hewan</label>
                                    <p class="text-base text-gray-900">{{ $pet->rasHewan->jenisHewan->nama_jenis_hewan ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Warna</label>
                                    <p class="text-base text-gray-900">{{ $pet->warna ?? '-' }}</p>
                                </div>

                                @if($pet->tanggal_lahir)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Lahir</label>
                                    <p class="text-base text-gray-900">{{ $pet->tanggal_lahir->format('d F Y') }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Usia</label>
                                    <p class="text-base text-gray-900">{{ $pet->age_readable ?? '-' }}</p>
                                </div>
                                @endif

                                @if($pet->ciri_khas)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Ciri Khas</label>
                                    <p class="text-base text-gray-900">{{ $pet->ciri_khas }}</p>
                                </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            @if(! (request()->routeIs('perawat.pasien.*') || request()->is('perawat/pasien/*')))
                            <div class="mt-6 flex flex-col space-y-2">
                                <a href="{{ request()->routeIs('resepsionis.pet.*') ? route('resepsionis.pet.edit', $pet->idpet) : route('admin.pet.edit', $pet->idpet) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fi fi-rr-edit mr-2" style="font-size: 16px;"></i>
                                    Edit Pet
                                </a>

                                <form action="{{ request()->routeIs('resepsionis.pet.*') ? route('resepsionis.pet.destroy', $pet->idpet) : route('admin.pet.destroy', $pet->idpet) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pet ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <i class="fi fi-rr-trash mr-2" style="font-size: 16px;"></i>
                                        Hapus Pet
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Owner Info Card -->
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pemilik</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Pemilik</label>
                                    <p class="text-base text-gray-900">{{ $pet->pemilik->user->nama ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                                    <p class="text-base text-gray-900">{{ $pet->pemilik->user->email ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">No. WhatsApp</label>
                                    <p class="text-base text-gray-900">{{ $pet->pemilik->no_wa ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Alamat</label>
                                    <p class="text-base text-gray-900">{{ $pet->pemilik->alamat ?? '-' }}</p>
                                </div>
                            </div>

                            @if($pet->pemilik)
                            <div class="mt-4">
                                <a href="{{ request()->routeIs('resepsionis.pet.*') ? route('resepsionis.pemilik.show', $pet->pemilik->idpemilik) : route('admin.pemilik.show', $pet->pemilik->idpemilik) }}" class="text-teal-600 hover:text-teal-900 text-sm font-medium">
                                    Lihat Detail Pemilik →
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Medical History Placeholder -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Medis</h3>

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

                                            <div class="mt-3 flex justify-end">
                                                @if(! (request()->routeIs('resepsionis.*') || request()->is('resepsionis/*')))
                                                    @php
                                                        // Default to dokter route for non-resepsionis viewers (admin/dokter/perawat)
                                                        $rekamMedisRoute = request()->routeIs('admin.*') ? route('dokter.rekam-medis.show', $rekam->idrekam_medis) : route('dokter.rekam-medis.show', $rekam->idrekam_medis);
                                                    @endphp
                                                    <a href="{{ $rekamMedisRoute }}" class="text-teal-600 hover:text-teal-900 text-sm font-medium">
                                                        Lihat Detail →
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach

                                    @if($pet->rekamMedis->count() >= 10)
                                        <div class="text-center pt-4">
                                            <p class="text-sm text-gray-500">Menampilkan 10 rekam medis terbaru</p>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fi fi-rr-file-medical-alt text-gray-400" style="font-size: 48px;"></i>
                                    <p class="text-gray-600 mt-4">Belum ada riwayat medis</p>
                                    <p class="text-sm text-gray-500 mt-2">Riwayat medis akan muncul setelah {{ $pet->nama_pet ?? $pet->nama }} melakukan kunjungan</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
