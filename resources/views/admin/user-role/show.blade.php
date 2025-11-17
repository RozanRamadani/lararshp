<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail User') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.user.edit', $user->iduser) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fi fi-rr-edit mr-2" style="font-size: 16px;"></i>
                    Edit
                </a>
                <a href="{{ route('admin.user.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fi fi-rr-arrow-left mr-2" style="font-size: 16px;"></i>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: User Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- User Details Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div class="h-20 w-20 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center shadow-lg">
                                    <i class="fi fi-rr-user text-blue-600" style="font-size: 48px;"></i>
                                </div>
                                <div class="ml-6">
                                    <h3 class="text-2xl font-bold text-gray-900">{{ $user->nama }}</h3>
                                    <p class="text-gray-600">{{ $user->email }}</p>
                                    <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">
                                        ID: #{{ $user->iduser }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if(!empty($showContactFields))
                                <div>
                                    <label class="text-sm font-medium text-gray-500">No. WhatsApp</label>
                                    <p class="text-gray-900">{{ $user->no_wa ?: '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Kota</label>
                                    <p class="text-gray-900">{{ $user->kota ?: '-' }}</p>
                                </div>
                                @endif
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Total Pets</label>
                                    <p class="text-gray-900">{{ $user->pets->count() }} pet</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Status Pemilik</label>
                                    <p class="text-gray-900">
                                        @if($user->pemilik)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Terdaftar sebagai Pemilik
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                Bukan Pemilik
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pets List -->
                    @if($user->pets->count() > 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fi fi-rr-paw mr-2"></i>
                                Daftar Hewan Peliharaan
                            </h4>
                            <div class="space-y-3">
                                @foreach($user->pets as $pet)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center">
                                            <i class="fi fi-rr-cat text-purple-600" style="font-size: 24px;"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="font-medium text-gray-900">{{ $pet->nama_pet }}</p>
                                            <p class="text-sm text-gray-600">
                                                {{ optional($pet->rasHewan)->nama_ras ?? 'Unknown' }} -
                                                {{ optional(optional($pet->rasHewan)->jenisHewan)->nama_jenis ?? 'Unknown' }}
                                            </p>
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-500">
                                        {{ $pet->jenis_kelamin }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column: Roles -->
                <div class="space-y-6">
                    <!-- Roles Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-semibold text-gray-900">
                                    <i class="fi fi-rr-shield-check mr-2"></i>
                                    Role User
                                </h4>
                                <a href="{{ route('admin.user.manage-roles', $user->iduser) }}"
                                    class="text-sm bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded-lg transition-colors">
                                    <i class="fi fi-rr-settings mr-1" style="font-size: 12px;"></i>
                                    Kelola
                                </a>
                            </div>

                            <div class="space-y-2">
                                @forelse($roleAssignments as $assignment)
                                <div class="p-3 rounded-lg border
                                    {{ $assignment->status == 1 ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium {{ $assignment->status == 0 ? 'text-gray-500 line-through' : 'text-gray-900' }}">
                                                {{ $assignment->role->nama_role }}
                                            </p>
                                            <p class="text-xs {{ $assignment->status == 1 ? 'text-green-600' : 'text-gray-500' }}">
                                                {{ $assignment->status == 1 ? 'Aktif' : 'Nonaktif' }}
                                            </p>
                                        </div>
                                        <div class="h-8 w-8 rounded-full flex items-center justify-center
                                            {{ $assignment->status == 1 ? 'bg-green-100' : 'bg-gray-200' }}">
                                            <i class="fi {{ $assignment->status == 1 ? 'fi-rr-check text-green-600' : 'fi-rr-cross text-gray-500' }}"
                                                style="font-size: 16px;"></i>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <p class="text-sm text-gray-500 text-center py-4">
                                    User belum memiliki role
                                </p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fi fi-rr-bolt mr-2"></i>
                                Aksi Cepat
                            </h4>
                            <div class="space-y-2">
                                <a href="{{ route('admin.user.manage-roles', $user->iduser) }}"
                                    class="flex items-center p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                                    <i class="fi fi-rr-settings text-purple-600 mr-3" style="font-size: 20px;"></i>
                                    <span class="text-purple-700 font-medium">Kelola Role</span>
                                </a>
                                <a href="{{ route('admin.user.edit', $user->iduser) }}"
                                    class="flex items-center p-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors">
                                    <i class="fi fi-rr-edit text-yellow-600 mr-3" style="font-size: 20px;"></i>
                                    <span class="text-yellow-700 font-medium">Edit Profil</span>
                                </a>
                                <form action="{{ route('admin.user.destroy', $user->iduser) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus user ini? Data tidak dapat dikembalikan!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full flex items-center p-3 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                        <i class="fi fi-rr-trash text-red-600 mr-3" style="font-size: 20px;"></i>
                                        <span class="text-red-700 font-medium">Hapus User</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
