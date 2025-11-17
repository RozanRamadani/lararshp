@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center text-sm text-gray-600 mb-2">
            <a href="{{ route('resepsionis.temu-dokter.index') }}" class="hover:text-teal-600">Appointment</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">Buat Baru</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900">Buat Appointment Baru</h1>
    </div>

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
                            {{ $pet->nama_hewan }} - {{ $pet->pemilik->user->nama ?? '-' }} ({{ $pet->rasHewan->jenisHewan->nama_jenis ?? '-' }})
                        </option>
                    @endforeach
                </select>
                @error('idpet')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nomor Urut -->
            <div>
                <label for="no_urut" class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Urut
                </label>
                <input type="number" name="no_urut" id="no_urut"
                    value="{{ old('no_urut', $nextNumber) }}"
                    min="1"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                <p class="mt-1 text-xs text-gray-500">Nomor urut otomatis: {{ $nextNumber }}</p>
                @error('no_urut')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
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

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status
                </label>
                <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    <option value="0" {{ old('status', '0') == '0' ? 'selected' : '' }}>Menunggu</option>
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Dalam Proses</option>
                    <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Selesai</option>
                    <option value="3" {{ old('status') == '3' ? 'selected' : '' }}>Batal</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
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
    </form>
</div>
@endsection
