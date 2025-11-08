<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <!-- Back Button -->
                <x-back-button href="{{ route('admin.pemilik.index') }}" label="Kembali" />

                <!-- Breadcrumb -->
                <x-breadcrumb :items="[
                    ['name' => 'Data Pemilik', 'url' => route('admin.pemilik.index')],
                    ['name' => 'Tambah Pemilik']
                ]" />
            </div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Pemilik Hewan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.pemilik.store') }}">
                        @csrf

                        <!-- Nama Pemilik -->
                        <div class="mb-6">
                            <label for="nama_pemilik" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Pemilik <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="nama_pemilik"
                                id="nama_pemilik"
                                value="{{ old('nama_pemilik') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('nama_pemilik') border-red-500 @enderror"
                                placeholder="Masukkan nama lengkap pemilik"
                                required
                            >
                            @error('nama_pemilik')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="mb-6">
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                name="alamat"
                                id="alamat"
                                rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('alamat') border-red-500 @enderror"
                                placeholder="Masukkan alamat lengkap"
                                required
                            >{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kota -->
                        <div class="mb-6">
                            <label for="kota" class="block text-sm font-medium text-gray-700 mb-2">
                                Kota <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="kota"
                                id="kota"
                                value="{{ old('kota') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('kota') border-red-500 @enderror"
                                placeholder="Contoh: Surabaya"
                                required
                            >
                            @error('kota')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No Telepon -->
                        <div class="mb-6">
                            <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-2">
                                No Telepon <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="no_telepon"
                                id="no_telepon"
                                value="{{ old('no_telepon') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('no_telepon') border-red-500 @enderror"
                                placeholder="Contoh: 08123456789"
                                required
                            >
                            @error('no_telepon')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Nomor telepon aktif yang dapat dihubungi</p>
                        </div>

                        <!-- Email (Optional) -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('email') border-red-500 @enderror"
                                placeholder="contoh@email.com"
                            >
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Opsional - untuk komunikasi alternatif</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <a href="{{ route('admin.pemilik.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <x-lordicon icon="check" trigger="morph" size="16" class="mr-2 text-white" />
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
