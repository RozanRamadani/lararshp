<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <!-- Back to Data Management Button -->
                <x-back-button href="{{ route('admin.data.index') }}" label="Kembali ke Data Management" />
                
                <!-- Breadcrumb -->
                <x-breadcrumb :items="[
                    ['name' => 'Data Management', 'url' => route('admin.data.index')],
                    ['name' => 'Jenis Hewan']
                ]" />
            </div>
            
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data Jenis Hewan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-br from-teal-100 to-teal-200 rounded-xl shadow-sm">
                                <x-icon type="pet" size="w-8 h-8" class="text-teal-600" />
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $jenisHewan->count() }}</h4>
                                <p class="text-sm text-gray-600">Total Jenis Hewan</p>
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
                                <h4 class="text-lg font-semibold text-gray-900">{{ $jenisHewan->sum('pets_count') }}</h4>
                                <p class="text-sm text-gray-600">Total Pets Terdaftar</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-br from-green-100 to-green-200 rounded-xl shadow-sm">
                                <x-icon type="activity" size="w-8 h-8" class="text-green-600" />
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $jenisHewan->where('pets_count', '>', 0)->count() }}</h4>
                                <p class="text-sm text-gray-600">Jenis Aktif</p>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Jenis Hewan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Pets</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($jenisHewan as $jenis)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        JH{{ str_pad($jenis->idjenis_hewan, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-teal-100 to-teal-200 flex items-center justify-center">
                                                    <x-icon type="pet" size="w-6 h-6" class="text-teal-600" />
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $jenis->nama_jenis_hewan }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $jenis->pets_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $jenis->pets_count }} pets
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $jenis->pets_count > 0 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $jenis->pets_count > 0 ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data jenis hewan
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