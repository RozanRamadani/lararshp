<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen User & Role') }}
            </h2>
            <a href="{{ route('admin.data.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <i class="fi fi-rr-chart-line mr-2" style="font-size: 16px;"></i>
                Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <x-breadcrumb :items="[
                    ['name' => 'Data Management', 'url' => route('admin.data.index')],
                    ['name' => 'User & Role Management']
                ]" />
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl shadow-sm">
                                <i class="fi fi-rr-user text-blue-600" style="font-size: 32px;"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $users->total() }}</h4>
                                <p class="text-sm text-gray-600">Total User</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-br from-green-100 to-green-200 rounded-xl shadow-sm">
                                <i class="fi fi-rr-shield-check text-green-600" style="font-size: 32px;"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $users->filter(function($user) { return $user->roles->contains('nama_role', 'Administrator'); })->count() }}</h4>
                                <p class="text-sm text-gray-600">Admin</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl shadow-sm">
                                <i class="fi fi-rr-stethoscope text-purple-600" style="font-size: 32px;"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $users->filter(function($user) { return $user->roles->whereIn('nama_role', ['Dokter', 'Perawat', 'Resepsionis'])->isNotEmpty(); })->count() }}</h4>
                                <p class="text-sm text-gray-600">Staff</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-xl shadow-sm">
                                <i class="fi fi-rr-paw text-yellow-600" style="font-size: 32px;"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $users->filter(function($user) { return $user->roles->contains('nama_role', 'Pemilik'); })->count() }}</h4>
                                <p class="text-sm text-gray-600">Pemilik</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header with Add Button -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Daftar User</h3>
                        <a href="{{ route('admin.user.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                            <i class="fi fi-rr-plus mr-2" style="font-size: 16px;"></i>
                            Tambah User
                        </a>
                    </div>

                    <!-- Filter Tabs -->
                    <div class="mb-6">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                <a href="{{ route('admin.user.index', ['status' => 'all']) }}"
                                    class="
                                        {{ request()->get('status', 'all') === 'all'
                                            ? 'border-blue-500 text-blue-600'
                                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                        }}
                                        whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors flex items-center
                                    ">
                                    <i class="fi fi-rr-list mr-2" style="font-size: 14px;"></i>
                                    Semua User
                                    <span class="ml-2 py-0.5 px-2 rounded-full text-xs font-semibold
                                        {{ request()->get('status', 'all') === 'all' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $users->total() }}
                                    </span>
                                </a>

                                <a href="{{ route('admin.user.index', ['status' => 'active']) }}"
                                    class="
                                        {{ request()->get('status') === 'active'
                                            ? 'border-green-500 text-green-600'
                                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                        }}
                                        whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors flex items-center
                                    ">
                                    <i class="fi fi-rr-check-circle mr-2" style="font-size: 14px;"></i>
                                    Aktif
                                    @if(request()->get('status') === 'active')
                                        <span class="ml-2 py-0.5 px-2 rounded-full text-xs font-semibold bg-green-100 text-green-600">
                                            {{ $users->total() }}
                                        </span>
                                    @endif
                                </a>

                                <a href="{{ route('admin.user.index', ['status' => 'inactive']) }}"
                                    class="
                                        {{ request()->get('status') === 'inactive'
                                            ? 'border-red-500 text-red-600'
                                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                        }}
                                        whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors flex items-center
                                    ">
                                    <i class="fi fi-rr-cross-circle mr-2" style="font-size: 14px;"></i>
                                    Nonaktif
                                    @if(request()->get('status') === 'inactive')
                                        <span class="ml-2 py-0.5 px-2 rounded-full text-xs font-semibold bg-red-100 text-red-600">
                                            {{ $users->total() }}
                                        </span>
                                    @endif
                                </a>
                            </nav>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roles</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pets</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #{{ $user->iduser }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                                    <i class="fi fi-rr-user text-blue-600" style="font-size: 24px;"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->nama }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse($user->roles as $role)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($role->pivot->status == 0) bg-gray-200 text-gray-500 line-through
                                                    @elseif(stripos($role->nama_role, 'admin') !== false) bg-red-100 text-red-800
                                                    @elseif(stripos($role->nama_role, 'dokter') !== false) bg-purple-100 text-purple-800
                                                    @elseif(stripos($role->nama_role, 'perawat') !== false) bg-blue-100 text-blue-800
                                                    @elseif(stripos($role->nama_role, 'resepsionis') !== false) bg-green-100 text-green-800
                                                    @elseif(stripos($role->nama_role, 'pemilik') !== false) bg-yellow-100 text-yellow-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    {{ $role->nama_role }}
                                                    @if($role->pivot->status == 0)
                                                        <span class="ml-1">(Nonaktif)</span>
                                                    @endif
                                                </span>
                                            @empty
                                                <span class="text-gray-400 text-sm">Tidak ada role</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->pets_count > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $user->pets_count }} pet
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.user.show', $user->iduser) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                                                <i class="fi fi-rr-eye" style="font-size: 18px;"></i>
                                            </a>
                                            <a href="{{ route('admin.user.manage-roles', $user->iduser) }}" class="text-purple-600 hover:text-purple-900" title="Kelola Role">
                                                <i class="fi fi-rr-settings" style="font-size: 18px;"></i>
                                            </a>
                                            <a href="{{ route('admin.user.edit', $user->iduser) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                                <i class="fi fi-rr-edit" style="font-size: 18px;"></i>
                                            </a>
                                            <form action="{{ route('admin.user.destroy', $user->iduser) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                    <i class="fi fi-rr-trash" style="font-size: 18px;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data user
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
