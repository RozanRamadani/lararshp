<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Medical Records
            </h2>
            @if(auth()->user()->hasAnyRole(['Administrator', 'Perawat']))
                <a href="{{ route('perawat.rekam-medis.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add New Record
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Filter Section -->
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <input type="text" placeholder="Search by pet name..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Status</option>
                                <option value="menunggu">Menunggu</option>
                                <option value="dalam_perawatan">Dalam Perawatan</option>
                                <option value="selesai">Selesai</option>
                                <option value="rujukan">Rujukan</option>
                            </select>
                        </div>
                        <div>
                            <input type="date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Records Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet / Owner</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosis</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nurse</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($rekamMedis as $record)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $record->tanggal_kunjungan->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $record->pet->nama ?? '-' }}</div>
                                            <div class="text-sm text-gray-500">{{ $record->pet->pemilik->nama ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">{{ Str::limit($record->diagnosis ?? '-', 50) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $record->dokter->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $record->perawat->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($record->status_color == 'yellow') bg-yellow-100 text-yellow-800
                                                @elseif($record->status_color == 'blue') bg-blue-100 text-blue-800
                                                @elseif($record->status_color == 'green') bg-green-100 text-green-800
                                                @elseif($record->status_color == 'red') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ $record->status_label }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                @if(auth()->user()->hasRole('Dokter'))
                                                    <a href="{{ route('dokter.rekam-medis.show', $record->idrekam_medis) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                                @else
                                                    <a href="{{ route('perawat.rekam-medis.show', $record->idrekam_medis) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                                    @if(auth()->user()->hasAnyRole(['Administrator', 'Perawat']))
                                                        <a href="{{ route('perawat.rekam-medis.edit', $record->idrekam_medis) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                                        <form action="{{ route('perawat.rekam-medis.destroy', $record->idrekam_medis) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            No medical records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $rekamMedis->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
