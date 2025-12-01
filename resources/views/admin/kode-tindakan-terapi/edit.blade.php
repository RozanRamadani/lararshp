<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <!-- Back Button -->
                <x-back-button href="{{ route('admin.kode-tindakan-terapi.index') }}" label="Kembali" />

                <!-- Breadcrumb -->
                <x-breadcrumb :items="[
                    ['name' => 'Data Management', 'url' => route('admin.data.index')],
                    ['name' => 'Kode Tindakan Terapi', 'url' => route('admin.kode-tindakan-terapi.index')],
                    ['name' => 'Edit Kode Tindakan']
                ]" />
            </div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Kode Tindakan Terapi') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.kode-tindakan-terapi.update', $kodeTindakanTerapi->idkode_tindakan_terapi) }}">
                        @csrf
                        @method('PUT')

                        <!-- Kode Tindakan -->
                        <div class="mb-6">
                            <label for="kode" class="block text-sm font-medium text-gray-700 mb-2">
                                Kode Tindakan <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="kode"
                                id="kode"
                                value="{{ old('kode', $kodeTindakanTerapi->kode) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('kode') border-red-500 @enderror"
                                placeholder="Contoh: KT001, VKS-001"
                                required
                            >
                            @error('kode')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Masukkan kode unik tindakan terapi (max 50 karakter)</p>
                        </div>

                        <!-- Nama Tindakan -->
                        <div class="mb-6">
                            <label for="deskripsi_tindakan_terapi" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Tindakan <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="deskripsi_tindakan_terapi"
                                id="deskripsi_tindakan_terapi"
                                value="{{ old('deskripsi_tindakan_terapi', $kodeTindakanTerapi->deskripsi_tindakan_terapi) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('deskripsi_tindakan_terapi') border-red-500 @enderror"
                                placeholder="Contoh: Vaksinasi Rabies, Sterilisasi Kucing"
                                required
                            >
                            @error('deskripsi_tindakan_terapi')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Masukkan nama lengkap tindakan terapi</p>
                        </div>

                        <!-- Tarif -->
                        <div class="mb-6">
                            <label for="tarif" class="block text-sm font-medium text-gray-700 mb-2">
                                Tarif (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="number"
                                name="tarif"
                                id="tarif"
                                value="{{ old('tarif', $kodeTindakanTerapi->tarif) }}"
                                min="0"
                                step="1000"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('tarif') border-red-500 @enderror"
                                placeholder="0"
                                required
                            >
                            @error('tarif')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Masukkan tarif tindakan (0 untuk gratis)</p>
                        </div>

                        <!-- Kategori -->
                        <div class="mb-6">
                            <label for="idkategori" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="idkategori"
                                id="idkategori"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('idkategori') border-red-500 @enderror"
                                required
                            >
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->idkategori }}" {{ old('idkategori', $kodeTindakanTerapi->idkategori) == $kat->idkategori ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idkategori')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Pilih kategori tindakan</p>
                        </div>

                        <!-- Kategori Klinis -->
                        <div class="mb-6">
                            <label for="idkategori_klinis" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori Klinis <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="idkategori_klinis"
                                id="idkategori_klinis"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('idkategori_klinis') border-red-500 @enderror"
                                required
                            >
                                <option value="">-- Pilih Kategori Klinis --</option>
                                @foreach($kategoriKlinis as $katKlinis)
                                    <option value="{{ $katKlinis->idkategori_klinis }}" {{ old('idkategori_klinis', $kodeTindakanTerapi->idkategori_klinis) == $katKlinis->idkategori_klinis ? 'selected' : '' }}>
                                        {{ $katKlinis->nama_kategori_klinis }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idkategori_klinis')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Pilih kategori klinis tindakan</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <a href="{{ route('admin.kode-tindakan-terapi.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
