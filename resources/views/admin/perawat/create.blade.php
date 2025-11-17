<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <x-back-button href="{{ route('admin.perawat.index') }}" label="Kembali" />
                <x-breadcrumb :items="[
                    ['name' => 'Data Perawat', 'url' => route('admin.perawat.index')],
                    ['name' => 'Tambah Perawat']
                ]" />
            </div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Perawat Baru') }}
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
                    <form method="POST" action="{{ route('admin.perawat.store') }}">
                        @csrf

                        <!-- Pilih User -->
                        <div class="mb-4">
                            <label for="id_user" class="block text-sm font-medium text-gray-700">Pilih User (Perawat) *</label>
                            <select name="id_user" id="id_user" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->iduser }}" {{ old('id_user') == $user->iduser ? 'selected' : '' }}>
                                        {{ $user->nama }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_user')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @if($users->isEmpty())
                                <p class="mt-1 text-sm text-amber-600">Tidak ada user dengan role Perawat yang belum memiliki profil.</p>
                            @endif
                        </div>

                        <!-- Alamat -->
                        <div class="mb-4">
                            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat *</label>
                            <textarea name="alamat" id="alamat" rows="3" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No HP -->
                        <div class="mb-4">
                            <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor HP *</label>
                            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" required
                                placeholder="contoh: 081234567890"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            @error('no_hp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin *</label>
                            <div class="flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }} required
                                        class="rounded-full border-gray-300 text-teal-600 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                    <span class="ml-2">Laki-laki</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }} required
                                        class="rounded-full border-gray-300 text-teal-600 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                    <span class="ml-2">Perempuan</span>
                                </label>
                            </div>
                            @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pendidikan -->
                        <div class="mb-4">
                            <label for="pendidikan" class="block text-sm font-medium text-gray-700">Pendidikan *</label>
                            <input type="text" name="pendidikan" id="pendidikan" value="{{ old('pendidikan') }}" required
                                placeholder="contoh: D3 Keperawatan, S1 Keperawatan, dll"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            @error('pendidikan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.perawat.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
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
