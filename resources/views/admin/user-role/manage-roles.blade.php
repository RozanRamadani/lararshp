<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Role User') }}
            </h2>
            <a href="{{ route('admin.user.show', $user->iduser) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <i class="fi fi-rr-arrow-left mr-2" style="font-size: 16px;"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
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

            <!-- User Info Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="h-16 w-16 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center shadow-lg">
                            <i class="fi fi-rr-user text-blue-600" style="font-size: 36px;"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-bold text-gray-900">{{ $user->nama }}</h3>
                            <p class="text-gray-600">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left: Tambah Role Baru -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fi fi-rr-plus-circle mr-2 text-green-600"></i>
                            Tambah Role Baru
                        </h4>

                        <form action="{{ route('admin.user.attach-role', $user->iduser) }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="idrole" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pilih Role <span class="text-red-500">*</span>
                                </label>
                                <select name="idrole" id="idrole"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                    required>
                                    <option value="">-- Pilih Role --</option>
                                    @foreach($allRoles as $role)
                                        @php
                                            $alreadyAssigned = $roleAssignments->where('idrole', $role->idrole)->first();
                                        @endphp
                                        <option value="{{ $role->idrole }}" {{ $alreadyAssigned ? 'disabled' : '' }}>
                                            {{ $role->nama_role }}
                                            {{ $alreadyAssigned ? '(Sudah ditambahkan)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('idrole')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center">
                                <i class="fi fi-rr-plus mr-2" style="font-size: 16px;"></i>
                                Tambah Role
                            </button>
                        </form>

                        <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-blue-800">
                                <i class="fi fi-rr-info mr-1"></i>
                                <strong>Info:</strong> Role yang ditambahkan akan langsung aktif. User harus memiliki minimal 1 role aktif.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right: Daftar Role User -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fi fi-rr-shield-check mr-2 text-purple-600"></i>
                            Daftar Role User
                        </h4>

                        <div class="space-y-3">
                            @forelse($roleAssignments as $assignment)
                            <div class="p-4 rounded-lg border {{ $assignment->status == 1 ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $assignment->role->nama_role }}</p>
                                        <p class="text-xs {{ $assignment->status == 1 ? 'text-green-600' : 'text-gray-500' }}">
                                            <i class="fi {{ $assignment->status == 1 ? 'fi-rr-check-circle' : 'fi-rr-cross-circle' }}" style="font-size: 12px;"></i>
                                            {{ $assignment->status == 1 ? 'Aktif' : 'Nonaktif' }}
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full {{ $assignment->status == 1 ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-600' }}">
                                        ID: #{{ $assignment->idrole_user }}
                                    </span>
                                </div>

                                <div class="flex gap-2">
                                    <!-- Toggle Status -->
                                    @if($assignment->status == 1)
                                        <form action="{{ route('admin.user.update-role-status', [$user->iduser, $assignment->idrole_user]) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="0">
                                            <button type="submit" class="w-full px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-sm rounded-lg transition-colors"
                                                onclick="return confirm('Nonaktifkan role ini?')">
                                                <i class="fi fi-rr-pause-circle mr-1" style="font-size: 12px;"></i>
                                                Nonaktifkan
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.user.update-role-status', [$user->iduser, $assignment->idrole_user]) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="1">
                                            <button type="submit" class="w-full px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-sm rounded-lg transition-colors">
                                                <i class="fi fi-rr-play-circle mr-1" style="font-size: 12px;"></i>
                                                Aktifkan
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Hapus Role -->
                                    <form action="{{ route('admin.user.detach-role', [$user->iduser, $assignment->idrole_user]) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-sm rounded-lg transition-colors"
                                            onclick="return confirm('Yakin ingin menghapus role ini dari user?')">
                                            <i class="fi fi-rr-trash mr-1" style="font-size: 12px;"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <i class="fi fi-rr-interrogation text-gray-400" style="font-size: 48px;"></i>
                                <p class="mt-2 text-gray-500">User belum memiliki role</p>
                                <p class="text-sm text-gray-400">Tambahkan role menggunakan form di sebelah kiri</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-6 bg-gradient-to-r from-purple-50 to-blue-50 overflow-hidden shadow-sm sm:rounded-lg border border-purple-200">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-purple-900 mb-3 flex items-center">
                        <i class="fi fi-rr-bulb mr-2"></i>
                        Panduan Kelola Role
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-purple-800">
                        <div class="flex items-start">
                            <i class="fi fi-rr-plus-circle mt-1 mr-2 text-green-600"></i>
                            <div>
                                <strong>Tambah Role:</strong> Pilih role dari dropdown dan klik tombol "Tambah Role".
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fi fi-rr-toggle-on mt-1 mr-2 text-yellow-600"></i>
                            <div>
                                <strong>Aktif/Nonaktif:</strong> Toggle status role tanpa menghapusnya dari user.
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fi fi-rr-trash mt-1 mr-2 text-red-600"></i>
                            <div>
                                <strong>Hapus Role:</strong> Menghapus role dari user secara permanen. User harus memiliki minimal 1 role.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
