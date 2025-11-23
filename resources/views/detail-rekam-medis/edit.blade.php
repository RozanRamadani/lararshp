<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Detail Rekam Medis
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <x-breadcrumb :items="[
                    ['name' => 'Medical Records', 'url' => route('dokter.rekam-medis.index')],
                    ['name' => 'Record #' . $detail->idrekam_medis, 'url' => route('dokter.rekam-medis.show', $detail->idrekam_medis)],
                    ['name' => 'Tindakan & Terapi', 'url' => route('dokter.rekam-medis.detail.index', $detail->idrekam_medis)],
                    ['name' => 'Edit Detail #' . $detail->iddetail_rekam_medis]
                ]" />
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

            <!-- Form Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Form Edit Tindakan/Terapi</h3>

                    <form action="{{ route('dokter.rekam-medis.detail.update', [$detail->idrekam_medis, $detail->iddetail_rekam_medis]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Kode Tindakan -->
                        <div class="mb-6">
                            <label for="idkode_tindakan_terapi" class="block text-sm font-medium text-gray-700 mb-2">
                                Kode Tindakan/Terapi <span class="text-red-500">*</span>
                            </label>
                            <select name="idkode_tindakan_terapi"
                                    id="idkode_tindakan_terapi"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('idkode_tindakan_terapi') border-red-500 @enderror"
                                    required>
                                <option value="">-- Pilih Kode Tindakan/Terapi --</option>
                                @foreach($kodeTindakan as $kode)
                                    <option value="{{ $kode->idkode_tindakan_terapi }}"
                                            {{ (old('idkode_tindakan_terapi', $detail->idkode_tindakan_terapi) == $kode->idkode_tindakan_terapi) ? 'selected' : '' }}>
                                        {{ $kode->kode }} - {{ $kode->deskripsi_tindakan_terapi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idkode_tindakan_terapi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Detail -->
                        <div class="mb-6">
                            <label for="detail" class="block text-sm font-medium text-gray-700 mb-2">
                                Keterangan/Detail Pelaksanaan
                            </label>
                            <textarea name="detail"
                                      id="detail"
                                      rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('detail') border-red-500 @enderror"
                                      placeholder="Tambahkan keterangan detail pelaksanaan tindakan/terapi (opsional)">{{ old('detail', $detail->detail) }}</textarea>
                            @error('detail')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Maksimal 1000 karakter</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('dokter.rekam-medis.detail.index', $detail->idrekam_medis) }}"
                               class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Batal
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                Update Detail
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
