<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <x-back-button href="{{ route('resepsionis.temu-dokter.index') }}" label="Kembali ke Daftar Appointment" />
            <x-breadcrumb :items="[
                ['name' => 'Appointment / Temu Dokter', 'url' => route('resepsionis.temu-dokter.index')],
                ['name' => 'Buat Baru']
            ]" />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('resepsionis.temu-dokter.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pet Selection -->
            <div class="md:col-span-2">
                <label for="idpet" class="block text-sm font-medium text-gray-700 mb-2">
                    Pet <span class="text-red-500">*</span>
                </label>
                <select name="idpet" id="idpet" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    <option value="">-- Pilih Pet --</option>
                    @foreach($pets as $pet)
                        <option value="{{ $pet->idpet }}" {{ old('idpet') == $pet->idpet ? 'selected' : '' }}>
                            {{ $pet->nama ?? 'Tidak ada nama' }} ({{ $pet->pemilik->user->nama ?? '-' }}) - {{ $pet->rasHewan->jenisHewan->nama_jenis ?? '-' }}
                        </option>
                    @endforeach
                </select>
                @error('idpet')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nomor Urut (Auto-generated) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Urut (Otomatis)
                </label>
                <div class="w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-gray-600">
                    <span class="text-2xl font-bold text-teal-600">{{ $nextNumber }}</span>
                </div>
                <p class="mt-1 text-xs text-gray-500">⚡ Nomor urut akan di-generate otomatis oleh sistem</p>
            </div>

            <!-- Waktu Daftar -->
            <div>
                <label for="waktu_daftar" class="block text-sm font-medium text-gray-700 mb-2">
                    Waktu Daftar
                </label>
                <input type="datetime-local" name="waktu_daftar" id="waktu_daftar"
                    value="{{ old('waktu_daftar', now()->format('Y-m-d\TH:i')) }}"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                @error('waktu_daftar')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Petugas Medis -->
            <div>
                <label for="idrole_user" class="block text-sm font-medium text-gray-700 mb-2">
                    Ditangani Oleh (Dokter/Perawat)
                </label>
                <select name="idrole_user" id="idrole_user" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    <option value="">-- Belum Ditentukan --</option>
                    @foreach($medicalStaff as $staff)
                        <option value="{{ $staff->idrole_user }}" {{ old('idrole_user') == $staff->idrole_user ? 'selected' : '' }}>
                            {{ $staff->nama }} - {{ $staff->nama_role }}
                        </option>
                    @endforeach
                </select>
                @error('idrole_user')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status (Auto-set to Menunggu) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status
                </label>
                <div class="w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Menunggu
                    </span>
                </div>
                <p class="mt-1 text-xs text-gray-500">⚡ Appointment baru otomatis berstatus "Menunggu"</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
            <a href="{{ route('resepsionis.temu-dokter.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg shadow-md transition-colors">
                <i class="fas fa-save mr-2"></i>Simpan Appointment
            </button>
        </div>
    </div>
    </div>
</x-app-layout>
