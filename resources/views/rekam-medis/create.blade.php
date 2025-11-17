<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add New Medical Record
            </h2>
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                Perawat
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('perawat.rekam-medis.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Medical Records
                </a>
            </div>

            <form action="{{ route('perawat.rekam-medis.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column - Patient Info -->
                    <div class="lg:col-span-1">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Patient Information</h3>

                                <div class="mb-4">
                                    <label for="idpet" class="block text-sm font-medium text-gray-700 mb-2">Select Pet *</label>
                                    <select id="idpet" name="idpet" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select Pet --</option>
                                        @foreach($pets as $pet)
                                            <option value="{{ $pet->idpet }}" {{ (old('idpet') ?? $selectedPet?->idpet) == $pet->idpet ? 'selected' : '' }}>
                                                {{ $pet->nama }} - {{ $pet->pemilik->user->nama ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('idpet')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                @if($selectedPet)
                                    <div class="mt-4 p-4 bg-gray-50 rounded-md">
                                        <h4 class="font-medium text-gray-900 mb-2">{{ $selectedPet->nama }}</h4>
                                        <div class="space-y-1 text-sm text-gray-600">
                                            <p><strong>Species:</strong> {{ $selectedPet->jenisHewan->nama_jenis_hewan ?? '-' }}</p>
                                            <p><strong>Breed:</strong> {{ $selectedPet->rasHewan->nama_ras ?? '-' }}</p>
                                            <p><strong>Gender:</strong> {{ $selectedPet->jenis_kelamin ?? '-' }}</p>
                                            <p><strong>Owner:</strong> {{ $selectedPet->pemilik->user->nama ?? '-' }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Medical Staff</h3>

                                <div class="mb-4">
                                    <label for="iddokter" class="block text-sm font-medium text-gray-700 mb-2">Doctor</label>
                                    <select id="iddokter" name="iddokter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select Doctor --</option>
                                        @foreach($dokters as $dokter)
                                            <option value="{{ $dokter->iduser }}" {{ old('iddokter') == $dokter->iduser ? 'selected' : '' }}>
                                                {{ $dokter->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('iddokter')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="p-4 bg-gray-50 rounded-md">
                                    <p class="text-sm text-gray-600"><strong>Dokter Pemeriksa:</strong></p>
                                    <p class="text-sm text-gray-800 mt-1">Dokter akan otomatis diambil dari appointment terbaru. Jika ingin mengubah dokter, pilih dari dropdown di atas.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Medical Details -->
                    <div class="lg:col-span-2">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Medical Examination</h3>
                                <p class="text-sm text-gray-500 mb-4">Silakan isi data pemeriksaan medis hewan. Field yang wajib diisi ditandai dengan tanda *.</p>

                                <div class="mb-4">
                                    <label for="anamnesa" class="block text-sm font-medium text-gray-700 mb-2">Anamnesis / Anamnesa <span class="text-red-500">*</span></label>
                                    <textarea id="anamnesa" name="anamnesa" rows="4" required maxlength="1000" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('anamnesa') border-red-500 @enderror" placeholder="Contoh: Anjing tidak mau makan dan muntah sejak kemarin. Kondisi lemah dan terlihat tidak bersemangat.">{{ old('anamnesa') }}</textarea>
                                    @error('anamnesa')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Keluhan utama dan riwayat penyakit (maksimal 1000 karakter)</p>
                                </div>

                                <div class="mb-4">
                                    <label for="pemeriksaan_fisik" class="block text-sm font-medium text-gray-700 mb-2">Temuan Klinis <span class="text-red-500">*</span></label>
                                    <textarea id="pemeriksaan_fisik" name="pemeriksaan_fisik" rows="4" required maxlength="1000" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('pemeriksaan_fisik') border-red-500 @enderror" placeholder="Contoh: Suhu tubuh 40°C, dehidrasi ringan, bulu kusam, mukosa pucat.">{{ old('pemeriksaan_fisik') }}</textarea>
                                    @error('pemeriksaan_fisik')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Hasil pemeriksaan fisik dan temuan klinis (maksimal 1000 karakter)</p>
                                </div>

                                <div class="mb-4">
                                    <label for="diagnosis" class="block text-sm font-medium text-gray-700 mb-2">Diagnosa <span class="text-red-500">*</span></label>
                                    <textarea id="diagnosis" name="diagnosis" rows="3" required maxlength="1000" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('diagnosis') border-red-500 @enderror" placeholder="Contoh: Gastroenteritis pada Anjing. Kemungkinan disebabkan infeksi bakteri atau konsumsi makanan yang terkontaminasi.">{{ old('diagnosis') }}</textarea>
                                    @error('diagnosis')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Diagnosis penyakit atau kondisi medis (maksimal 1000 karakter)</p>
                                </div>

                                <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-4">
                                    <div class="flex">
                                        <svg class="h-5 w-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                        <div class="text-sm text-blue-700">
                                            <p class="font-medium mb-1">Catatan Penting:</p>
                                            <ul class="list-disc list-inside space-y-1">
                                                <li>Detail tindakan/terapi akan dikelola oleh Dokter di menu Detail Rekam Medis</li>
                                                <li>Pastikan data anamnesis, temuan klinis, dan diagnosa sudah lengkap</li>
                                                <li>Rekam medis akan otomatis dikaitkan dengan appointment terbaru dari pet yang dipilih</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                                    <a href="{{ route('perawat.rekam-medis.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                        Cancel
                                    </a>
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        Save Medical Record
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
