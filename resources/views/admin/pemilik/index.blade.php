<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <!-- Back to Dashboard Button -->
                <x-back-button href="{{ route('dashboard') }}" label="Kembali ke Dashboard" />

                <!-- Breadcrumb -->
                <x-breadcrumb :items="[
                    ['name' => 'Data Pemilik']
                ]" />
            </div>

            <div class="flex items-center space-x-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Data Pemilik Hewan') }}
                </h2>
                @unless(request()->routeIs('resepsionis.pemilik.*'))
                <a href="{{ route('admin.pemilik.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Pemilik
                </a>
                @endunless
            </div>
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

            <!-- Search and Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <input type="text" placeholder="Cari nama pemilik..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="sm:w-48">
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                <option value="">Semua Kota</option>
                                <option value="surabaya">Surabaya</option>
                                <option value="sidoarjo">Sidoarjo</option>
                                <option value="gresik">Gresik</option>
                                <option value="malang">Malang</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="sm:w-48">
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                <option value="">Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="tidak_aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-2 bg-teal-100 rounded-lg">
                                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $totalPemilik }}</h4>
                                <p class="text-sm text-gray-600">Total Pemilik</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $aktivePemilik }}</h4>
                                <p class="text-sm text-gray-600">Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-2 bg-red-100 rounded-lg">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $deletedPemilik ?? 0 }}</h4>
                                <p class="text-sm text-gray-600">Terhapus</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $totalPets }}</h4>
                                <p class="text-sm text-gray-600">Total Hewan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="mb-4 flex justify-between items-center">
                <div class="flex space-x-2">
                    @if(request()->routeIs('admin.pemilik.*'))
                        <a href="{{ route('admin.pemilik.index') }}" class="px-4 py-2 rounded-lg {{ !$showDeleted ? 'bg-teal-600 text-white' : 'bg-white text-gray-700 border border-gray-300' }}">
                            Aktif
                        </a>
                        <a href="{{ route('admin.pemilik.index', ['show_deleted' => 1]) }}" class="px-4 py-2 rounded-lg {{ $showDeleted ? 'bg-red-600 text-white' : 'bg-white text-gray-700 border border-gray-300' }}">
                            Terhapus ({{ $deletedPemilik ?? 0 }})
                        </a>
                    @else
                        <a href="{{ route('resepsionis.pemilik.index') }}" class="px-4 py-2 rounded-lg {{ !$showDeleted ? 'bg-teal-600 text-white' : 'bg-white text-gray-700 border border-gray-300' }}">
                            Aktif
                        </a>
                        <a href="{{ route('resepsionis.pemilik.index', ['show_deleted' => 1]) }}" class="px-4 py-2 rounded-lg {{ $showDeleted ? 'bg-red-600 text-white' : 'bg-white text-gray-700 border border-gray-300' }}">
                            Terhapus ({{ $deletedPemilik ?? 0 }})
                        </a>
                    @endif
                </div>
                @if(request()->routeIs('resepsionis.pemilik.*'))
                <a href="{{ route('resepsionis.pemilik.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Pemilik
                </a>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemilik</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hewan Peliharaan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pemilik as $index => $owner)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">P{{ str_pad($owner->idpemilik, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full {{ ['bg-teal-100', 'bg-blue-100', 'bg-green-100', 'bg-yellow-100', 'bg-purple-100'][$index % 5] }} flex items-center justify-center">
                                                    <span class="text-sm font-medium {{ ['text-teal-600', 'text-blue-600', 'text-green-600', 'text-yellow-600', 'text-purple-600'][$index % 5] }}">
                                                        {{ strtoupper(substr($owner->user->nama ?? 'U', 0, 2)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $owner->user->nama ?? 'Nama tidak tersedia' }}</div>
                                                <div class="text-sm text-gray-500">Member sejak {{ \Carbon\Carbon::parse('2024-01-01')->addDays($index * 15)->format('d M Y') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $owner->no_wa ?? 'Tidak tersedia' }}</div>
                                        <div class="text-sm text-gray-500">{{ $owner->user->email ?? 'email@tidak.tersedia' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $owner->alamat ?? 'Alamat tidak tersedia' }}</div>
                                        <div class="text-sm text-gray-500">Jawa Timur, Indonesia</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col space-y-1">
                                            @forelse($owner->pets as $pet)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ ['bg-blue-100 text-blue-800', 'bg-green-100 text-green-800', 'bg-yellow-100 text-yellow-800', 'bg-purple-100 text-purple-800'][$loop->index % 4] }}">
                                                    {{ $pet->nama }} ({{ $pet->rasHewan->jenisHewan->nama_jenis_hewan ?? 'Unknown' }})
                                                </span>
                                            @empty
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    Belum ada hewan
                                                </span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($showDeleted)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Terhapus
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            @if($showDeleted)
                                                {{-- Tombol Restore --}}
                                                @if(request()->routeIs('resepsionis.pemilik.*'))
                                                    <form action="{{ route('resepsionis.pemilik.restore', $owner->idpemilik) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-green-600 hover:text-green-900">Kembalikan</button>
                                                    </form>
                                                    <form action="{{ route('resepsionis.pemilik.force-delete', $owner->idpemilik) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus PERMANEN pemilik ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus Permanen</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.pemilik.restore', $owner->idpemilik) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-green-600 hover:text-green-900">Kembalikan</button>
                                                    </form>
                                                    <form action="{{ route('admin.pemilik.force-delete', $owner->idpemilik) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus PERMANEN pemilik ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus Permanen</button>
                                                    </form>
                                                @endif
                                            @else
                                                {{-- Tombol Normal --}}
                                                @if(request()->routeIs('resepsionis.pemilik.*'))
                                                    <a href="{{ route('resepsionis.pemilik.edit', $owner->idpemilik) }}" class="text-teal-600 hover:text-teal-900">Edit</a>
                                                    <a href="{{ route('resepsionis.pemilik.show', $owner->idpemilik) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                                    <a href="{{ route('resepsionis.pet.index', ['owner_id' => $owner->idpemilik]) }}" class="text-purple-600 hover:text-purple-900">Hewan</a>
                                                    <form action="{{ route('resepsionis.pemilik.destroy', $owner->idpemilik) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pemilik ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('admin.pemilik.edit', $owner->idpemilik) }}" class="text-teal-600 hover:text-teal-900">Edit</a>
                                                    <a href="{{ route('admin.pemilik.show', $owner->idpemilik) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                                    <a href="{{ route('admin.pet.index', ['owner_id' => $owner->idpemilik]) }}" class="text-purple-600 hover:text-purple-900">Hewan</a>
                                                    <form action="{{ route('admin.pemilik.destroy', $owner->idpemilik) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pemilik ini?')">
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
                                        Tidak ada data pemilik
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center text-sm text-gray-700">
                            Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">{{ $pemilik->count() }}</span> dari <span class="font-medium">{{ $totalPemilik }}</span> data
                        </div>
                        @if($totalPemilik > 10)
                        <div class="flex items-center space-x-2">
                            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-500 hover:bg-gray-50">Previous</button>
                            <button class="px-3 py-1 bg-teal-600 text-white rounded-md text-sm">1</button>
                            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">Next</button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
