<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pemilik;
use App\Models\Pet;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PemilikController extends Controller
{
    public function index()
    {
        $pemilik = Pemilik::with(['user', 'pets.rasHewan.jenisHewan'])->get();
        $totalPemilik = $pemilik->count();
        $totalPets = Pet::count();
        $aktivePemilik = $pemilik->count(); // Semua pemilik dianggap aktif
        $kunjunganBulanIni = 0; // Placeholder - nanti bisa ditambahkan logic untuk hitung kunjungan

        return view('admin.pemilik.index', compact(
            'pemilik',
            'totalPemilik',
            'totalPets',
            'aktivePemilik',
            'kunjunganBulanIni'
        ));
    }

    /**
     * Show the form for creating a new pemilik.
     */
    public function create()
    {
        // Get all users that don't have Pemilik role yet
        $availableUsers = User::whereDoesntHave('roles', function($q) {
            $q->where('nama_role', 'Pemilik');
        })->get();

        return view('admin.pemilik.create', compact('availableUsers'));
    }

    /**
     * Upgrade existing user to Pemilik role
     */
    public function upgradeUser(Request $request)
    {
        $validated = $request->validate([
            'iduser' => 'required|exists:user,iduser',
            'no_wa' => 'required|string|min:10|max:15',
            'alamat' => 'required|string|min:10|max:500',
        ], [
            'iduser.required' => 'User wajib dipilih.',
            'iduser.exists' => 'User tidak ditemukan.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'no_wa.min' => 'Nomor WhatsApp minimal 10 digit.',
            'no_wa.max' => 'Nomor WhatsApp maksimal 15 digit.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.min' => 'Alamat minimal 10 karakter.',
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($validated['iduser']);

            // Check if already has Pemilik role
            if ($user->hasRole('Pemilik')) {
                return back()->with('error', 'User ini sudah memiliki role Pemilik.');
            }

            // Get Pemilik role
            $pemilikRole = Role::where('nama_role', 'Pemilik')->firstOrFail();

            // Assign Pemilik role
            RoleUser::create([
                'iduser' => $user->iduser,
                'idrole' => $pemilikRole->idrole,
                'status' => 1,
            ]);

            // Create pemilik record
            Pemilik::create([
                'no_wa' => $validated['no_wa'],
                'alamat' => trim($validated['alamat']),
                'iduser' => $user->iduser,
            ]);

            DB::commit();

            $route = request()->routeIs('resepsionis.pemilik.*')
                ? route('resepsionis.pemilik.index')
                : route('admin.pemilik.index');

            return redirect($route)
                ->with('success', 'User berhasil di-upgrade menjadi Pemilik.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to upgrade user to pemilik: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal upgrade user: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created pemilik in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate($this->storeValidationRules(), $this->validationMessages());

        try {
            DB::beginTransaction();

            // Create user
            $user = User::create([
                'nama' => $validated['nama_pemilik'],
                'email' => $validated['email'] ?? 'pemilik_' . time() . '@temp.com',
                'password' => Hash::make($validated['password'] ?? 'password123'),
            ]);

            // Get Pemilik role
            $pemilikRole = Role::where('nama_role', 'Pemilik')->firstOrFail();

            // Assign Pemilik role
            RoleUser::create([
                'iduser' => $user->iduser,
                'idrole' => $pemilikRole->idrole,
                'status' => 1,
            ]);

            // Create pemilik record
            Pemilik::create([
                'no_wa' => $validated['no_wa'],
                'alamat' => trim($validated['alamat']),
                'iduser' => $user->iduser,
            ]);

            DB::commit();

            $route = request()->routeIs('resepsionis.pemilik.*')
                ? route('resepsionis.pemilik.index')
                : route('admin.pemilik.index');

            return redirect($route)->with('success', 'Data pemilik berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create pemilik: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menambahkan pemilik.');
        }
    }

    /**
     * Display the specified pemilik.
     */
    public function show(Pemilik $pemilik)
    {
        $pemilik->load(['user', 'pets.rasHewan.jenisHewan']);
        return view('admin.pemilik.show', compact('pemilik'));
    }

    /**
     * Show the form for editing the specified pemilik.
     */
    public function edit(Pemilik $pemilik)
    {
        $pemilik->load('user');
        return view('admin.pemilik.edit', compact('pemilik'));
    }

    /**
     * Update the specified pemilik in storage.
     */
    public function update(Request $request, Pemilik $pemilik)
    {
        // Validasi
        $validated = $request->validate($this->updateValidationRules($pemilik), $this->validationMessages());

        try {
            DB::beginTransaction();

            $pemilik->user->update([
                'nama' => $validated['nama_pemilik'],
                'email' => $validated['email'] ?? $pemilik->user->email,
            ]);

            $pemilik->update([
                'no_wa' => $validated['no_wa'],
                'alamat' => trim($validated['alamat']),
            ]);

            DB::commit();

            $route = request()->routeIs('resepsionis.pemilik.*')
                ? route('resepsionis.pemilik.index')
                : route('admin.pemilik.index');

            return redirect($route)->with('success', 'Data pemilik berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update pemilik: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui pemilik.');
        }
    }

    /**
     * Remove the specified pemilik from storage.
     */
    public function destroy(Pemilik $pemilik)
    {
        if ($pemilik->pets()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus pemilik yang masih memiliki pet terdaftar.');
        }

        try {
            DB::beginTransaction();
            $user = $pemilik->user;
            $pemilik->delete();
            $user->delete();
            DB::commit();

            $route = request()->routeIs('resepsionis.pemilik.*')
                ? route('resepsionis.pemilik.index')
                : route('admin.pemilik.index');

            return redirect($route)->with('success', 'Data pemilik berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete pemilik: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus pemilik.');
        }
    }

    /**
     * Helper
     */
    private function validationMessages(): array
    {
        return [
            'nama_pemilik.required' => 'Nama pemilik wajib diisi.',
            'nama_pemilik.string' => 'Nama pemilik harus berupa teks.',
            'nama_pemilik.min' => 'Nama pemilik minimal 3 karakter.',
            'nama_pemilik.max' => 'Nama pemilik maksimal 255 karakter.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.min' => 'Alamat minimal 10 karakter.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',
            'kota.required' => 'Kota wajib diisi.',
            'kota.max' => 'Kota maksimal 100 karakter.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.regex' => 'Format nomor telepon tidak valid.',
            'no_telepon.unique' => 'Nomor telepon sudah terdaftar.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
        ];
    }

    /**
     * Helper: aturan validasi store
     */
    private function storeValidationRules(): array
    {
        return [
            'nama_pemilik' => 'required|string|min:3|max:255',
            'alamat' => 'required|string|min:10|max:255',
            'no_wa' => 'required|string|min:10|max:15|unique:pemilik,no_wa',
            'email' => 'nullable|email|max:255|unique:user,email',
        ];
    }

    /**
     * Helper: aturan validasi update
     */
    private function updateValidationRules(Pemilik $pemilik): array
    {
        return [
            'nama_pemilik' => 'required|string|min:3|max:255',
            'alamat' => 'required|string|min:10|max:255',
            'no_wa' => 'required|string|min:10|max:15|unique:pemilik,no_wa,' . $pemilik->idpemilik . ',idpemilik',
            'email' => 'nullable|email|max:255|unique:user,email,' . $pemilik->iduser . ',iduser',
        ];
    }
}
