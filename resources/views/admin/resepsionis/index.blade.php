<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <x-back-button href="{{ route('dashboard') }}" label="Kembali ke Dashboard" />
                <x-breadcrumb :items="[['name' => 'Data Resepsionis']]" />
            </div>

            <div class="flex items-center space-x-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Manajemen Resepsionis') }}
                </h2>
                <a href="{{ route('admin.resepsionis.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Resepsionis
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filter Tabs -->
            <div class="mb-6">
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <a href="{{ route('admin.resepsionis.index', ['status' => 'active']) }}"
                                class="
                                    {{ request()->get('status', 'active') === 'active'
                                        ? 'border-green-500 text-green-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                    }}
                                    whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors flex items-center
                                ">
                                <i class="fi fi-rr-check-circle mr-2" style="font-size: 14px;"></i>
                                Resepsionis Aktif
                            </a>

                            <a href="{{ route('admin.resepsionis.index', ['status' => 'inactive']) }}"
                                class="
                                    {{ request()->get('status') === 'inactive'
                                        ? 'border-red-500 text-red-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                    }}
                                    whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors flex items-center
                                ">
                                <i class="fi fi-rr-cross-circle mr-2" style="font-size: 14px;"></i>
                                Nonaktif
                            </a>

                            <a href="{{ route('admin.resepsionis.index', ['status' => 'all']) }}"
                                class="
                                    {{ request()->get('status') === 'all'
                                        ? 'border-blue-500 text-blue-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                    }}
                                    whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors flex items-center
                                ">
                                <i class="fi fi-rr-list mr-2" style="font-size: 14px;"></i>
                                Semua
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Resepsionis</p>
                            <p class="text-2xl font-semibold text-gray-700">{{ $resepsionis->total() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                @if(!empty($showContactFields))
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. WA</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kota</th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($resepsionis as $receptionist)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $receptionist->nama }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $receptionist->email }}</div>
                                    </td>
                                    @if(!empty($showContactFields))
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $receptionist->no_wa ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $receptionist->kota ?? '-' }}</div>
                                    </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.resepsionis.show', $receptionist->iduser) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                        <a href="{{ route('admin.resepsionis.edit', $receptionist->iduser) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <form action="{{ route('admin.resepsionis.destroy', $receptionist->iduser) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menonaktifkan resepsionis ini?')">Nonaktifkan</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                @php($colspan = !empty($showContactFields) ? 6 : 4)
                                <tr>
                                    <td colspan="{{ $colspan }}" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data resepsionis.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $resepsionis->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
