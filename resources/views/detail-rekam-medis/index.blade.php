<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Rekam Medis - Tindakan & Terapi
            </h2>
            @if($canEdit)
                <a href="{{ auth()->user()->hasRole('Dokter') ? route('dokter.rekam-medis.detail.create', $rekamMedis->idrekam_medis) : '#' }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Detail
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <x-breadcrumb :items="[
                    ['name' => 'Medical Records', 'url' => auth()->user()->hasRole('Dokter') ? route('dokter.rekam-medis.index') : route('perawat.rekam-medis.index')],
                    ['name' => 'Record #' . $rekamMedis->idrekam_medis, 'url' => auth()->user()->hasRole('Dokter') ? route('dokter.rekam-medis.show', $rekamMedis->idrekam_medis) : route('perawat.rekam-medis.show', $rekamMedis->idrekam_medis)],
                    ['name' => 'Tindakan & Terapi']
                ]" />
            </div>

            <!-- Patient Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pasien</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nama Pet</label>
                            <p class="text-base text-gray-900 font-semibold">{{ $rekamMedis->temuDokter->pet->nama ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Pemilik</label>
                            <p class="text-base text-gray-900">{{ $rekamMedis->temuDokter->pet->pemilik->nama ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Tanggal Kunjungan</label>
                            <p class="text-base text-gray-900">{{ $rekamMedis->created_at?->format('d F Y') ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Detail Rekam Medis List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Tindakan & Terapi</h3>

                    @if($details->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Tindakan/Terapi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($details as $index => $detail)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $details->firstItem() + $index }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $detail->kodeTindakanTerapi->kode ?? '-' }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($detail->kodeTindakanTerapi->deskripsi_tindakan_terapi ?? '-', 60) }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $detail->detail ? Str::limit($detail->detail, 50) : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <a href="{{ auth()->user()->hasRole('Dokter') ? route('dokter.rekam-medis.detail.show', [$rekamMedis->idrekam_medis, $detail->iddetail_rekam_medis]) : route('perawat.rekam-medis.detail.show', [$rekamMedis->idrekam_medis, $detail->iddetail_rekam_medis]) }}"
                                                   class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>

                                                @if($canEdit)
                                                    <a href="{{ route('dokter.rekam-medis.detail.edit', [$rekamMedis->idrekam_medis, $detail->iddetail_rekam_medis]) }}"
                                                       class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>

                                                    <form action="{{ route('dokter.rekam-medis.detail.destroy', [$rekamMedis->idrekam_medis, $detail->iddetail_rekam_medis]) }}"
                                                          method="POST"
                                                          class="inline"
                                                          onsubmit="return confirm('Yakin ingin menghapus detail ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $details->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Belum ada detail tindakan/terapi yang ditambahkan</p>
                            @if($canEdit)
                                <a href="{{ route('dokter.rekam-medis.detail.create', $rekamMedis->idrekam_medis) }}"
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                    Tambah Detail Pertama
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
