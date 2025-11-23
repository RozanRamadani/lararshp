<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard - {{ Auth::user()->getPrimaryRoleName() ?? 'User' }}
            </h2>
            <div class="flex items-center space-x-2">
                @foreach(Auth::user()->getActiveRoleNames() as $role)
                    @php
                        $badgeClasses = match($role) {
                            'Administrator' => 'bg-red-100 text-red-800 border border-red-200',
                            'Dokter' => 'bg-blue-100 text-blue-800 border border-blue-200',
                            'Perawat' => 'bg-green-100 text-green-800 border border-green-200',
                            'Resepsionis' => 'bg-purple-100 text-purple-800 border border-purple-200',
                            'Pemilik' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                            default => 'bg-gray-100 text-gray-800 border border-gray-200',
                        };
                    @endphp
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $badgeClasses }}">
                        {{ $role }}
                    </span>
                @endforeach
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <x-breadcrumb :items="[
                    ['name' => 'Dashboard']
                ]" />
            </div>

            <!-- Welcome Card with Icon -->
            <div class="bg-gradient-to-r from-teal-500 to-cyan-600 overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="p-6 text-white">
                    <div class="flex items-center">
                        <div class="mr-4">
                            <div class="h-16 w-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                @if(Auth::user()->hasRole('Administrator'))
                                    <i class="fi fi-rr-shield-check" style="font-size: 32px;"></i>
                                @elseif(Auth::user()->hasRole('Dokter'))
                                    <i class="fi fi-rr-user-md" style="font-size: 32px;"></i>
                                @elseif(Auth::user()->hasRole('Perawat'))
                                    <i class="fi fi-rr-medkit" style="font-size: 32px;"></i>
                                @elseif(Auth::user()->hasRole('Resepsionis'))
                                    <i class="fi fi-rr-headset" style="font-size: 32px;"></i>
                                @elseif(Auth::user()->hasRole('Pemilik'))
                                    <i class="fi fi-rr-heart" style="font-size: 32px;"></i>
                                @else
                                    <i class="fi fi-rr-user" style="font-size: 32px;"></i>
                                @endif
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold mb-1">Selamat Datang, {{ Auth::user()->nama }}!</h3>
                            <p class="text-teal-50">
                                @if(Auth::user()->hasRole('Administrator'))
                                    Anda masuk sebagai Administrator dengan akses penuh ke sistem.
                                @elseif(Auth::user()->hasRole('Dokter'))
                                    Kelola rekam medis dan diagnosis hewan dengan profesional.
                                @elseif(Auth::user()->hasRole('Perawat'))
                                    Bantu monitoring dan perawatan hewan dengan teliti.
                                @elseif(Auth::user()->hasRole('Resepsionis'))
                                    Kelola registrasi dan data pemilik dengan efisien.
                                @elseif(Auth::user()->hasRole('Pemilik'))
                                    Pantau informasi kesehatan hewan peliharaan Anda.
                                @else
                                    Sistem Informasi Rumah Sakit Hewan UNAIR.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid - Show based on role -->
            @if(Auth::user()->hasAnyRole(['Administrator', 'Resepsionis']))
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Total Pemilik -->
                    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg hover:shadow-xl transition-all duration-300 border-l-4 border-teal-500">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Total Pemilik</p>
                                    <h4 class="text-3xl font-bold text-gray-900">{{ \App\Models\Pemilik::count() }}</h4>
                                </div>
                                <div class="p-4 bg-gradient-to-br from-teal-400 to-teal-600 rounded-xl shadow-lg">
                                    <i class="fi fi-rr-users text-white" style="font-size: 32px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Hewan -->
                    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg hover:shadow-xl transition-all duration-300 border-l-4 border-blue-500">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Total Hewan</p>
                                    <h4 class="text-3xl font-bold text-gray-900">{{ \App\Models\Pet::count() }}</h4>
                                </div>
                                <div class="p-4 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-lg">
                                    <i class="fi fi-rr-dog text-white" style="font-size: 32px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Hewan -->
                    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg hover:shadow-xl transition-all duration-300 border-l-4 border-green-500">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Jenis Hewan</p>
                                    <h4 class="text-3xl font-bold text-gray-900">{{ \App\Models\JenisHewan::count() }}</h4>
                                </div>
                                <div class="p-4 bg-gradient-to-br from-green-400 to-green-600 rounded-xl shadow-lg">
                                    <i class="fi fi-rr-paw text-white" style="font-size: 32px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(Auth::user()->hasRole('Pemilik'))
                <!-- Stats for Pemilik -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg hover:shadow-xl transition-all duration-300 border-l-4 border-blue-500">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Hewan Peliharaan Saya</p>
                                    <h4 class="text-3xl font-bold text-gray-900">{{ Auth::user()->pets()->count() }}</h4>
                                </div>
                                <div class="p-4 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-lg">
                                    <i class="fi fi-rr-dog text-white" style="font-size: 32px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg hover:shadow-xl transition-all duration-300 border-l-4 border-green-500">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Appointment Mendatang</p>
                                    <h4 class="text-3xl font-bold text-gray-900">0</h4>
                                </div>
                                <div class="p-4 bg-gradient-to-br from-green-400 to-green-600 rounded-xl shadow-lg">
                                    <i class="fi fi-rr-calendar-check text-white" style="font-size: 32px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center text-gray-800">
                        <i class="fi fi-rr-rocket text-teal-600 mr-2" style="font-size: 24px;"></i>
                        Aksi Cepat
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Data Management Access -->
                        <a href="{{ route('admin.data.index') }}" class="group flex flex-col items-center p-6 border-2 border-purple-200 rounded-xl bg-white hover:bg-purple-50 hover:border-purple-400 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                            <div class="p-3 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl shadow-md mb-3 group-hover:scale-110 transition-transform duration-300">
                                <i class="fi fi-rr-database text-white" style="font-size: 28px;"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 text-center group-hover:text-purple-700">Data Management</span>
                        </a>

                        <!-- Jenis Hewan -->
                        <a href="{{ route('admin.jenis-hewan.index') }}" class="group flex flex-col items-center p-6 border-2 border-teal-200 rounded-xl bg-white hover:bg-teal-50 hover:border-teal-400 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                            <div class="p-3 bg-gradient-to-br from-teal-400 to-teal-600 rounded-xl shadow-md mb-3 group-hover:scale-110 transition-transform duration-300">
                                <i class="fi fi-rr-cat text-white" style="font-size: 28px;"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 text-center group-hover:text-teal-700">Jenis Hewan</span>
                        </a>

                        <!-- Data Pemilik -->
                        <a href="{{ route('resepsionis.pemilik.index') }}" class="group flex flex-col items-center p-6 border-2 border-blue-200 rounded-xl bg-white hover:bg-blue-50 hover:border-blue-400 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                            <div class="p-3 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-md mb-3 group-hover:scale-110 transition-transform duration-300">
                                <i class="fi fi-rr-users text-white" style="font-size: 28px;"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 text-center group-hover:text-blue-700">Data Pemilik</span>
                        </a>

                        <!-- Laporan -->
                        <a href="#" class="group flex flex-col items-center p-6 border-2 border-green-200 rounded-xl bg-white hover:bg-green-50 hover:border-green-400 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                            <div class="p-3 bg-gradient-to-br from-green-400 to-green-600 rounded-xl shadow-md mb-3 group-hover:scale-110 transition-transform duration-300">
                                <i class="fi fi-rr-chart-histogram text-white" style="font-size: 28px;"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 text-center group-hover:text-green-700">Laporan</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center text-gray-800">
                        <i class="fi fi-rr-time-past text-teal-600 mr-2" style="font-size: 24px;"></i>
                        Aktivitas Terbaru
                    </h3>
                    <div class="space-y-3">
                        @php
                            $recentPemilik = \App\Models\Pemilik::with('user')->latest('idpemilik')->take(5)->get();
                        @endphp
                        @forelse($recentPemilik as $pemilik)
                        <div class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gradient-to-r hover:from-teal-50 hover:to-cyan-50 transition-all duration-200 border border-gray-100">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 bg-gradient-to-br from-teal-400 to-teal-600 rounded-full flex items-center justify-center shadow-md">
                                    <i class="fi fi-rr-user text-white" style="font-size: 20px;"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">
                                    {{ $pemilik->user->nama ?? 'Nama tidak tersedia' }}
                                </p>
                                <p class="text-xs text-gray-500 truncate mt-1">
                                    <i class="fi fi-rr-check-circle text-green-500 mr-1"></i>
                                    Pemilik baru terdaftar di sistem
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="text-xs font-semibold text-green-700 bg-green-100 px-3 py-1 rounded-full border border-green-200">
                                    Baru
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center h-20 w-20 bg-gray-100 rounded-full mb-4">
                                <i class="fi fi-rr-inbox text-gray-400" style="font-size: 40px;"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Belum ada aktivitas terbaru</p>
                            <p class="text-gray-400 text-sm mt-1">Aktivitas akan muncul di sini</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
