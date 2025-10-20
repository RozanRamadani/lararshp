<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data Role') }}
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
                            <div class="p-3 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-xl shadow-sm">
                                <x-icon type="vet" size="w-8 h-8" class="text-indigo-600" />
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $roles->count() }}</h4>
                                <p class="text-sm text-gray-600">Total Role</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-br from-green-100 to-green-200 rounded-xl shadow-sm">
                                <x-icon type="owner" size="w-8 h-8" class="text-green-600" />
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $roles->sum('users_count') }}</h4>
                                <p class="text-sm text-gray-600">Total User</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl shadow-sm">
                                <x-icon type="statistics" size="w-8 h-8" class="text-purple-600" />
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $roles->where('users_count', '>', 0)->count() }}</h4>
                                <p class="text-sm text-gray-600">Role Aktif</p>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($roles as $role)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        RL{{ str_pad($role->idrole, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center">
                                                    @if(strtolower($role->nama_role) == 'admin')
                                                        <x-icon type="vet" size="w-6 h-6" class="text-indigo-600" />
                                                    @elseif(strtolower($role->nama_role) == 'owner' || strtolower($role->nama_role) == 'user')
                                                        <x-icon type="owner" size="w-6 h-6" class="text-indigo-600" />
                                                    @else
                                                        <x-icon type="vet" size="w-6 h-6" class="text-indigo-600" />
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $role->nama_role }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $role->users_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $role->users_count }} user
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $role->users_count > 0 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $role->users_count > 0 ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data role
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