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
            <!-- Tabs Navigation -->
            <div class="mb-6 border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button type="button" onclick="showTab('new')" id="tab-new" class="tab-button active border-b-2 border-teal-500 py-4 px-1 text-center text-sm font-medium text-teal-600">
                        Buat Pemilik Baru
                    </button>
                    <button type="button" onclick="showTab('upgrade')" id="tab-upgrade" class="tab-button border-b-2 border-transparent py-4 px-1 text-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Upgrade User Jadi Pemilik
                    </button>
                </nav>
            </div>

            <!-- Tab Content: Create New Pemilik -->
            <div id="content-new" class="tab-content bg-white overflow-hidden shadow-sm sm:rounded-lg">
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

                        <!-- No WhatsApp -->
                        <div class="mb-6">
                            <label for="no_wa" class="block text-sm font-medium text-gray-700 mb-2">
                                No. WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="no_wa"
                                id="no_wa"
                                value="{{ old('no_wa') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('no_wa') border-red-500 @enderror"
                                placeholder="Contoh: 08123456789"
                                required
                            >
                            @error('no_wa')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Nomor WhatsApp aktif yang dapat dihubungi</p>
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
                                <i class="fi fi-rr-check mr-2 text-white" style="font-size: 16px;"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tab Content: Upgrade User -->
            <div id="content-upgrade" class="tab-content hidden bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded">
                        <p class="text-sm">Pilih user yang sudah terdaftar untuk di-upgrade menjadi Pemilik Hewan.</p>
                    </div>

                    <form method="POST" action="{{ route('admin.pemilik.upgrade-user') }}">
                        @csrf

                        <!-- Pilih User -->
                        <div class="mb-6">
                            <label for="iduser" class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih User <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="iduser"
                                id="iduser"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('iduser') border-red-500 @enderror"
                                required
                            >
                                <option value="">-- Pilih User --</option>
                                @foreach($availableUsers as $user)
                                    <option value="{{ $user->iduser }}" {{ old('iduser') == $user->iduser ? 'selected' : '' }}>
                                        {{ $user->nama }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('iduser')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">User yang belum memiliki role Pemilik</p>
                        </div>

                        <!-- No WhatsApp -->
                        <div class="mb-6">
                            <label for="no_wa_upgrade" class="block text-sm font-medium text-gray-700 mb-2">
                                No. WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="no_wa"
                                id="no_wa_upgrade"
                                value="{{ old('no_wa') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('no_wa') border-red-500 @enderror"
                                placeholder="Contoh: 08123456789"
                                required
                            >
                            @error('no_wa')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="mb-6">
                            <label for="alamat_upgrade" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                name="alamat"
                                id="alamat_upgrade"
                                rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 @error('alamat') border-red-500 @enderror"
                                placeholder="Masukkan alamat lengkap"
                                required
                            >{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <a href="{{ route('admin.pemilik.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fi fi-rr-check mr-2 text-white" style="font-size: 16px;"></i>
                                Upgrade User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tab) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-button').forEach(el => {
                el.classList.remove('active', 'border-teal-500', 'text-teal-600');
                el.classList.add('border-transparent', 'text-gray-500');
            });

            // Show selected tab
            document.getElementById('content-' + tab).classList.remove('hidden');
            const activeTab = document.getElementById('tab-' + tab);
            activeTab.classList.add('active', 'border-teal-500', 'text-teal-600');
            activeTab.classList.remove('border-transparent', 'text-gray-500');
        }
    </script>
</x-app-layout>
