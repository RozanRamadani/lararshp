<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <!-- Back to Dashboard Button -->
                <x-back-button href="{{ route('dashboard') }}" label="Kembali ke Dashboard" />
                
                <!-- Breadcrumb -->
                <x-breadcrumb :items="[['name' => 'Data Management']]" />
            </div>
            
            <!-- Title -->
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Data Management') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <div class="bg-gradient-to-r from-teal-500 to-blue-600 rounded-2xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold mb-2">Welcome Back, Admin! 👋</h1>
                            <p class="text-teal-100">Here's what's happening with your pet care system today.</p>
                        </div>
                        <div class="hidden md:block">
                            <div class="bg-white/20 rounded-full p-4">
                                <x-icon type="vet" size="w-12 h-12" class="text-white" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-4 bg-gradient-to-br from-teal-100 to-teal-200 rounded-xl shadow-sm">
                                <x-icon type="pet" size="w-8 h-8" class="text-teal-600" />
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="text-2xl font-bold text-gray-900">{{ $stats['jenis_hewan'] }}</h4>
                                <p class="text-sm text-gray-600">Jenis Hewan</p>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div class="bg-teal-500 h-2 rounded-full" style="width: 75%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-4 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl shadow-sm">
                                <x-icon type="cat" size="w-8 h-8" class="text-blue-600" />
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="text-2xl font-bold text-gray-900">{{ $stats['ras_hewan'] }}</h4>
                                <p class="text-sm text-gray-600">Ras Hewan</p>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: 60%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-4 bg-gradient-to-br from-green-100 to-green-200 rounded-xl shadow-sm">
                                <x-icon type="owner" size="w-8 h-8" class="text-green-600" />
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="text-2xl font-bold text-gray-900">{{ $stats['pets'] }}</h4>
                                <p class="text-sm text-gray-600">Total Pets</p>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-4 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl shadow-sm">
                                <x-icon type="vet" size="w-8 h-8" class="text-purple-600" />
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="text-2xl font-bold text-gray-900">{{ $stats['users'] }}</h4>
                                <p class="text-sm text-gray-600">Total Users</p>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div class="bg-purple-500 h-2 rounded-full" style="width: 70%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-full mb-4">
                            <x-icon type="medical" size="w-8 h-8" class="text-indigo-600" />
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">{{ $stats['kategori'] + $stats['kategori_klinis'] }}</h3>
                        <p class="text-gray-600">Medical Categories</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-full mb-4">
                            <x-icon type="clinic" size="w-8 h-8" class="text-emerald-600" />
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">{{ $stats['kode_tindakan_terapi'] }}</h3>
                        <p class="text-gray-600">Treatment Codes</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-pink-100 to-pink-200 rounded-full mb-4">
                            <x-icon type="vet" size="w-8 h-8" class="text-pink-600" />
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">{{ $stats['roles'] }}</h3>
                        <p class="text-gray-600">System Roles</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Jenis Hewan -->
                <a href="{{ route('admin.jenis-hewan.index') }}" class="group bg-white overflow-hidden shadow-lg sm:rounded-2xl hover:shadow-xl transition-all duration-300 hover:scale-105 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-teal-100 to-teal-200 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <x-icon type="pet" size="w-8 h-8" class="text-teal-600" />
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                                    {{ $stats['jenis_hewan'] }} items
                                </span>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-teal-600 transition-colors">Jenis Hewan</h3>
                        <p class="text-sm text-gray-600">Manage animal species and types</p>
                        <div class="mt-4 flex items-center text-teal-600">
                            <span class="text-sm font-medium">View Details</span>
                            <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Ras Hewan -->
                <a href="{{ route('admin.ras-hewan.index') }}" class="group bg-white overflow-hidden shadow-lg sm:rounded-2xl hover:shadow-xl transition-all duration-300 hover:scale-105 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <x-icon type="cat" size="w-8 h-8" class="text-blue-600" />
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $stats['ras_hewan'] }} items
                                </span>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">Ras Hewan</h3>
                        <p class="text-sm text-gray-600">Manage animal breeds and variations</p>
                        <div class="mt-4 flex items-center text-blue-600">
                            <span class="text-sm font-medium">View Details</span>
                            <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Kategori -->
                <a href="{{ route('admin.kategori.index') }}" class="group bg-white overflow-hidden shadow-lg sm:rounded-2xl hover:shadow-xl transition-all duration-300 hover:scale-105 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <x-icon type="medical" size="w-8 h-8" class="text-indigo-600" />
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $stats['kategori'] }} items
                                </span>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">Kategori</h3>
                        <p class="text-sm text-gray-600">Manage treatment categories</p>
                        <div class="mt-4 flex items-center text-indigo-600">
                            <span class="text-sm font-medium">View Details</span>
                            <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Kategori Klinis -->
                <a href="{{ route('admin.kategori-klinis.index') }}" class="group bg-white overflow-hidden shadow-lg sm:rounded-2xl hover:shadow-xl transition-all duration-300 hover:scale-105 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <x-icon type="clinic" size="w-8 h-8" class="text-emerald-600" />
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    {{ $stats['kategori_klinis'] }} items
                                </span>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">Kategori Klinis</h3>
                        <p class="text-sm text-gray-600">Manage clinical categories</p>
                        <div class="mt-4 flex items-center text-emerald-600">
                            <span class="text-sm font-medium">View Details</span>
                            <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Kode Tindakan Terapi -->
                <a href="{{ route('admin.kode-tindakan-terapi.index') }}" class="group bg-white overflow-hidden shadow-lg sm:rounded-2xl hover:shadow-xl transition-all duration-300 hover:scale-105 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <x-icon type="medical" size="w-8 h-8" class="text-purple-600" />
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ $stats['kode_tindakan_terapi'] }} items
                                </span>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors">Kode Tindakan</h3>
                        <p class="text-sm text-gray-600">Manage therapy action codes</p>
                        <div class="mt-4 flex items-center text-purple-600">
                            <span class="text-sm font-medium">View Details</span>
                            <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Pet -->
                <a href="{{ route('resepsionis.pet.index') }}" class="group bg-white overflow-hidden shadow-lg sm:rounded-2xl hover:shadow-xl transition-all duration-300 hover:scale-105 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-green-100 to-green-200 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <x-icon type="pet" size="w-8 h-8" class="text-green-600" />
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $stats['pets'] }} items
                                </span>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">Pet</h3>
                        <p class="text-sm text-gray-600">Manage registered pets</p>
                        <div class="mt-4 flex items-center text-green-600">
                            <span class="text-sm font-medium">View Details</span>
                            <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Role -->
                <a href="{{ route('admin.role.index') }}" class="group bg-white overflow-hidden shadow-lg sm:rounded-2xl hover:shadow-xl transition-all duration-300 hover:scale-105 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-red-100 to-red-200 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <x-icon type="vet" size="w-8 h-8" class="text-red-600" />
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    {{ $stats['roles'] }} items
                                </span>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-red-600 transition-colors">Role</h3>
                        <p class="text-sm text-gray-600">Manage system roles</p>
                        <div class="mt-4 flex items-center text-red-600">
                            <span class="text-sm font-medium">View Details</span>
                            <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- User dengan Role -->
                <a href="{{ route('admin.user.index') }}" class="group bg-white overflow-hidden shadow-lg sm:rounded-2xl hover:shadow-xl transition-all duration-300 hover:scale-105 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <x-icon type="owner" size="w-8 h-8" class="text-gray-600" />
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $stats['users'] }} items
                                </span>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-gray-600 transition-colors">User Management</h3>
                        <p class="text-sm text-gray-600">Manage users and their roles</p>
                        <div class="mt-4 flex items-center text-gray-600">
                            <span class="text-sm font-medium">View Details</span>
                            <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Floating Quick Actions -->
    <div class="fixed bottom-6 right-6 z-50">
        <div x-data="{ open: false }" class="relative">
            <!-- Main FAB Button -->
            <button @click="open = !open" class="bg-gradient-to-r from-teal-500 to-blue-600 hover:from-teal-600 hover:to-blue-700 text-white p-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110">
                <svg class="w-6 h-6" :class="{ 'rotate-45': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </button>

            <!-- Quick Action Menu -->
            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute bottom-16 right-0 w-48 bg-white rounded-lg shadow-xl border border-gray-200 py-2">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-colors">
                    <x-icon type="home" size="w-4 h-4" class="mr-3" />
                    Dashboard Utama
                </a>
                <div class="border-t border-gray-100 my-1"></div>
                <a href="{{ route('admin.jenis-hewan.create') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-colors">
                    <x-icon type="pet" size="w-4 h-4" class="mr-3" />
                    Tambah Jenis Hewan
                </a>
                <a href="{{ route('resepsionis.pet.create') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-colors">
                    <x-icon type="pet" size="w-4 h-4" class="mr-3" />
                    Tambah Pet Baru
                </a>
                <a href="{{ route('admin.user.create') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-colors">
                    <x-icon type="owner" size="w-4 h-4" class="mr-3" />
                    Tambah User Baru
                </a>
            </div>
        </div>
    </div>
</x-app-layout>