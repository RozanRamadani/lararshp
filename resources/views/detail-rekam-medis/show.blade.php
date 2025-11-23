<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Tindakan/Terapi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <x-breadcrumb :items="[
                    ['name' => 'Medical Records', 'url' => auth()->user()->hasRole('Dokter') ? route('dokter.rekam-medis.index') : route('perawat.rekam-medis.index')],
                    ['name' => 'Record #' . $detail->idrekam_medis, 'url' => auth()->user()->hasRole('Dokter') ? route('dokter.rekam-medis.show', $detail->idrekam_medis) : route('perawat.rekam-medis.show', $detail->idrekam_medis)],
                    ['name' => 'Tindakan & Terapi', 'url' => auth()->user()->hasRole('Dokter') ? route('dokter.rekam-medis.detail.index', $detail->idrekam_medis) : route('perawat.rekam-medis.detail.index', $detail->idrekam_medis)],
                    ['name' => 'Detail #' . $detail->iddetail_rekam_medis]
                ]" />
            </div>

            <!-- Action Buttons -->
            <div class="mb-6 flex justify-end items-center">
                @if($canEdit)
                    <div class="flex space-x-2">
                        <a href="{{ route('dokter.rekam-medis.detail.edit', [$detail->idrekam_medis, $detail->iddetail_rekam_medis]) }}"
                           class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('dokter.rekam-medis.detail.destroy', [$detail->idrekam_medis, $detail->iddetail_rekam_medis]) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus detail ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Patient Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pasien</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nama Pet</label>
                            <p class="text-base text-gray-900 font-semibold">{{ $detail->rekamMedis->temuDokter->pet->nama ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Pemilik</label>
                            <p class="text-base text-gray-900">{{ $detail->rekamMedis->temuDokter->pet->pemilik->nama ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Tanggal Kunjungan</label>
                            <p class="text-base text-gray-900">{{ $detail->rekamMedis->created_at?->format('d F Y') ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Detail Tindakan/Terapi</h3>

                    <div class="space-y-4">
                        <!-- Kode Tindakan/Terapi -->
                        <div class="border-b border-gray-200 pb-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Kode Tindakan/Terapi</label>
                            <p class="text-base text-gray-900 font-semibold">{{ $detail->kodeTindakanTerapi->kode ?? '-' }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $detail->kodeTindakanTerapi->deskripsi_tindakan_terapi ?? '-' }}</p>
                        </div>

                        <!-- Kategori -->
                        @if($detail->kodeTindakanTerapi)
                            <div class="border-b border-gray-200 pb-4">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Kategori</label>
                                <p class="text-base text-gray-900">
                                    @if($detail->kodeTindakanTerapi->kategori)
                                        {{ $detail->kodeTindakanTerapi->kategori->nama_kategori ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                            <div class="border-b border-gray-200 pb-4">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Kategori Klinis</label>
                                <p class="text-base text-gray-900">
                                    @if($detail->kodeTindakanTerapi->kategoriKlinis)
                                        {{ $detail->kodeTindakanTerapi->kategoriKlinis->nama_kategori_klinis ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        @endif

                        <!-- Detail -->
                        <div class="pb-4">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Keterangan/Detail Pelaksanaan</label>
                            @if($detail->detail)
                                <p class="text-base text-gray-900 whitespace-pre-line">{{ $detail->detail }}</p>
                            @else
                                <p class="text-base text-gray-400 italic">Tidak ada keterangan tambahan</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Link back to Rekam Medis -->
            <div class="mt-6">
                <a href="{{ auth()->user()->hasRole('Dokter') ? route('dokter.rekam-medis.show', ['rekamMedis' => $detail->idrekam_medis]) : route('perawat.rekam-medis.show', ['rekam_medi' => $detail->idrekam_medis]) }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Lihat Rekam Medis Lengkap
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
