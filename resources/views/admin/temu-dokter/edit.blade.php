@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center text-sm text-gray-600 mb-2">
            <a href="{{ route('resepsionis.temu-dokter.index') }}" class="hover:text-teal-600">Appointment</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">Edit</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900">Edit Appointment #{{ $temuDokter->no_urut }}</h1>
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
    <form action="{{ route('resepsionis.temu-dokter.update', $temuDokter->idreservasi_dokter) }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pet Selection -->
            <div class="md:col-span-2">
                <label for="idpet" class="block text-sm font-medium text-gray-700 mb-2">
                    Pet <span class="text-red-500">*</span>
                </label>
                <select name="idpet" id="idpet" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    <option value="">-- Pilih Pet --</option>
                    @foreach($pets as $pet)
                        <option value="{{ $pet->idpet }}" {{ (old('idpet', $temuDokter->idpet) == $pet->idpet) ? 'selected' : '' }}>
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
                    Nomor Urut <span class="text-red-500">*</span>
                </label>
                <input type="number" name="no_urut" id="no_urut"
                    value="{{ old('no_urut', $temuDokter->no_urut) }}"
                    min="1"
                    required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                @error('no_urut')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Waktu Daftar -->
            <div>
                <label for="waktu_daftar" class="block text-sm font-medium text-gray-700 mb-2">
                    Waktu Daftar <span class="text-red-500">*</span>
                </label>
                <input type="datetime-local" name="waktu_daftar" id="waktu_daftar"
                    value="{{ old('waktu_daftar', $temuDokter->waktu_daftar->format('Y-m-d\TH:i')) }}"
                    required
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
                        <option value="{{ $staff->idrole_user }}" {{ (old('idrole_user', $temuDokter->idrole_user) == $staff->idrole_user) ? 'selected' : '' }}>
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
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status" id="status" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    <option value="0" {{ (old('status', $temuDokter->status) == '0') ? 'selected' : '' }}>Menunggu</option>
                    <option value="1" {{ (old('status', $temuDokter->status) == '1') ? 'selected' : '' }}>Dalam Proses</option>
                    <option value="2" {{ (old('status', $temuDokter->status) == '2') ? 'selected' : '' }}>Selesai</option>
                    <option value="3" {{ (old('status', $temuDokter->status) == '3') ? 'selected' : '' }}>Batal</option>
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
                <i class="fas fa-save mr-2"></i>Update Appointment
            </button>
        </div>
    </form>
</div>
@endsection
