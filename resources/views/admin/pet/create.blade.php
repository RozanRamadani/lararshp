<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <!-- Back Button -->
                <x-back-button href="{{ route('admin.pet.index') }}" label="Kembali" />

                <!-- Breadcrumb -->
                <x-breadcrumb :items="[
                    ['name' => 'Data Pet', 'url' => route('admin.pet.index')],
                    ['name' => 'Tambah Pet']
                ]" />
            </div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Data Pet') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.pet.store') }}">
                        @csrf

                        <!-- Nama Pet -->
                        <div class="mb-6">
                            <label for="nama_pet" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Pet <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="nama_pet"
                                id="nama_pet"
                                value="{{ old('nama_pet') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('nama_pet') border-red-500 @enderror"
                                placeholder="Contoh: Bruno, Mimi, Luna"
                                required
                            >
                            @error('nama_pet')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ras Hewan -->
                        <div class="mb-6">
                            <label for="idras_hewan" class="block text-sm font-medium text-gray-700 mb-2">
                                Ras Hewan <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="idras_hewan"
                                id="idras_hewan"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('idras_hewan') border-red-500 @enderror"
                                required
                            >
                                <option value="">-- Pilih Ras --</option>
                                <!-- Populate with ras hewan from database -->
                                @foreach($rasHewan ?? [] as $ras)
                                    <option value="{{ $ras->idras_hewan }}" {{ old('idras_hewan') == $ras->idras_hewan ? 'selected' : '' }}>
                                        {{ $ras->nama_ras }} ({{ $ras->jenisHewan->nama_jenis_hewan ?? '' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('idras_hewan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pemilik -->
                        <div class="mb-6">
                            <label for="idpemilik" class="block text-sm font-medium text-gray-700 mb-2">
                                Pemilik <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="idpemilik"
                                id="idpemilik"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('idpemilik') border-red-500 @enderror"
                                required
                            >
                                <option value="">-- Pilih Pemilik --</option>
                                <!-- Populate with pemilik from database -->
                                @foreach($pemilikList ?? [] as $owner)
                                    <option value="{{ $owner->idpemilik }}" {{ old('idpemilik') == $owner->idpemilik ? 'selected' : '' }}>
                                        {{ $owner->user->nama ?? 'Tanpa Nama' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idpemilik')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input
                                        type="radio"
                                        name="jenis_kelamin"
                                        value="Jantan"
                                        class="rounded-full border-gray-300 text-teal-600 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                        {{ old('jenis_kelamin') == 'Jantan' ? 'checked' : '' }}
                                        required
                                    >
                                    <span class="ml-2">Jantan</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input
                                        type="radio"
                                        name="jenis_kelamin"
                                        value="Betina"
                                        class="rounded-full border-gray-300 text-teal-600 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                        {{ old('jenis_kelamin') == 'Betina' ? 'checked' : '' }}
                                        required
                                    >
                                    <span class="ml-2">Betina</span>
                                </label>
                            </div>
                            @error('jenis_kelamin')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="mb-6">
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir
                            </label>
                            <input
                                type="date"
                                name="tanggal_lahir"
                                id="tanggal_lahir"
                                value="{{ old('tanggal_lahir') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('tanggal_lahir') border-red-500 @enderror"
                            >
                            @error('tanggal_lahir')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Opsional - untuk menghitung usia pet</p>
                        </div>

                        <!-- Warna -->
                        <div class="mb-6">
                            <label for="warna" class="block text-sm font-medium text-gray-700 mb-2">
                                Warna
                            </label>
                            <input
                                type="text"
                                name="warna"
                                id="warna"
                                value="{{ old('warna') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('warna') border-red-500 @enderror"
                                placeholder="Contoh: Coklat, Putih, Belang"
                            >
                            @error('warna')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ciri Khas -->
                        <div class="mb-6">
                            <label for="ciri_khas" class="block text-sm font-medium text-gray-700 mb-2">
                                Ciri Khas
                            </label>
                            <textarea
                                name="ciri_khas"
                                id="ciri_khas"
                                rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('ciri_khas') border-red-500 @enderror"
                                placeholder="Contoh: Ada tanda hitam di telinga kiri, ekor pendek"
                            >{{ old('ciri_khas') }}</textarea>
                            @error('ciri_khas')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Opsional - ciri yang membedakan dengan pet lain</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <a href="{{ route('admin.pet.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
