<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <x-back-button href="{{ route('admin.pemilik.index') }}" label="Kembali ke Data Pemilik" />
            <x-breadcrumb :items="[
                ['name' => 'Data Pemilik', 'url' => route('admin.pemilik.index')],
                ['name' => 'Edit Pemilik']
            ]" />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Edit Data Pemilik</h3>

                    @if ($errors->any())
                        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.pemilik.update', $pemilik->idpemilik) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Data User -->
                        <div class="mb-6 p-4 bg-gradient-to-r from-teal-50 to-blue-50 rounded-lg border border-teal-100">
                            <h4 class="text-lg font-semibold text-gray-700 mb-4">Data User</h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="nama_pemilik" class="block text-sm font-medium text-gray-700 mb-2">Nama Pemilik *</label>
                                    <input type="text" name="nama_pemilik" id="nama_pemilik"
                                        value="{{ old('nama_pemilik', $pemilik->user->nama) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                        required>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $pemilik->user->email) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                </div>
                            </div>
                        </div>

                        <!-- Data Pemilik -->
                        <div class="mb-6 p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border border-purple-100">
                            <h4 class="text-lg font-semibold text-gray-700 mb-4">Data Pemilik</h4>

                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label for="no_wa" class="block text-sm font-medium text-gray-700 mb-2">No. WhatsApp *</label>
                                    <input type="text" name="no_wa" id="no_wa"
                                        value="{{ old('no_wa', $pemilik->no_wa) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                        placeholder="08123456789"
                                        required>
                                    <p class="mt-1 text-sm text-gray-500">Format: 08xxxxxxxxxx atau +62xxxxxxxxxx</p>
                                </div>

                                <div>
                                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat *</label>
                                    <textarea name="alamat" id="alamat" rows="3"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                        placeholder="Alamat lengkap"
                                        required>{{ old('alamat', $pemilik->alamat) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.pemilik.index') }}"
                                class="px-6 py-2.5 bg-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-400 focus:ring-4 focus:ring-gray-200 transition duration-300">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-2.5 bg-teal-600 text-white font-medium rounded-lg hover:bg-teal-700 focus:ring-4 focus:ring-teal-300 transition duration-300">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
