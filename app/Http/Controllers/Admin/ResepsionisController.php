<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\TemuDokter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResepsionisController extends Controller
{
    /**
     * Display a listing of resepsionis.
     */
    public function index(Request $request)
    {
        // Use the 'roles' relationship (belongsToMany) and check the pivot table
        $resepsionis = User::whereHas('roles', function($query) {
            // qualify column with role table to avoid ambiguity in join
            $query->where('role.idrole', 4) // Resepsionis role ID = 4
                  ->where('role_user.status', 1);
        })->paginate(15);

        $statusFilter = $request->query('status', 'active');
        // Rebuild query with status filter
        $resepsionis = User::whereHas('roles', function($query) use ($statusFilter) {
            $query->where('role.idrole', 4);
            if ($statusFilter !== 'all') {
                $query->where('role_user.status', $statusFilter === 'inactive' ? 0 : 1);
            }
        })->paginate(15);

        $showContactFields = Schema::hasColumn('user', 'no_wa') || Schema::hasColumn('user', 'kota');
        return view('admin.resepsionis.index', compact('resepsionis', 'showContactFields'))->with('filterStatus', $statusFilter);
    }

    /**
     * Show the form for creating a new resepsionis.
     */
    public function create()
    {
        $showContactFields = Schema::hasColumn('user', 'no_wa') || Schema::hasColumn('user', 'kota');
        return view('admin.resepsionis.create', compact('showContactFields'));
    }

    /**
     * Store a newly created resepsionis in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|string|min:8|confirmed',
            'no_wa' => 'nullable|string|max:20',
            'kota' => 'nullable|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            $userData = [
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ];
            if (Schema::hasColumn('user', 'no_wa')) {
                $userData['no_wa'] = $validated['no_wa'] ?? null;
            }
            if (Schema::hasColumn('user', 'kota')) {
                $userData['kota'] = $validated['kota'] ?? null;
            }
            $user = User::create($userData);

            // Assign Resepsionis role (ID = 4)
            RoleUser::create([
                'iduser' => $user->iduser,
                'idrole' => 4, // Resepsionis
                'status' => 1,
            ]);

            DB::commit();

            return redirect()->route('admin.resepsionis.index')
                           ->with('success', 'Resepsionis berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                       ->with('error', 'Gagal menambahkan resepsionis: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resepsionis.
     */
    public function show($id)
    {
        $resepsionis = User::findOrFail($id);

        $roleUser = RoleUser::where('iduser', $id)
                   ->where('idrole', 4)
                   ->first();

        // Get statistics
        $totalAppointments = TemuDokter::where('iduser', $id)->count();
        $pendingAppointments = TemuDokter::where('iduser', $id)
                                        ->where('status', 'PENDING')
                                        ->count();
        $completedAppointments = TemuDokter::where('iduser', $id)
                                          ->where('status', 'SELESAI')
                                          ->count();

        $showContactFields = Schema::hasColumn('user', 'no_wa') || Schema::hasColumn('user', 'kota');
        return view('admin.resepsionis.show', compact(
            'resepsionis',
            'roleUser',
            'totalAppointments',
            'pendingAppointments',
            'completedAppointments',
            'showContactFields'
        ));
    }

    /**
     * Show the form for editing the specified resepsionis.
     */
    public function edit($id)
    {
        $resepsionis = User::findOrFail($id);

        $roleUser = RoleUser::where('iduser', $id)
                           ->where('idrole', 4)
                           ->first();

        $showContactFields = Schema::hasColumn('user', 'no_wa') || Schema::hasColumn('user', 'kota');
        return view('admin.resepsionis.edit', compact('resepsionis', 'roleUser', 'showContactFields'));
    }

    /**
     * Update the specified resepsionis in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $id . ',iduser',
            'password' => 'nullable|string|min:8|confirmed',
            'no_wa' => 'nullable|string|max:20',
            'kota' => 'nullable|string|max:100',
            'status' => 'required|in:0,1',
        ]);

        try {
            DB::beginTransaction();

            $resepsionis = User::findOrFail($id);

            // Update user data
            $resepsionis->nama = $validated['nama'];
            $resepsionis->email = $validated['email'];
            if (Schema::hasColumn('user', 'no_wa')) {
                $resepsionis->no_wa = $validated['no_wa'] ?? null;
            }
            if (Schema::hasColumn('user', 'kota')) {
                $resepsionis->kota = $validated['kota'] ?? null;
            }

            // Update password if provided
            if (!empty($validated['password'])) {
                $resepsionis->password = Hash::make($validated['password']);
            }

            $resepsionis->save();

            // Update role status
            RoleUser::where('iduser', $id)
                   ->where('idrole', 4)
                   ->update(['status' => $validated['status']]);

            DB::commit();

            return redirect()->route('admin.resepsionis.index')
                           ->with('success', 'Data resepsionis berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                       ->with('error', 'Gagal mengupdate resepsionis: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resepsionis from storage (soft delete).
     */
    public function destroy($id)
    {
        try {
            // Soft delete by setting status to 0
            RoleUser::where('iduser', $id)
                   ->where('idrole', 4)
                   ->update(['status' => 0]);

            return redirect()->route('admin.resepsionis.index')
                           ->with('success', 'Resepsionis berhasil dinonaktifkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menonaktifkan resepsionis: ' . $e->getMessage());
        }
    }
}
