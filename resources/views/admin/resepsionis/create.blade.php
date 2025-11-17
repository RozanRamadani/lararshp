<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <x-back-button href="{{ route('admin.resepsionis.index') }}" label="Kembali" />
                <x-breadcrumb :items="[
                    ['name' => 'Data Resepsionis', 'url' => route('admin.resepsionis.index')],
                    ['name' => 'Tambah Resepsionis']
                ]" />
            </div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Resepsionis Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.resepsionis.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password *</label>
                            <input type="password" name="password" id="password" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password *</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        </div>
                        @if(!empty($showContactFields))
                        <div class="mb-4">
                            <label for="no_wa" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                            <input type="text" name="no_wa" id="no_wa" value="{{ old('no_wa') }}"
                                placeholder="contoh: 081234567890"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            @error('no_wa')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="kota" class="block text-sm font-medium text-gray-700">Kota</label>
                            <input type="text" name="kota" id="kota" value="{{ old('kota') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            @error('kota')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.resepsionis.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                                Batal
                            </a>
                            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg transition-colors">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
