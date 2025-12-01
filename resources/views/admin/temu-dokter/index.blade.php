<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <x-back-button href="{{ route('dashboard') }}" label="Kembali ke Dashboard" />
                <x-breadcrumb :items="[
                    ['name' => 'Appointment / Temu Dokter']
                ]" />
            </div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Appointment / Temu Dokter') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Actions -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <p class="text-gray-600">Kelola jadwal appointment pasien</p>
                </div>
                <a href="{{ route('resepsionis.temu-dokter.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg shadow-md transition-colors">
                    <i class="fas fa-plus mr-2"></i>Buat Appointment
                </a>
            </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Tabs for Active/Trash -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <a href="{{ route('resepsionis.temu-dokter.index') }}"
               class="@if(!request('show_trashed')) border-teal-500 text-teal-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Active Appointments
                <span class="ml-2 py-0.5 px-2 rounded-full text-xs @if(!request('show_trashed')) bg-teal-100 text-teal-600 @else bg-gray-100 text-gray-600 @endif">
                    {{ $appointments->total() }}
                </span>
            </a>
            <a href="{{ route('resepsionis.temu-dokter.index', ['show_trashed' => 1]) }}"
               class="@if(request('show_trashed')) border-red-500 text-red-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                <i class="fas fa-trash mr-1"></i> Trash
                <span class="ml-2 py-0.5 px-2 rounded-full text-xs @if(request('show_trashed')) bg-red-100 text-red-600 @else bg-gray-100 text-gray-600 @endif">
                    {{ \App\Models\TemuDokter::onlyTrashed()->count() }}
                </span>
            </a>
        </nav>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-yellow-600">Menunggu</p>
                    <p class="text-2xl font-bold text-yellow-700">{{ $menungguCount ?? 0 }}</p>
                </div>
                <div class="bg-yellow-200 p-3 rounded-full">
                    <i class="fas fa-clock text-yellow-700 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-600">Dalam Proses</p>
                    <p class="text-2xl font-bold text-blue-700">{{ $prosesCount ?? 0 }}</p>
                </div>
                <div class="bg-blue-200 p-3 rounded-full">
                    <i class="fas fa-user-md text-blue-700 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-600">Selesai</p>
                    <p class="text-2xl font-bold text-green-700">{{ $selesaiCount ?? 0 }}</p>
                </div>
                <div class="bg-green-200 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-700 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-red-600">Batal</p>
                    <p class="text-2xl font-bold text-red-700">{{ $batalCount ?? 0 }}</p>
                </div>
                <div class="bg-red-200 p-3 rounded-full">
                    <i class="fas fa-times-circle text-red-700 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointments Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Urut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Daftar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemilik</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-2xl font-bold text-teal-600">{{ $appointment->no_urut }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $appointment->waktu_daftar->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $appointment->waktu_daftar->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $appointment->pet->nama ?? 'Tidak ada nama' }}</div>
                                <div class="text-xs text-gray-500">{{ $appointment->pet->rasHewan->nama_ras ?? '-' }} ({{ $appointment->pet->rasHewan->jenisHewan->nama_jenis ?? '-' }})</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $appointment->pet->pemilik->user->nama ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $appointment->roleUser->user->nama ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($appointment->status_color == 'yellow') bg-yellow-100 text-yellow-800
                                    @elseif($appointment->status_color == 'blue') bg-blue-100 text-blue-800
                                    @elseif($appointment->status_color == 'green') bg-green-100 text-green-800
                                    @elseif($appointment->status_color == 'red') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $appointment->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                @if(request('show_trashed'))
                                    {{-- Trash Actions: Restore & Force Delete --}}
                                    <form action="{{ route('resepsionis.temu-dokter.restore', $appointment->idreservasi_dokter) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900 mx-1" title="Restore">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('resepsionis.temu-dokter.force-delete', $appointment->idreservasi_dokter) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure? This will PERMANENTLY delete this appointment!');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 mx-1" title="Delete Forever">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                @else
                                    {{-- Normal Actions --}}
                                    <a href="{{ route('resepsionis.temu-dokter.show', $appointment->idreservasi_dokter) }}" class="text-teal-600 hover:text-teal-900 mx-1" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('resepsionis.temu-dokter.edit', $appointment->idreservasi_dokter) }}" class="text-blue-600 hover:text-blue-900 mx-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('resepsionis.temu-dokter.destroy', $appointment->idreservasi_dokter) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus appointment ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 mx-1" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-calendar-times text-4xl mb-2"></i>
                                <p>Belum ada appointment</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($appointments->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>
        </div>
    </div>
</x-app-layout>
