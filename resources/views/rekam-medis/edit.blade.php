<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Medical Record
            </h2>
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                Perawat
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('perawat.rekam-medis.show', $rekamMedis->idrekam_medis) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Medical Record
                </a>
            </div>

            <form action="{{ route('perawat.rekam-medis.update', $rekamMedis->idrekam_medis) }}" method="POST">
                @csrf
                @method('PUT')

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
                                            <option value="{{ $pet->idpet }}" {{ (old('idpet') ?? ($rekamMedis->temuDokter->pet->idpet ?? null)) == $pet->idpet ? 'selected' : '' }}>
                                                {{ $pet->nama }} - {{ $pet->pemilik->nama ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('idpet')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mt-4 p-4 bg-gray-50 rounded-md">
                                    <h4 class="font-medium text-gray-900 mb-2">{{ $rekamMedis->temuDokter->pet->nama ?? '-' }}</h4>
                                    <div class="space-y-1 text-sm text-gray-600">
                                        <p><strong>Species:</strong> {{ $rekamMedis->temuDokter->pet->jenis_hewan->nama_jenis ?? '-' }}</p>
                                        <p><strong>Breed:</strong> {{ $rekamMedis->temuDokter->pet->ras_hewan->nama_ras ?? '-' }}</p>
                                        <p><strong>Gender:</strong> {{ $rekamMedis->temuDokter->pet->jenis_kelamin ?? '-' }}</p>
                                        <p><strong>Owner:</strong> {{ $rekamMedis->temuDokter->pet->pemilik->nama ?? '-' }}</p>
                                    </div>
                                </div>
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
                                            <option value="{{ $dokter->iduser }}" {{ (old('iddokter') ?? ($rekamMedis->temuDokter->roleUser->iduser ?? null)) == $dokter->iduser ? 'selected' : '' }}>
                                                {{ $dokter->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('iddokter')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">Visit Date *</label>
                                    <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan') ?? ($rekamMedis->created_at?->format('Y-m-d') ?? '') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('tanggal_kunjungan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Medical Details -->
                    <div class="lg:col-span-2">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Medical Examination</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="suhu" class="block text-sm font-medium text-gray-700 mb-2">Temperature (°C)</label>
                                        <input type="number" id="suhu" name="suhu" value="{{ old('suhu') ?? $rekamMedis->suhu }}" step="0.01" min="0" max="99.99" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="38.5">
                                        @error('suhu')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">Weight (kg)</label>
                                        <input type="number" id="berat_badan" name="berat_badan" value="{{ old('berat_badan') ?? $rekamMedis->berat_badan }}" min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="5">
                                        @error('berat_badan')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="anamnesa" class="block text-sm font-medium text-gray-700 mb-2">Anamnesa / Chief Complaint</label>
                                    <textarea id="anamnesa" name="anamnesa" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Keluhan utama dan riwayat penyakit...">{{ old('anamnesa') ?? $rekamMedis->anamnesa }}</textarea>
                                    @error('anamnesa')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="pemeriksaan_fisik" class="block text-sm font-medium text-gray-700 mb-2">Physical Examination</label>
                                    <textarea id="pemeriksaan_fisik" name="pemeriksaan_fisik" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Hasil pemeriksaan fisik...">{{ old('pemeriksaan_fisik') ?? $rekamMedis->pemeriksaan_fisik }}</textarea>
                                    @error('pemeriksaan_fisik')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="diagnosis" class="block text-sm font-medium text-gray-700 mb-2">Diagnosis</label>
                                    <textarea id="diagnosis" name="diagnosis" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Diagnosis penyakit...">{{ old('diagnosis') ?? $rekamMedis->diagnosis }}</textarea>
                                    @error('diagnosis')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="tindakan" class="block text-sm font-medium text-gray-700 mb-2">Treatment / Procedure</label>
                                    <textarea id="tindakan" name="tindakan" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Tindakan medis yang dilakukan...">{{ old('tindakan') ?? $rekamMedis->tindakan }}</textarea>
                                    @error('tindakan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="resep_obat" class="block text-sm font-medium text-gray-700 mb-2">Prescription</label>
                                    <textarea id="resep_obat" name="resep_obat" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Resep obat dan dosis...">{{ old('resep_obat') ?? $rekamMedis->resep_obat }}</textarea>
                                    @error('resep_obat')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="tanggal_kontrol" class="block text-sm font-medium text-gray-700 mb-2">Follow-up Date</label>
                                    <input type="date" id="tanggal_kontrol" name="tanggal_kontrol" value="{{ old('tanggal_kontrol') ?? $rekamMedis->tanggal_kontrol?->format('Y-m-d') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('tanggal_kontrol')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                                    <textarea id="catatan" name="catatan" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Catatan tambahan...">{{ old('catatan') ?? $rekamMedis->catatan }}</textarea>
                                    @error('catatan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                                    <a href="{{ route('perawat.rekam-medis.show', $rekamMedis->idrekam_medis) }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                        Cancel
                                    </a>
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        Update Medical Record
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
