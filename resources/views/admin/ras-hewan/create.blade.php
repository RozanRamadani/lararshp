<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <!-- Back Button -->
                <x-back-button href="{{ route('admin.ras-hewan.index') }}" label="Kembali" />

                <!-- Breadcrumb -->
                <x-breadcrumb :items="[
                    ['name' => 'Data Management', 'url' => route('admin.data.index')],
                    ['name' => 'Ras Hewan', 'url' => route('admin.ras-hewan.index')],
                    ['name' => 'Tambah Ras Hewan']
                ]" />
            </div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Ras Hewan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.ras-hewan.store') }}">
                        @csrf

                        <!-- Nama Ras -->
                        <div class="mb-6">
                            <label for="nama_ras" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Ras Hewan <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="nama_ras"
                                id="nama_ras"
                                value="{{ old('nama_ras') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nama_ras') border-red-500 @enderror"
                                placeholder="Contoh: Golden Retriever, Persian, Angora"
                                required
                            >
                            @error('nama_ras')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Masukkan nama ras hewan (breed)</p>
                        </div>

                        <!-- Jenis Hewan -->
                        <div class="mb-6">
                            <label for="idjenis_hewan" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Hewan <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="idjenis_hewan"
                                id="idjenis_hewan"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('idjenis_hewan') border-red-500 @enderror"
                                required
                            >
                                <option value="">-- Pilih Jenis Hewan --</option>
                                @foreach($jenisHewan as $jenis)
                                    <option value="{{ $jenis->idjenis_hewan }}" {{ old('idjenis_hewan') == $jenis->idjenis_hewan ? 'selected' : '' }}>
                                        {{ $jenis->nama_jenis_hewan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idjenis_hewan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Pilih jenis/species dari ras hewan ini</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <a href="{{ route('admin.ras-hewan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
