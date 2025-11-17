<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <x-back-button href="{{ route('admin.perawat.index') }}" label="Kembali" />
                <x-breadcrumb :items="[
                    ['name' => 'Data Perawat', 'url' => route('admin.perawat.index')],
                    ['name' => 'Detail Perawat']
                ]" />
            </div>

            <div class="flex items-center space-x-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Detail Perawat') }}
                </h2>
                <a href="{{ route('admin.perawat.edit', $perawat->iduser) }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg transition-colors">
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Informasi Perawat</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                            <p class="mt-1 text-base text-gray-900">{{ $perawat->nama }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Email</label>
                            <p class="mt-1 text-base text-gray-900">{{ $perawat->email }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Alamat</label>
                            <p class="mt-1 text-base text-gray-900">{{ $perawat->perawat->alamat ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nomor HP</label>
                            <p class="mt-1 text-base text-gray-900">{{ $perawat->perawat->no_hp ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Pendidikan</label>
                            <p class="mt-1 text-base text-gray-900">{{ $perawat->perawat->pendidikan ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Jenis Kelamin</label>
                            <p class="mt-1 text-base text-gray-900">
                                @if($perawat->perawat)
                                    {{ $perawat->perawat->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>

                        @if(!empty($showContactFields))
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nomor WhatsApp</label>
                            <p class="mt-1 text-base text-gray-900">{{ $perawat->no_wa ?? '-' }}</p>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Status</label>
                            <p class="mt-1">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ optional($roleUser)->status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ optional($roleUser)->status == 1 ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Tanggal Bergabung</label>
                            <p class="mt-1 text-base text-gray-900">{{ optional($perawat->created_at)->format('d M Y') ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Statistik Pelayanan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <p class="text-sm text-blue-600 font-medium">Total Reservasi Ditangani</p>
                            <p class="text-2xl font-bold text-blue-900 mt-1">{{ $totalReservations }}</p>
                        </div>

                        <div class="bg-green-50 rounded-lg p-4">
                            <p class="text-sm text-green-600 font-medium">Reservasi Selesai</p>
                            <p class="text-2xl font-bold text-green-900 mt-1">{{ $completedReservations }}</p>
                        </div>

                        <div class="bg-yellow-50 rounded-lg p-4">
                            <p class="text-sm text-yellow-600 font-medium">Reservasi Pending</p>
                            <p class="text-2xl font-bold text-yellow-900 mt-1">{{ $pendingReservations }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
