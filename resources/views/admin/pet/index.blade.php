<x-app-layout>
            <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Data Pet') }}
                </h2>
            </div>
            <a href="{{ request()->routeIs('resepsionis.pet.*') ? route('dashboard') : route('admin.data.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <i class="fi fi-rr-chart-line mr-2" style="font-size: 16px;"></i>
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Breadcrumb -->
            <div class="mb-6">
                <x-breadcrumb :items="[
                    ['name' => 'Data Management', 'url' => route('admin.data.index')],
                    ['name' => 'Data Pet']
                ]" />
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl shadow-sm">
                                <i class="fi fi-rr-paw text-blue-600" style="font-size: 32px;"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $totalPets ?? $pets->count() }}</h4>
                                <p class="text-sm text-gray-600">Total Pet</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-br from-green-100 to-green-200 rounded-xl shadow-sm">
                                <i class="fi fi-rr-user text-green-600" style="font-size: 32px;"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $totalOwners ?? $pets->unique('iduser')->count() }}</h4>
                                <p class="text-sm text-gray-600">Total Owner</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl shadow-sm">
                                <i class="fi fi-rr-dog text-purple-600" style="font-size: 32px;"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $petJantan ?? $pets->where('jenis_kelamin', 'J')->count() }}</h4>
                                <p class="text-sm text-gray-600">Pet Jantan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-br from-pink-100 to-pink-200 rounded-xl shadow-sm">
                                <i class="fi fi-rr-cat text-pink-600" style="font-size: 32px;"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $petBetina ?? $pets->where('jenis_kelamin', 'B')->count() }}</h4>
                                <p class="text-sm text-gray-600">Pet Betina</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="mb-4 flex justify-between items-center">
                <div class="flex space-x-2">
                    @if(request()->routeIs('admin.pet.*'))
                        <a href="{{ route('admin.pet.index') }}" class="px-4 py-2 rounded-lg {{ !($showDeleted ?? false) ? 'bg-teal-600 text-white' : 'bg-white text-gray-700 border border-gray-300' }}">
                            Aktif
                        </a>
                        <a href="{{ route('admin.pet.index', ['show_deleted' => 1]) }}" class="px-4 py-2 rounded-lg {{ ($showDeleted ?? false) ? 'bg-red-600 text-white' : 'bg-white text-gray-700 border border-gray-300' }}">
                            Terhapus ({{ $deletedPets ?? 0 }})
                        </a>
                    @elseif(request()->routeIs('resepsionis.pet.*'))
                        <a href="{{ route('resepsionis.pet.index') }}" class="px-4 py-2 rounded-lg {{ !($showDeleted ?? false) ? 'bg-teal-600 text-white' : 'bg-white text-gray-700 border border-gray-300' }}">
                            Aktif
                        </a>
                        <a href="{{ route('resepsionis.pet.index', ['show_deleted' => 1]) }}" class="px-4 py-2 rounded-lg {{ ($showDeleted ?? false) ? 'bg-red-600 text-white' : 'bg-white text-gray-700 border border-gray-300' }}">
                            Terhapus ({{ $deletedPets ?? 0 }})
                        </a>
                    @endif
                </div>
                @if(! (request()->routeIs('perawat.pasien.*') || request()->is('perawat/pasien*')))
                @if(request()->routeIs('resepsionis.pet.*'))
                    <a href="{{ route('resepsionis.pet.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                        <i class="fi fi-rr-plus mr-2" style="font-size: 16px;"></i>
                        Tambah Pet
                    </a>
                @else
                    <a href="{{ route('admin.pet.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                        <i class="fi fi-rr-plus mr-2" style="font-size: 16px;"></i>
                        Tambah Pet
                    </a>
                @endif
                @endif
            </div>

            <!-- Data Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pet</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ras</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelamin</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Umur</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pets as $pet)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        PT{{ str_pad($pet->idpet, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                                    <i class="fi fi-rr-paw text-blue-600" style="font-size: 24px;"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $pet->nama_pet }}</div>
                                                <div class="text-sm text-gray-500">{{ $pet->warna ?? 'Tidak diketahui' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                                            {{ $pet->rasHewan->nama_ras ?? 'Tidak ada' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $pet->user->name ?? 'Tidak ada' }}</div>
                                        <div class="text-sm text-gray-500">{{ $pet->user->email ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pet->jenis_kelamin == 'J' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                            {{ $pet->jenis_kelamin == 'J' ? 'Jantan' : 'Betina' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($pet->tanggal_lahir)
                                            {{-- Use model helper to show years or months/days when < 1 year --}}
                                            {{ $pet->age_readable }}
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            @if(($showDeleted ?? false))
                                                {{-- Tombol Restore/Force Delete --}}
                                                @if(request()->routeIs('resepsionis.pet.*'))
                                                    <form action="{{ route('resepsionis.pet.restore', $pet->idpet) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-green-600 hover:text-green-900">Kembalikan</button>
                                                    </form>
                                                    <form action="{{ route('resepsionis.pet.force-delete', $pet->idpet) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus PERMANEN pet ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus Permanen</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.pet.restore', $pet->idpet) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-green-600 hover:text-green-900">Kembalikan</button>
                                                    </form>
                                                    <form action="{{ route('admin.pet.force-delete', $pet->idpet) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus PERMANEN pet ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus Permanen</button>
                                                    </form>
                                                @endif
                                            @else
                                                {{-- Tombol Normal --}}
                                                @if(request()->routeIs('perawat.pasien.*') || request()->is('perawat/pasien*'))
                                                    <a href="{{ route('perawat.pasien.show', $pet->idpet) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                                @elseif(request()->routeIs('resepsionis.pet.*'))
                                                    <a href="{{ route('resepsionis.pet.edit', $pet->idpet) }}" class="text-teal-600 hover:text-teal-900">Edit</a>
                                                    <a href="{{ route('resepsionis.pet.show', $pet->idpet) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                                    <form action="{{ route('resepsionis.pet.destroy', $pet->idpet) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pet ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('admin.pet.edit', $pet->idpet) }}" class="text-teal-600 hover:text-teal-900">Edit</a>
                                                    <a href="{{ route('admin.pet.show', $pet->idpet) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                                    <form action="{{ route('admin.pet.destroy', $pet->idpet) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pet ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data pet
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
