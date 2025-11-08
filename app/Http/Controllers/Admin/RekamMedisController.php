<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     * Untuk Dokter: Read-only
     * Untuk Perawat: Full access
     */
    public function index()
    {
        $user = Auth::user();

        // Sementara tampilkan semua data untuk testing
        // TODO: Filter berdasarkan dokter setelah tahu struktur kolom yang benar
        $rekamMedis = RekamMedis::with(['pet.pemilik', 'pet.jenis_hewan', 'dokter', 'perawat'])
            ->orderBy('idrekam_medis', 'desc') // Using primary key instead of tanggal_kunjungan
            ->paginate(15);

        return view('rekam-medis.index', compact('rekamMedis'));
    }

    /**
     * Show the form for creating a new resource.
     * Hanya untuk Perawat
     */
    public function create(Request $request)
    {
        $pets = Pet::with(['pemilik', 'jenis_hewan', 'ras_hewan'])->get();
        $dokters = User::whereHas('roles', function($query) {
            $query->where('nama_role', 'Dokter');
        })->get();

        $selectedPet = null;
        if ($request->has('idpet')) {
            $selectedPet = Pet::with(['pemilik', 'jenis_hewan', 'ras_hewan'])
                ->findOrFail($request->idpet);
        }

        return view('rekam-medis.create', compact('pets', 'dokters', 'selectedPet'));
    }

    /**
     * Store a newly created resource in storage.
     * Hanya untuk Perawat
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->storeValidationRules(), $this->validationMessages());

        $validated['idperawat'] = Auth::id();

        RekamMedis::create($validated);

        return redirect()->route('perawat.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * Untuk Dokter: Read-only
     * Untuk Perawat: Full access
     */
    public function show(RekamMedis $rekamMedis)
    {
        $rekamMedis->load(['pet.pemilik', 'pet.jenis_hewan', 'pet.ras_hewan', 'dokter', 'perawat']);

        $user = Auth::user();
        $isReadOnly = $user->hasRole('Dokter');

        return view('rekam-medis.show', compact('rekamMedis', 'isReadOnly'));
    }

    /**
     * Show the form for editing the specified resource.
     * Hanya untuk Perawat
     */
    public function edit(RekamMedis $rekamMedis)
    {
        $rekamMedis->load(['pet.pemilik']);
        $pets = Pet::with(['pemilik', 'jenis_hewan', 'ras_hewan'])->get();
        $dokters = User::whereHas('roles', function($query) {
            $query->where('nama_role', 'Dokter');
        })->get();

        return view('rekam-medis.edit', compact('rekamMedis', 'pets', 'dokters'));
    }

    /**
     * Update the specified resource in storage.
     * Hanya untuk Perawat
     */
    public function update(Request $request, RekamMedis $rekamMedis)
    {
        $validated = $request->validate($this->updateValidationRules($rekamMedis), $this->validationMessages());

        $rekamMedis->update($validated);

        return redirect()->route('perawat.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * Hanya untuk Perawat
     */
    public function destroy(RekamMedis $rekamMedis)
    {
        $rekamMedis->delete();

        return redirect()->route('perawat.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil dihapus.');
    }

    /**
     * Display medical records for specific pet
     * Untuk Pemilik: View own pet's records
     */
    public function petRecords($idpet)
    {
        $pet = Pet::with(['pemilik', 'jenis_hewan', 'ras_hewan'])->findOrFail($idpet);

        // Verify ownership for Pemilik role
        $user = Auth::user();
        if ($user->hasRole('Pemilik')) {
            if ($pet->pemilik->iduser != $user->iduser) {
                abort(403, 'Unauthorized access to pet records.');
            }
        }

        $rekamMedis = RekamMedis::with(['dokter', 'perawat'])
            ->where('idpet', $idpet)
            ->orderBy('idrekam_medis', 'desc') // Using primary key instead of tanggal_kunjungan
            ->paginate(10);

        return view('rekam-medis.pet-records', compact('pet', 'rekamMedis'));
    }

    /**
     * Helper: pesan validasi kustom untuk rekam medis
     */
    private function validationMessages(): array
    {
        return [
            'idpet.required' => 'Pilih pet terlebih dahulu.',
            'idpet.exists' => 'Pet tidak ditemukan.',
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status tidak valid.',
            // Tambah pesan lain jika perlu
        ];
    }

    /**
     * Helper: aturan validasi store
     */
    private function storeValidationRules(): array
    {
        return [
            'idpet' => 'required|exists:pet,idpet',
            'iddokter' => 'nullable|exists:users,iduser',
            'anamnesa' => 'nullable|string',
            'pemeriksaan_fisik' => 'nullable|string',
            'suhu' => 'nullable|numeric|between:0,99.99',
            'berat_badan' => 'nullable|integer|min:0',
            'diagnosis' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'resep_obat' => 'nullable|string',
            'catatan' => 'nullable|string',
            'status' => 'required|in:menunggu,dalam_perawatan,selesai,rujukan',
            'tanggal_kontrol' => 'nullable|date',
        ];
    }

    /**
     * Helper: aturan validasi update
     */
    private function updateValidationRules(RekamMedis $rekamMedis): array
    {
        // Saat ini sama dengan store
        return $this->storeValidationRules();
    }
}
