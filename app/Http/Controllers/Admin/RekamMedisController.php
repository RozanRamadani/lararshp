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
        $rekamMedis = RekamMedis::with(['temuDokter.pet.pemilik', 'temuDokter.roleUser'])
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
        // Provide pets and doctors for the form. The controller will map the selected
        // pet to an existing `temu_dokter` reservation when storing the record.
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

        // We need to associate the RekamMedis with an existing temu_dokter (reservation).
        // Prefer using the latest reservation for the selected pet.
        $petId = $validated['idpet'] ?? null;
        if (!$petId) {
            return back()->withInput()->with('error', 'Pet harus dipilih dan memiliki reservasi temu dokter.');
        }

        $temu = \App\Models\TemuDokter::where('idpet', $petId)->latest('waktu_daftar')->first();
        if (!$temu) {
            return back()->withInput()->with('error', 'Tidak ditemukan reservasi (temu_dokter) untuk pet ini. Buat appointment terlebih dahulu.');
        }

        // Determine dokter_pemeriksa as role_user id. If the form provided a user id (iddokter),
        // map it to role_user.idrole_user; otherwise use temu_dokter.idrole_user.
        $dokterRoleUserId = $temu->idrole_user;
        if (!empty($validated['iddokter'])) {
            $role = \Illuminate\Support\Facades\DB::table('role_user')->where('iduser', $validated['iddokter'])->where('idrole', 2)->first(); // 2 == Dokter
            if ($role) {
                $dokterRoleUserId = $role->idrole_user;
            } else {
                // fallback: take any role_user for the user
                $roleAny = \Illuminate\Support\Facades\DB::table('role_user')->where('iduser', $validated['iddokter'])->first();
                if ($roleAny) {
                    $dokterRoleUserId = $roleAny->idrole_user;
                }
            }
        }

        // Map form inputs to actual DB columns
        $payload = [
            'idreservasi_dokter' => $temu->idreservasi_dokter,
            'anamesis' => $validated['anamnesa'] ?? null,
            'temuan_klinis' => $validated['pemeriksaan_fisik'] ?? null,
            'diagnosa' => $validated['diagnosis'] ?? null,
            'dokter_pemeriksa' => $dokterRoleUserId,
            'created_at' => now(),
        ];

        RekamMedis::create($payload);

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
        $rekamMedis->load(['temuDokter.pet.pemilik', 'temuDokter.pet.rasHewan', 'temuDokter.roleUser']);

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
        $rekamMedis->load(['temuDokter.pet.pemilik']);
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

        // Map update fields similarly to store
        $payload = [
            'anamesis' => $validated['anamnesa'] ?? $rekamMedis->anamesis,
            'temuan_klinis' => $validated['pemeriksaan_fisik'] ?? $rekamMedis->temuan_klinis,
            'diagnosa' => $validated['diagnosis'] ?? $rekamMedis->diagnosa,
        ];

        $rekamMedis->update($payload);

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

        $rekamMedis = RekamMedis::with(['temuDokter.roleUser'])
            ->whereHas('temuDokter', function($q) use ($idpet) {
                $q->where('idpet', $idpet);
            })
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
            // Status is handled via temu_dokter/role_user in this schema
            'iddokter.exists' => 'Dokter tidak ditemukan.',
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
