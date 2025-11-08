<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pemilik;
use App\Models\Pet;
use App\Models\User;
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
        return view('admin.pemilik.create');
    }

    /**
     * Store a newly created pemilik in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'nama_pemilik' => 'required|string|min:3|max:255',
            'alamat' => 'required|string|min:10|max:500',
            'kota' => 'required|string|max:100',
            'no_telepon' => 'required|string|regex:/^(\+?62|0)[0-9]{9,12}$/|unique:pemilik,no_wa',
            'email' => 'nullable|email|max:255|unique:user,email',
        ]);

        try {
            DB::beginTransaction();

            // Create user & pemilik
            $user = User::create([
                'nama' => $request->nama_pemilik,
                'email' => $request->email ?? 'pemilik_' . time() . '@temp.com',
                'password' => Hash::make('password123'),
                'no_wa' => $request->no_telepon,
                'kota' => $request->kota,
                'idrole' => 3,
            ]);

            Pemilik::create([
                'no_wa' => $request->no_telepon,
                'alamat' => trim($request->alamat),
                'iduser' => $user->iduser,
            ]);

            DB::commit();
            return redirect()->route('admin.pemilik.index')->with('success', 'Data pemilik berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create pemilik: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menambahkan pemilik.');
        }
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
        $request->validate([
            'nama_pemilik' => 'required|string|min:3|max:255',
            'alamat' => 'required|string|min:10|max:500',
            'kota' => 'required|string|max:100',
            'no_telepon' => 'required|string|regex:/^(\+?62|0)[0-9]{9,12}$/|unique:pemilik,no_wa,' . $pemilik->idpemilik . ',idpemilik',
            'email' => 'nullable|email|max:255|unique:user,email,' . $pemilik->iduser . ',iduser',
        ]);

        try {
            DB::beginTransaction();

            $pemilik->user->update([
                'nama' => $request->nama_pemilik,
                'email' => $request->email ?? $pemilik->user->email,
                'no_wa' => $request->no_telepon,
                'kota' => $request->kota,
            ]);

            $pemilik->update([
                'no_wa' => $request->no_telepon,
                'alamat' => trim($request->alamat),
            ]);

            DB::commit();
            return redirect()->route('admin.pemilik.index')->with('success', 'Data pemilik berhasil diperbarui.');

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

            return redirect()->route('admin.pemilik.index')->with('success', 'Data pemilik berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete pemilik: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus pemilik.');
        }
    }
}
