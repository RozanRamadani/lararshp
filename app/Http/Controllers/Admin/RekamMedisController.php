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
    public function index(Request $request)
    {
        $user = Auth::user();

        // Check if showing trashed records
        if ($request->get('show_trashed')) {
            $rekamMedis = RekamMedis::onlyTrashed()
                ->with(['temuDokter.pet.pemilik', 'temuDokter.roleUser'])
                ->orderBy('idrekam_medis', 'desc')
                ->paginate(15);
        } else {
            $rekamMedis = RekamMedis::with(['temuDokter.pet.pemilik', 'temuDokter.roleUser'])
                ->orderBy('idrekam_medis', 'desc')
                ->paginate(15);
        }

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
        $pets = Pet::with(['pemilik.user', 'rasHewan.jenisHewan'])->get();
        $dokters = User::whereHas('roles', function($query) {
            $query->where('nama_role', 'Dokter');
        })->get();

        $selectedPet = null;
        if ($request->has('idpet')) {
            $selectedPet = Pet::with(['pemilik.user', 'rasHewan.jenisHewan'])
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

        // Update status appointment dari "Menunggu" ke "Check-in"
        // karena perawat sudah membuat rekam medis (vital signs sudah dicatat)
        $temu->status = \App\Models\TemuDokter::STATUS_CHECKIN;
        $temu->save();

        return redirect()->route('perawat.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * Untuk Dokter: Read-only
     * Untuk Perawat: Full access
     */
    public function show($rekam_medi)
    {
        $rekamMedis = RekamMedis::findOrFail($rekam_medi);
        $rekamMedis->load([
            'temuDokter.pet.pemilik.user',
            'temuDokter.pet.rasHewan.jenisHewan',
            'temuDokter.roleUser.user',
            'details.kodeTindakanTerapi'
        ]);

        $user = Auth::user();
        $isReadOnly = $user->hasRole('Dokter');

        return view('rekam-medis.show', compact('rekamMedis', 'isReadOnly'));
    }

    /**
     * Show the form for editing the specified resource.
     * Hanya untuk Perawat
     */
    public function edit($rekam_medi)
    {
        $rekamMedis = RekamMedis::findOrFail($rekam_medi);
        $rekamMedis->load([
            'temuDokter.pet.pemilik.user',
            'temuDokter.pet.rasHewan.jenisHewan',
            'temuDokter.roleUser.user'
        ]);

        $pets = Pet::with(['pemilik.user', 'rasHewan.jenisHewan'])->get();
        $dokters = User::whereHas('roles', function($query) {
            $query->where('nama_role', 'Dokter');
        })->get();

        return view('rekam-medis.edit', compact('rekamMedis', 'pets', 'dokters'));
    }

    /**
     * Update the specified resource in storage.
     * Hanya untuk Perawat
     */
    public function update(Request $request, $rekam_medi)
    {
        $rekamMedis = RekamMedis::findOrFail($rekam_medi);
        $validated = $request->validate($this->updateValidationRules($rekamMedis), $this->validationMessages());

        // Map update fields similarly to store
        $payload = [
            'anamesis' => $validated['anamnesa'] ?? $rekamMedis->anamesis,
            'temuan_klinis' => $validated['pemeriksaan_fisik'] ?? $rekamMedis->temuan_klinis,
            'diagnosa' => $validated['diagnosis'] ?? $rekamMedis->diagnosa,
        ];

        $rekamMedis->update($payload);

        // Jika dokter mengupdate diagnosis/temuan klinis, update status ke Pemeriksaan
        $user = Auth::user();
        if ($user->hasRole('Dokter') && $rekamMedis->temuDokter) {
            $currentStatus = $rekamMedis->temuDokter->status;

            // Jika masih Check-in, ubah ke Pemeriksaan (dokter mulai memeriksa)
            if ($currentStatus == \App\Models\TemuDokter::STATUS_CHECKIN) {
                $rekamMedis->temuDokter->status = \App\Models\TemuDokter::STATUS_PEMERIKSAAN;
                $rekamMedis->temuDokter->save();
            }
        }

        return redirect()->route('perawat.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * Hanya untuk Perawat
     */
    public function destroy($rekam_medi)
    {
        $rekamMedis = RekamMedis::findOrFail($rekam_medi);

        // Delete all related detail_rekam_medis first (soft delete)
        $rekamMedis->details()->delete();

        // Then delete the main record (soft delete)
        $rekamMedis->delete();

        return redirect()->route('perawat.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil dihapus.');
    }

    /**
     * Restore soft deleted rekam medis
     */
    public function restore($id)
    {
        $rekamMedis = RekamMedis::withTrashed()->findOrFail($id);

        // Restore related details first
        $rekamMedis->details()->withTrashed()->restore();

        // Restore main record
        $rekamMedis->restore();

        return redirect()->route('perawat.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil dipulihkan.');
    }

    /**
     * Permanently delete rekam medis
     */
    public function forceDelete($id)
    {
        $rekamMedis = RekamMedis::withTrashed()->findOrFail($id);

        // Force delete all related details first
        $rekamMedis->details()->withTrashed()->forceDelete();

        // Force delete main record
        $rekamMedis->forceDelete();

        return redirect()->route('perawat.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil dihapus permanen.');
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
            'iddokter.exists' => 'Dokter tidak ditemukan.',
            'anamnesa.required' => 'Anamnesa / Anamnesis wajib diisi.',
            'anamnesa.max' => 'Anamnesa maksimal 1000 karakter.',
            'pemeriksaan_fisik.required' => 'Temuan klinis wajib diisi.',
            'pemeriksaan_fisik.max' => 'Temuan klinis maksimal 1000 karakter.',
            'diagnosis.required' => 'Diagnosa wajib diisi.',
            'diagnosis.max' => 'Diagnosa maksimal 1000 karakter.',
        ];
    }

    /**
     * Helper: aturan validasi store
     */
    private function storeValidationRules(): array
    {
        return [
            'idpet' => 'required|exists:pet,idpet',
            'iddokter' => 'nullable|exists:user,iduser',
            'anamnesa' => 'required|string|max:1000',
            'pemeriksaan_fisik' => 'required|string|max:1000',
            'diagnosis' => 'required|string|max:1000',
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

    /**
     * Mark appointment as complete (Selesai) - Dokter only
     */
    public function markAsComplete(RekamMedis $rekamMedis)
    {
        $user = Auth::user();

        // Validate user is dokter
        if (!$user->hasRole('Dokter')) {
            abort(403, 'Hanya dokter yang dapat menyelesaikan rekam medis.');
        }

        $temu = $rekamMedis->temuDokter;

        if (!$temu) {
            return redirect()->back()->withErrors(['error' => 'Appointment tidak ditemukan.']);
        }

        // Validate current status is PEMERIKSAAN or TREATMENT
        if (!in_array($temu->status, [
            \App\Models\TemuDokter::STATUS_PEMERIKSAAN,
            \App\Models\TemuDokter::STATUS_TREATMENT
        ])) {
            return redirect()->back()->withErrors([
                'error' => 'Status appointment harus Pemeriksaan atau Treatment untuk diselesaikan.'
            ]);
        }

        // Update status to Selesai
        $temu->status = \App\Models\TemuDokter::STATUS_SELESAI;
        $temu->save();

        return redirect()->back()->with('success', 'Rekam medis berhasil diselesaikan.');
    }
}
