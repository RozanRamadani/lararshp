<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data Kode Tindakan Terapi') }}
            </h2>
            <a href="{{ route('admin.data.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <x-icon type="activity" size="w-4 h-4" class="mr-2" />
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-xl shadow-sm">
                                <x-icon type="medical" size="w-8 h-8" class="text-emerald-600" />
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $kodeTindakan->count() }}</h4>
                                <p class="text-sm text-gray-600">Total Kode Tindakan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-br from-green-100 to-green-200 rounded-xl shadow-sm">
                                <x-icon type="clinic" size="w-8 h-8" class="text-green-600" />
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $kodeTindakan->where('tarif', '>', 0)->count() }}</h4>
                                <p class="text-sm text-gray-600">Dengan Tarif</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl shadow-sm">
                                <x-icon type="statistics" size="w-8 h-8" class="text-blue-600" />
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">Rp {{ number_format($kodeTindakan->avg('tarif'), 0, ',', '.') }}</h4>
                                <p class="text-sm text-gray-600">Rata-rata Tarif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tindakan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori Klinis</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($kodeTindakan as $tindakan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $tindakan->kode_tindakan }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-emerald-100 to-emerald-200 flex items-center justify-center">
                                                    <x-icon type="medical" size="w-6 h-6" class="text-emerald-600" />
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $tindakan->nama_tindakan }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $tindakan->kategori->nama_kategori ?? 'Tidak ada' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                                            {{ $tindakan->kategoriKlinis->nama_kategori_klinis ?? 'Tidak ada' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900">
                                            @if($tindakan->tarif > 0)
                                                Rp {{ number_format($tindakan->tarif, 0, ',', '.') }}
                                            @else
                                                <span class="text-gray-400">Gratis</span>
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data kode tindakan terapi
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