<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit User') }}
            </h2>
            <a href="{{ route('admin.user.show', $user->iduser) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <i class="fi fi-rr-arrow-left mr-2" style="font-size: 16px;"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <x-breadcrumb :items="[
                    ['name' => 'Data Management', 'url' => route('admin.data.index')],
                    ['name' => 'User & Role', 'url' => route('admin.user.index')],
                    ['name' => 'Edit User']
                ]" />
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.user.update', $user->iduser) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Nama -->
                        <div class="mb-4">
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @if(!empty($showContactFields))
                        <!-- No WhatsApp -->
                        <div class="mb-4">
                            <label for="no_wa" class="block text-sm font-medium text-gray-700 mb-2">
                                No. WhatsApp
                            </label>
                            <input type="text" name="no_wa" id="no_wa" value="{{ old('no_wa', $user->no_wa) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="08xxxxxxxxxx">
                            @error('no_wa')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kota -->
                        <div class="mb-4">
                            <label for="kota" class="block text-sm font-medium text-gray-700 mb-2">
                                Kota
                            </label>
                            <input type="text" name="kota" id="kota" value="{{ old('kota', $user->kota) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Nama Kota">
                            @error('kota')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-gray-500 text-xs">(Kosongkan jika tidak ingin mengubah)</span>
                            </label>
                            <input type="password" name="password" id="password"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-sm text-yellow-800">
                                <i class="fi fi-rr-info mr-1"></i>
                                <strong>Catatan:</strong> Untuk mengelola role user (tambah, edit, atau hapus role), gunakan menu
                                <a href="{{ route('admin.user.manage-roles', $user->iduser) }}" class="text-blue-600 hover:underline font-semibold">Kelola Role</a>.
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.user.show', $user->iduser) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fi fi-rr-disk mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
