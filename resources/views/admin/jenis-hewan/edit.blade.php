<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <!-- Back Button -->
                <x-back-button href="{{ route('admin.jenis-hewan.index') }}" label="Kembali" />

                <!-- Breadcrumb -->
                <x-breadcrumb :items="[
                    ['name' => 'Data Management', 'url' => route('admin.data.index')],
                    ['name' => 'Jenis Hewan', 'url' => route('admin.jenis-hewan.index')],
                    ['name' => 'Edit Jenis Hewan']
                ]" />
            </div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Jenis Hewan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.jenis-hewan.update', $jenisHewan->idjenis_hewan) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nama Jenis Hewan -->
                        <div class="mb-6">
                            <label for="nama_jenis_hewan" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Jenis Hewan <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="nama_jenis_hewan"
                                id="nama_jenis_hewan"
                                value="{{ old('nama_jenis_hewan', $jenisHewan->nama_jenis_hewan) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('nama_jenis_hewan') border-red-500 @enderror"
                                placeholder="Contoh: Anjing, Kucing, Kelinci"
                                required
                            >
                            @error('nama_jenis_hewan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Masukkan nama jenis hewan (species)</p>
                        </div>

                        <!-- Info -->
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Jenis hewan ini memiliki <strong>{{ $jenisHewan->pets_count ?? 0 }} pets</strong> yang terdaftar.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <a href="{{ route('admin.jenis-hewan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
