<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $statusFilter = $request->get('status', 'all');

        $query = User::with(['roles'])->withCount('pets');

        // Apply status filter based on role status
        if ($statusFilter === 'active') {
            $query->whereHas('roles', function($q) {
                $q->wherePivot('status', 1);
            });
        } elseif ($statusFilter === 'inactive') {
            $query->whereDoesntHave('roles', function($q) {
                $q->wherePivot('status', 1);
            });
        }
        // 'all' shows everything, no additional filter needed

        $users = $query->paginate(15);

        return view('admin.user-role.index', compact('users', 'statusFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = Role::all();
        $showContactFields = Schema::hasColumn('user', 'no_wa') && Schema::hasColumn('user', 'kota');

        return view('admin.user-role.create', compact('roles', 'showContactFields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->storeValidationRules(), $this->validationMessages());

        $userData = [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ];

        // Only add contact fields if columns exist
        if (Schema::hasColumn('user', 'no_wa') && !empty($validated['no_wa'])) {
            $userData['no_wa'] = $validated['no_wa'];
        }
        if (Schema::hasColumn('user', 'kota') && !empty($validated['kota'])) {
            $userData['kota'] = $validated['kota'];
        }

        $user = User::create($userData);

        // Attach roles with active status
        if (!empty($validated['roles'])) {
            foreach ($validated['roles'] as $roleId) {
                $user->roles()->attach($roleId, ['status' => 1]);
            }
        }

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        $user->load(['roles', 'pets.rasHewan.jenisHewan', 'pemilik']);
        $showContactFields = Schema::hasColumn('user', 'no_wa') && Schema::hasColumn('user', 'kota');

        // Get all role assignments with pivot data
        $roleAssignments = RoleUser::where('iduser', $user->iduser)
            ->with('role')
            ->get();

        return view('admin.user-role.show', compact('user', 'showContactFields', 'roleAssignments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $roles = Role::all();
        $user->load('roles');
        $showContactFields = Schema::hasColumn('user', 'no_wa') && Schema::hasColumn('user', 'kota');

        return view('admin.user-role.edit', compact('user', 'roles', 'showContactFields'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate($this->updateValidationRules($user), $this->validationMessages());

        $updateData = [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        // Only update contact fields if columns exist
        if (Schema::hasColumn('user', 'no_wa')) {
            $updateData['no_wa'] = $validated['no_wa'] ?? null;
        }
        if (Schema::hasColumn('user', 'kota')) {
            $updateData['kota'] = $validated['kota'] ?? null;
        }

        $user->update($updateData);

        return redirect()
            ->route('admin.user.show', $user->iduser)
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Check if user has pets
        if ($user->pets()->exists()) {
            return redirect()
                ->route('admin.user.index')
                ->with('error', 'Tidak dapat menghapus user yang masih memiliki pets.');
        }

        // Check if user has active appointments
        $hasActiveAppointments = \App\Models\TemuDokter::whereHas('roleUser', function($q) use ($user) {
            $q->where('iduser', $user->iduser);
        })->whereIn('status', ['pending', 'confirmed'])->exists();

        if ($hasActiveAppointments) {
            return redirect()
                ->route('admin.user.index')
                ->with('error', 'Tidak dapat menghapus user yang masih memiliki appointment aktif.');
        }

        // Detach all roles
        $user->roles()->detach();

        $user->delete();

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'User berhasil dihapus.');
    }

    /**
     * Show form to manage user roles
     */
    public function manageRoles(User $user): View
    {
        $user->load('roles');
        $allRoles = Role::all();

        // Get role assignments with pivot data
        $roleAssignments = RoleUser::where('iduser', $user->iduser)
            ->with('role')
            ->get();

        return view('admin.user-role.manage-roles', compact('user', 'allRoles', 'roleAssignments'));
    }

    /**
     * Attach a role to user
     */
    public function attachRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'idrole' => 'required|exists:role,idrole',
        ]);

        // Check if role already assigned
        $exists = RoleUser::where('iduser', $user->iduser)
            ->where('idrole', $validated['idrole'])
            ->exists();

        if ($exists) {
            return redirect()
                ->route('admin.user.manage-roles', $user->iduser)
                ->with('error', 'Role sudah ditambahkan ke user ini.');
        }

        // Attach role with active status
        $user->roles()->attach($validated['idrole'], ['status' => 1]);

        return redirect()
            ->route('admin.user.manage-roles', $user->iduser)
            ->with('success', 'Role berhasil ditambahkan.');
    }

    /**
     * Update role status (activate/deactivate)
     */
    public function updateRoleStatus(Request $request, User $user, $roleUserId): RedirectResponse
    {
        $roleUser = RoleUser::where('idrole_user', $roleUserId)
            ->where('iduser', $user->iduser)
            ->firstOrFail();

        $validated = $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $roleUser->status = $validated['status'];
        $roleUser->save();

        $statusText = $validated['status'] == 1 ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->route('admin.user.manage-roles', $user->iduser)
            ->with('success', "Role berhasil {$statusText}.");
    }

    /**
     * Detach role from user
     */
    public function detachRole(User $user, $roleUserId): RedirectResponse
    {
        $roleUser = RoleUser::where('idrole_user', $roleUserId)
            ->where('iduser', $user->iduser)
            ->firstOrFail();

        // Prevent removing last role
        $roleCount = RoleUser::where('iduser', $user->iduser)->count();
        if ($roleCount <= 1) {
            return redirect()
                ->route('admin.user.manage-roles', $user->iduser)
                ->with('error', 'Tidak dapat menghapus role terakhir. User harus memiliki minimal 1 role.');
        }

        $roleUser->delete();

        return redirect()
            ->route('admin.user.manage-roles', $user->iduser)
            ->with('success', 'Role berhasil dihapus dari user.');
    }

    /**
     * Helper: pesan validasi kustom
     */
    private function validationMessages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'roles.required' => 'Role wajib dipilih minimal 1.',
        ];
    }

    /**
     * Helper: aturan validasi store
     */
    private function storeValidationRules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_wa' => 'nullable|string|max:20',
            'kota' => 'nullable|string|max:100',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:role,idrole',
        ];
    }

    /**
     * Helper: aturan validasi update
     */
    private function updateValidationRules(User $user): array
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email,' . $user->iduser . ',iduser',
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'no_wa' => 'nullable|string|max:20',
            'kota' => 'nullable|string|max:100',
        ];
    }
}
