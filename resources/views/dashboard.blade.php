<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }} - {{ Auth::user()->getPrimaryRoleName() ?? 'User' }}
            </h2>
            <div class="flex items-center space-x-2">
                @foreach(Auth::user()->getActiveRoleNames() as $role)
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        @if($role === 'Administrator') bg-red-100 text-red-800
                        @elseif($role === 'Dokter') bg-blue-100 text-blue-800
                        @elseif($role === 'Perawat') bg-green-100 text-green-800
                        @elseif($role === 'Resepsionis') bg-purple-100 text-purple-800
                        @elseif($role === 'Pemilik') bg-yellow-100 text-yellow-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ $role }}
                    </span>
                @endforeach
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">Selamat Datang, {{ Auth::user()->nama }}!</h3>
                    <p class="text-gray-600">
                        @if(Auth::user()->hasRole('Administrator'))
                            Anda masuk sebagai Administrator dengan akses penuh ke sistem.
                        @elseif(Auth::user()->hasRole('Dokter'))
                            Anda masuk sebagai Dokter. Kelola rekam medis dan diagnosis hewan.
                        @elseif(Auth::user()->hasRole('Perawat'))
                            Anda masuk sebagai Perawat. Bantu monitoring dan perawatan hewan.
                        @elseif(Auth::user()->hasRole('Resepsionis'))
                            Anda masuk sebagai Resepsionis. Kelola registrasi dan data pemilik.
                        @elseif(Auth::user()->hasRole('Pemilik'))
                            Anda masuk sebagai Pemilik. Lihat informasi hewan peliharaan Anda.
                        @else
                            Anda telah berhasil masuk ke sistem Rumah Sakit Hewan UNAIR.
                        @endif
                    </p>
                </div>
            </div>

            <!-- Stats Grid - Show based on role -->
            @if(Auth::user()->hasAnyRole(['Administrator', 'Resepsionis']))
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Total Pemilik -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transform hover:scale-105 transition-transform duration-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-br from-teal-100 to-teal-200 rounded-xl shadow-sm">
                                    <x-icon type="owner" size="w-8 h-8" class="text-teal-600" />
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ \App\Models\Pemilik::count() }}</h4>
                                    <p class="text-sm text-gray-600">Total Pemilik</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Hewan -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transform hover:scale-105 transition-transform duration-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl shadow-sm">
                                    <x-icon type="pet" size="w-8 h-8" class="text-blue-600" />
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ \App\Models\Pet::count() }}</h4>
                                    <p class="text-sm text-gray-600">Total Hewan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Hewan -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transform hover:scale-105 transition-transform duration-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-br from-green-100 to-green-200 rounded-xl shadow-sm">
                                    <x-icon type="statistics" size="w-8 h-8" class="text-green-600" />
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ \App\Models\JenisHewan::count() }}</h4>
                                    <p class="text-sm text-gray-600">Jenis Hewan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(Auth::user()->hasRole('Pemilik'))
                <!-- Stats for Pemilik -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transform hover:scale-105 transition-transform duration-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl shadow-sm">
                                    <x-icon type="pet" size="w-8 h-8" class="text-blue-600" />
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ Auth::user()->pets()->count() }}</h4>
                                    <p class="text-sm text-gray-600">Hewan Peliharaan Saya</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transform hover:scale-105 transition-transform duration-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-br from-green-100 to-green-200 rounded-xl shadow-sm">
                                    <x-icon type="calendar" size="w-8 h-8" class="text-green-600" />
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900">0</h4>
                                    <p class="text-sm text-gray-600">Appointment Mendatang</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <x-icon type="activity" size="w-6 h-6" class="mr-2 text-teal-600" />
                        Aksi Cepat
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Data Management Access -->
                        <a href="{{ route('admin.data.index') }}" class="flex items-center p-4 border-2 border-gradient-to-r from-purple-300 to-purple-400 rounded-lg bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                            <div class="p-2 bg-gradient-to-br from-purple-200 to-purple-300 rounded-lg mr-3">
                                <x-icon type="statistics" size="w-6 h-6" class="text-purple-700" />
                            </div>
                            <span class="text-sm font-semibold text-purple-800">Data Management</span>
                        </a>
                        <a href="{{ route('admin.jenis-hewan.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gradient-to-r hover:from-teal-50 hover:to-teal-100 transition-all duration-300 transform hover:scale-105 hover:shadow-md">
                            <div class="p-2 bg-gradient-to-br from-teal-100 to-teal-200 rounded-lg mr-3">
                                <x-icon type="cat" size="w-6 h-6" class="text-teal-600" />
                            </div>
                            <span class="text-sm font-medium">Kelola Jenis Hewan</span>
                        </a>
                        <a href="{{ route('resepsionis.pemilik.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 transition-all duration-300 transform hover:scale-105 hover:shadow-md">
                            <div class="p-2 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg mr-3">
                                <x-icon type="owner" size="w-6 h-6" class="text-blue-600" />
                            </div>
                            <span class="text-sm font-medium">Kelola Data Pemilik</span>
                        </a>
                        <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gradient-to-r hover:from-green-50 hover:to-green-100 transition-all duration-300 transform hover:scale-105 hover:shadow-md">
                            <div class="p-2 bg-gradient-to-br from-green-100 to-green-200 rounded-lg mr-3">
                                <x-icon type="report" size="w-6 h-6" class="text-green-600" />
                            </div>
                            <span class="text-sm font-medium">Laporan Harian</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <x-icon type="calendar" size="w-6 h-6" class="mr-2 text-teal-600" />
                        Aktivitas Terbaru
                    </h3>
                    <div class="space-y-4">
                        @php 
                            $recentPemilik = \App\Models\Pemilik::with('user')->latest('idpemilik')->take(5)->get();
                        @endphp
                        @forelse($recentPemilik as $pemilik)
                        <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 bg-gradient-to-br from-teal-100 to-teal-200 rounded-full flex items-center justify-center shadow-sm">
                                    <x-icon type="owner" size="w-6 h-6" class="text-teal-600" />
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $pemilik->user->nama ?? 'Nama tidak tersedia' }}
                                </p>
                                <p class="text-sm text-gray-500 truncate">
                                    Pemilik baru terdaftar di sistem
                                </p>
                            </div>
                            <div class="text-xs text-gray-400 bg-green-100 px-2 py-1 rounded-full">
                                Baru
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <x-icon type="activity" size="w-12 h-12" class="mx-auto mb-3 text-gray-300" />
                            <p class="text-gray-500 text-sm">Belum ada aktivitas terbaru</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
