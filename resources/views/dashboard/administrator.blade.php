<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard Administrator
            </h2>
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                Administrator
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <x-breadcrumb :items="[
                    ['name' => 'Administrator Dashboard']
                ]" />
            </div>

            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-red-500 to-pink-600 overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="p-6 text-white">
                    <div class="flex items-center">
                        <div class="mr-4">
                            <div class="h-16 w-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <i class="fi fi-rr-shield-check" style="font-size: 32px;"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold mb-1">Selamat Datang, {{ Auth::user()->nama }}!</h3>
                            <p class="text-red-50">Anda masuk sebagai Administrator dengan akses penuh ke seluruh sistem.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Statistics -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">System Overview</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Total Users -->
                    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg hover:shadow-xl transition-all duration-300 border-l-4 border-indigo-500">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Total Users</p>
                                    <h4 class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</h4>
                                </div>
                                <div class="p-4 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-xl shadow-lg">
                                    <i class="fi fi-rr-users text-white" style="font-size: 32px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Roles -->
                    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg hover:shadow-xl transition-all duration-300 border-l-4 border-purple-500">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Total Roles</p>
                                    <h4 class="text-3xl font-bold text-gray-900">{{ $stats['total_roles'] }}</h4>
                                </div>
                                <div class="p-4 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl shadow-lg">
                                    <i class="fi fi-rr-shield-check text-white" style="font-size: 32px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Pemilik -->
                    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg hover:shadow-xl transition-all duration-300 border-l-4 border-teal-500">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Total Pemilik</p>
                                    <h4 class="text-3xl font-bold text-gray-900">{{ $stats['total_pemilik'] }}</h4>
                                </div>
                                <div class="p-4 bg-gradient-to-br from-teal-400 to-teal-600 rounded-xl shadow-lg">
                                    <i class="fi fi-rr-user text-white" style="font-size: 32px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Pets -->
                    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg hover:shadow-xl transition-all duration-300 border-l-4 border-blue-500">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Total Pets</p>
                                    <h4 class="text-3xl font-bold text-gray-900">{{ $stats['total_pets'] }}</h4>
                                </div>
                                <div class="p-4 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-lg">
                                    <i class="fi fi-rr-dog text-white" style="font-size: 32px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Recent Users -->
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                    <div class="p-6">
                        <h5 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fi fi-rr-users text-indigo-600 mr-2" style="font-size: 20px;"></i>
                            Recent Users
                        </h5>
                        <div class="space-y-3">
                            @forelse($recent_users as $user)
                                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $user->nama }}</p>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                    </div>
                                    <span class="text-xs text-gray-500">
                                        {{ $user->created_at ? $user->created_at->diffForHumans() : '-' }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm">No recent users</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Pemilik -->
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                    <div class="p-6">
                        <h5 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fi fi-rr-user text-teal-600 mr-2" style="font-size: 20px;"></i>
                            Recent Pemilik
                        </h5>
                        <div class="space-y-3">
                            @forelse($recent_pemilik as $pemilik)
                                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $pemilik->user->nama ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-500">{{ $pemilik->no_wa }}</p>
                                    </div>
                                    <span class="text-xs text-gray-500">
                                        {{ $pemilik->created_at ? $pemilik->created_at->diffForHumans() : '-' }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm">No recent pemilik</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6">
                    <h5 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fi fi-rr-rocket text-red-600 mr-2" style="font-size: 20px;"></i>
                        Quick Actions
                    </h5>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('admin.user.index') }}" class="group flex flex-col items-center p-6 border-2 border-indigo-200 rounded-xl bg-white hover:bg-indigo-50 hover:border-indigo-400 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                            <div class="p-3 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-xl shadow-md mb-3 group-hover:scale-110 transition-transform duration-300">
                                <i class="fi fi-rr-users text-white" style="font-size: 28px;"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 text-center group-hover:text-indigo-700">Manage Users</span>
                        </a>
                        <a href="{{ route('admin.role.index') }}" class="group flex flex-col items-center p-6 border-2 border-purple-200 rounded-xl bg-white hover:bg-purple-50 hover:border-purple-400 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                            <div class="p-3 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl shadow-md mb-3 group-hover:scale-110 transition-transform duration-300">
                                <i class="fi fi-rr-shield-check text-white" style="font-size: 28px;"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 text-center group-hover:text-purple-700">Manage Roles</span>
                        </a>
                        <a href="{{ route('admin.data.index') }}" class="group flex flex-col items-center p-6 border-2 border-teal-200 rounded-xl bg-white hover:bg-teal-50 hover:border-teal-400 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                            <div class="p-3 bg-gradient-to-br from-teal-400 to-teal-600 rounded-xl shadow-md mb-3 group-hover:scale-110 transition-transform duration-300">
                                <i class="fi fi-rr-database text-white" style="font-size: 28px;"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 text-center group-hover:text-teal-700">Data Master</span>
                        </a>
                        <a href="{{ route('resepsionis.pet.index') }}" class="group flex flex-col items-center p-6 border-2 border-blue-200 rounded-xl bg-white hover:bg-blue-50 hover:border-blue-400 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                            <div class="p-3 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-md mb-3 group-hover:scale-110 transition-transform duration-300">
                                <i class="fi fi-rr-dog text-white" style="font-size: 28px;"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 text-center group-hover:text-blue-700">Manage Pets</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
