<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules;

class PerawatController extends Controller
{
    /**
     * Display a listing of perawat.
     */
    public function index(Request $request)
    {
        $perawats = \App\Models\Perawat::with(['user' => function($q) {
            $q->with(['roles' => function($qr) {
                $qr->where('nama_role', 'Perawat');
            }]);
            $q->whereHas('roles', function($qh) {
                $qh->where('nama_role', 'Perawat');
            });
        }])->paginate(15);

        $showContactFields = Schema::hasColumn('user', 'no_wa');
        return view('admin.perawat.index', compact('perawats', 'showContactFields'));
    }

    /**
     * Show the form for creating a new perawat.
     */
    public function create()
    {
        // Get users with Perawat role who don't have perawat profile yet
        $users = User::whereHas('roles', function($q) {
            $q->where('nama_role', 'Perawat')
              ->where('role_user.status', 1);
        })->whereDoesntHave('perawat')
        ->get();

        return view('admin.perawat.create', compact('users'));
    }

    /**
     * Store a newly created perawat in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => ['required', 'exists:user,iduser'],
            'alamat' => ['required', 'string', 'max:100'],
            'no_hp' => ['required', 'string', 'max:45'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'pendidikan' => ['required', 'string', 'max:100'],
        ]);

        try {
            DB::beginTransaction();

            // Check if user already has perawat profile
            $existingPerawat = \App\Models\Perawat::where('id_user', $validated['id_user'])->first();
            if ($existingPerawat) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'User ini sudah memiliki profil perawat.');
            }

            // Create perawat profile
            \App\Models\Perawat::create([
                'id_user' => $validated['id_user'],
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'pendidikan' => $validated['pendidikan'],
            ]);

            DB::commit();

            return redirect()->route('admin.perawat.index')
                ->with('success', 'Profil perawat berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified perawat.
     */
    public function show(User $perawat)
    {
        $perawat->load(['roles', 'pemilik']);

        // Verify this user is actually a perawat
        if (!$perawat->hasRole('Perawat')) {
            abort(404);
        }

        // Get RoleUser pivot record for this perawat (to read status)
        $perawatRole = Role::where('nama_role', 'Perawat')->first();
        $roleUser = null;
        if ($perawatRole) {
            $roleUser = RoleUser::where('iduser', $perawat->iduser)
                        ->where('idrole', $perawatRole->idrole)
                        ->first();
        }

        // Compute reservation statistics for this perawat (guard when no pivot found)
        $totalReservations = 0;
        $completedReservations = 0;
        $pendingReservations = 0;
        if ($roleUser && !empty($roleUser->idrole_user)) {
            $totalReservations = \App\Models\TemuDokter::where('idrole_user', $roleUser->idrole_user)->count();
            $completedReservations = \App\Models\TemuDokter::where('idrole_user', $roleUser->idrole_user)
                                    ->where('status', \App\Models\TemuDokter::STATUS_SELESAI)->count();
            $pendingReservations = \App\Models\TemuDokter::where('idrole_user', $roleUser->idrole_user)
                                    ->whereIn('status', [\App\Models\TemuDokter::STATUS_MENUNGGU, \App\Models\TemuDokter::STATUS_DALAM_PROSES])->count();
        }

        $showContactFields = Schema::hasColumn('user', 'no_wa');
        return view('admin.perawat.show', compact('perawat', 'roleUser', 'totalReservations', 'completedReservations', 'pendingReservations', 'showContactFields'));
    }

    /**
     * Show the form for editing the specified perawat.
     */
    public function edit(User $perawat)
    {
        // Verify this user is actually a perawat
        if (!$perawat->hasRole('Perawat')) {
            abort(404);
        }

        // Load perawat profile
        $perawat->load('perawat');

        // Get roleUser for status
        $perawatRole = Role::where('nama_role', 'Perawat')->first();
        $roleUser = null;
        if ($perawatRole) {
            $roleUser = RoleUser::where('iduser', $perawat->iduser)
                        ->where('idrole', $perawatRole->idrole)
                        ->first();
        }

        $showContactFields = Schema::hasColumn('user', 'no_wa');
        return view('admin.perawat.edit', compact('perawat', 'roleUser', 'showContactFields'));
    }

    /**
     * Update the specified perawat in storage.
     */
    public function update(Request $request, User $perawat)
    {
        // Verify this user is actually a perawat
        if (!$perawat->hasRole('Perawat')) {
            abort(404);
        }

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:500'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:user,email,' . $perawat->iduser . ',iduser'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'no_wa' => ['nullable', 'string', 'max:20'],
            'alamat' => ['required', 'string', 'max:100'],
            'no_hp' => ['required', 'string', 'max:45'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'pendidikan' => ['required', 'string', 'max:100'],
            'status' => ['required', 'boolean'],
        ]);

        try {
            DB::beginTransaction();

            // Update user data
            $updateData = [
                'nama' => $validated['nama'],
                'email' => $validated['email'],
            ];
            if (Schema::hasColumn('user', 'no_wa')) {
                $updateData['no_wa'] = $validated['no_wa'] ?? null;
            }

            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            $perawat->update($updateData);

            // Update perawat profile
            \App\Models\Perawat::updateOrCreate(
                ['id_user' => $perawat->iduser],
                [
                    'alamat' => $validated['alamat'],
                    'no_hp' => $validated['no_hp'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                    'pendidikan' => $validated['pendidikan'],
                ]
            );

            // Update role status
            $perawatRole = Role::where('nama_role', 'Perawat')->firstOrFail();
            RoleUser::where('iduser', $perawat->iduser)
                ->where('idrole', $perawatRole->idrole)
                ->update(['status' => $validated['status']]);

            DB::commit();

            return redirect()->route('admin.perawat.index')
                ->with('success', 'Data perawat berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified perawat from storage.
     */
    public function destroy(User $perawat)
    {
        // Verify this user is actually a perawat
        if (!$perawat->hasRole('Perawat')) {
            abort(404);
        }

        try {
            DB::beginTransaction();

            // Delete perawat profile from perawat table
            \App\Models\Perawat::where('id_user', $perawat->iduser)->delete();

            DB::commit();

            return redirect()->route('admin.perawat.index')
                ->with('success', 'Data perawat berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
