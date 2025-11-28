<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\TemuDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules;

class DokterController extends Controller
{
    /**
     * Display a listing of dokter.
     */
    public function index(Request $request)
    {
        $dokters = \App\Models\Dokter::with(['user' => function($q) {
            $q->with(['roles' => function($qr) {
                $qr->where('nama_role', 'Dokter');
            }]);
            $q->whereHas('roles', function($qh) {
                $qh->where('nama_role', 'Dokter');
            });
        }])->paginate(15);

        $showContactFields = Schema::hasColumn('user', 'no_wa');
        return view('admin.dokter.index', compact('dokters', 'showContactFields'));
    }

    /**
     * Show the form for creating a new dokter.
     */
    public function create()
    {
        // Get users with Dokter role who don't have dokter profile yet
        $users = User::whereHas('roles', function($q) {
            $q->where('nama_role', 'Dokter')
              ->where('role_user.status', 1);
        })->whereDoesntHave('dokter')
        ->get();

        return view('admin.dokter.create', compact('users'));
    }

    /**
     * Store a newly created dokter in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => ['required', 'exists:user,iduser'],
            'alamat' => ['required', 'string', 'max:100'],
            'no_hp' => ['required', 'string', 'max:45'],
            'bidang_dokter' => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['required', 'in:L,P'],
        ]);

        try {
            DB::beginTransaction();

            // Check if user already has dokter profile
            $existingDokter = \App\Models\Dokter::where('id_user', $validated['id_user'])->first();
            if ($existingDokter) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'User ini sudah memiliki profil dokter.');
            }

            // Create dokter profile
            \App\Models\Dokter::create([
                'id_user' => $validated['id_user'],
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'],
                'bidang_dokter' => $validated['bidang_dokter'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
            ]);

            DB::commit();

            return redirect()->route('admin.dokter.index')
                ->with('success', 'Profil dokter berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified dokter.
     */
    public function show(User $dokter)
    {
        $dokter->load(['roles', 'pemilik']);

        // Verify this user is actually a dokter
        if (!$dokter->hasRole('Dokter')) {
            abort(404);
        }

        // Get RoleUser pivot record for this dokter (to read status)
        $dokterRole = Role::where('nama_role', 'Dokter')->first();
        $roleUser = null;
        if ($dokterRole) {
            $roleUser = RoleUser::where('iduser', $dokter->iduser)
                        ->where('idrole', $dokterRole->idrole)
                        ->first();
        }

        // Compute reservation statistics for this dokter (guard when no pivot found)
        $totalReservations = 0;
        $completedReservations = 0;
        $pendingReservations = 0;
        if ($roleUser && !empty($roleUser->idrole_user)) {
            $totalReservations = TemuDokter::where('idrole_user', $roleUser->idrole_user)->count();
            $completedReservations = TemuDokter::where('idrole_user', $roleUser->idrole_user)
                                    ->where('status', TemuDokter::STATUS_SELESAI)->count();
            $pendingReservations = TemuDokter::where('idrole_user', $roleUser->idrole_user)
                                    ->whereIn('status', [
                                        TemuDokter::STATUS_MENUNGGU,
                                        TemuDokter::STATUS_CHECKIN,
                                        TemuDokter::STATUS_PEMERIKSAAN,
                                        TemuDokter::STATUS_TREATMENT,
                                    ])->count();
        }

        $showContactFields = Schema::hasColumn('user', 'no_wa');
        return view('admin.dokter.show', compact('dokter', 'roleUser', 'totalReservations', 'completedReservations', 'pendingReservations', 'showContactFields'));
    }

    /**
     * Show the form for editing the specified dokter.
     */
    public function edit(User $dokter)
    {
        // Verify this user is actually a dokter
        if (!$dokter->hasRole('Dokter')) {
            abort(404);
        }

        // Load dokter profile
        $dokter->load('dokter');

        // Provide roleUser to the edit view so status radio can be prefilled
        $dokterRole = Role::where('nama_role', 'Dokter')->first();
        $roleUser = null;
        if ($dokterRole) {
            $roleUser = RoleUser::where('iduser', $dokter->iduser)
                        ->where('idrole', $dokterRole->idrole)
                        ->first();
        }

        $showContactFields = Schema::hasColumn('user', 'no_wa');
        return view('admin.dokter.edit', compact('dokter', 'roleUser', 'showContactFields'));
    }

    /**
     * Update the specified dokter in storage.
     */
    public function update(Request $request, User $dokter)
    {
        // Verify this user is actually a dokter
        if (!$dokter->hasRole('Dokter')) {
            abort(404);
        }

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:500'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:user,email,' . $dokter->iduser . ',iduser'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'no_wa' => ['nullable', 'string', 'max:20'],
            'alamat' => ['required', 'string', 'max:100'],
            'no_hp' => ['required', 'string', 'max:45'],
            'bidang_dokter' => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['required', 'in:L,P'],
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

            $dokter->update($updateData);

            // Update dokter profile
            \App\Models\Dokter::updateOrCreate(
                ['id_user' => $dokter->iduser],
                [
                    'alamat' => $validated['alamat'],
                    'no_hp' => $validated['no_hp'],
                    'bidang_dokter' => $validated['bidang_dokter'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                ]
            );

            // Update role status
            $dokterRole = Role::where('nama_role', 'Dokter')->firstOrFail();
            RoleUser::where('iduser', $dokter->iduser)
                ->where('idrole', $dokterRole->idrole)
                ->update(['status' => $validated['status']]);

            DB::commit();

            return redirect()->route('admin.dokter.index')
                ->with('success', 'Data dokter berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified dokter from storage.
     */
    public function destroy(User $dokter)
    {
        // Verify this user is actually a dokter
        if (!$dokter->hasRole('Dokter')) {
            abort(404);
        }

        try {
            DB::beginTransaction();

            // Delete dokter profile from dokter table
            \App\Models\Dokter::where('id_user', $dokter->iduser)->delete();

            DB::commit();

            return redirect()->route('admin.dokter.index')
                ->with('success', 'Data dokter berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
