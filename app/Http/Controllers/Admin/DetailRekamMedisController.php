<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailRekamMedis;
use App\Models\RekamMedis;
use App\Models\KodeTindakanTerapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailRekamMedisController extends Controller
{
    /**
     * Display a listing of detail rekam medis for a specific rekam medis.
     * Accessible by Dokter (full CRUD) and Perawat (view only)
     */
    public function index($idrekam_medis)
    {
        $rekamMedis = RekamMedis::with(['temuDokter.pet', 'temuDokter.roleUser'])->findOrFail($idrekam_medis);

        $details = DetailRekamMedis::with(['kodeTindakanTerapi'])
            ->where('idrekam_medis', $idrekam_medis)
            ->orderBy('iddetail_rekam_medis', 'desc')
            ->paginate(10);

        $user = Auth::user();
        $canEdit = $user->hasRole('Dokter') || $user->hasRole('Administrator');

        return view('detail-rekam-medis.index', compact('rekamMedis', 'details', 'canEdit'));
    }

    /**
     * Show the form for creating a new detail rekam medis.
     * Only for Dokter
     */
    public function create($idrekam_medis)
    {
        $rekamMedis = RekamMedis::with(['temuDokter.pet', 'temuDokter.roleUser'])->findOrFail($idrekam_medis);
        $kodeTindakan = KodeTindakanTerapi::orderBy('kode')->get();

        return view('detail-rekam-medis.create', compact('rekamMedis', 'kodeTindakan'));
    }

    /**
     * Store a newly created detail rekam medis.
     * Only for Dokter
     */
    public function store(Request $request, $idrekam_medis)
    {
        $validated = $request->validate([
            'idkode_tindakan_terapi' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail' => 'nullable|string|max:1000',
        ], [
            'idkode_tindakan_terapi.required' => 'Kode tindakan/terapi harus dipilih.',
            'idkode_tindakan_terapi.exists' => 'Kode tindakan/terapi tidak valid.',
            'detail.max' => 'Detail maksimal 1000 karakter.',
        ]);

        DetailRekamMedis::create([
            'idrekam_medis' => $idrekam_medis,
            'idkode_tindakan_terapi' => $validated['idkode_tindakan_terapi'],
            'detail' => $validated['detail'] ?? null,
        ]);

        // Update status appointment dari "Check-in" ke "Pemeriksaan" atau "Treatment"
        // karena dokter sudah menambahkan treatment/tindakan
        $rekamMedis = RekamMedis::findOrFail($idrekam_medis);
        if ($rekamMedis->temuDokter) {
            $currentStatus = $rekamMedis->temuDokter->status;

            // Jika masih Check-in, ubah ke Pemeriksaan (dokter mulai memeriksa)
            if ($currentStatus == \App\Models\TemuDokter::STATUS_CHECKIN) {
                $rekamMedis->temuDokter->status = \App\Models\TemuDokter::STATUS_PEMERIKSAAN;
                $rekamMedis->temuDokter->save();
            }
            // Jika sudah Pemeriksaan, ubah ke Treatment (dokter memberikan treatment)
            elseif ($currentStatus == \App\Models\TemuDokter::STATUS_PEMERIKSAAN) {
                $rekamMedis->temuDokter->status = \App\Models\TemuDokter::STATUS_TREATMENT;
                $rekamMedis->temuDokter->save();
            }
        }

        return redirect()
            ->route('dokter.rekam-medis.detail.index', ['rekam_medis' => $idrekam_medis])
            ->with('success', 'Detail rekam medis berhasil ditambahkan dan status appointment diupdate.');
    }

    /**
     * Display the specified detail rekam medis.
     * Accessible by both Dokter and Perawat
     */
    public function show($idrekam_medis, DetailRekamMedis $detail)
    {
        $detail->load(['rekamMedis.temuDokter.pet', 'kodeTindakanTerapi']);

        // Verify the detail belongs to the specified rekam_medis
        if ($detail->idrekam_medis != $idrekam_medis) {
            abort(404);
        }

        $user = Auth::user();
        $canEdit = $user->hasRole('Dokter') || $user->hasRole('Administrator');

        return view('detail-rekam-medis.show', compact('detail', 'canEdit'));
    }

    /**
     * Show the form for editing the specified detail rekam medis.
     * Only for Dokter
     */
    public function edit($idrekam_medis, DetailRekamMedis $detail)
    {
        $detail->load(['rekamMedis.temuDokter.pet', 'kodeTindakanTerapi']);

        // Verify the detail belongs to the specified rekam_medis
        if ($detail->idrekam_medis != $idrekam_medis) {
            abort(404);
        }

        $kodeTindakan = KodeTindakanTerapi::orderBy('kode')->get();

        return view('detail-rekam-medis.edit', compact('detail', 'kodeTindakan'));
    }

    /**
     * Update the specified detail rekam medis.
     * Only for Dokter
     */
    public function update(Request $request, $idrekam_medis, DetailRekamMedis $detail)
    {
        // Verify the detail belongs to the specified rekam_medis
        if ($detail->idrekam_medis != $idrekam_medis) {
            abort(404);
        }

        $validated = $request->validate([
            'idkode_tindakan_terapi' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail' => 'nullable|string|max:1000',
        ], [
            'idkode_tindakan_terapi.required' => 'Kode tindakan/terapi harus dipilih.',
            'idkode_tindakan_terapi.exists' => 'Kode tindakan/terapi tidak valid.',
            'detail.max' => 'Detail maksimal 1000 karakter.',
        ]);

        $detail->update([
            'idkode_tindakan_terapi' => $validated['idkode_tindakan_terapi'],
            'detail' => $validated['detail'] ?? null,
        ]);

        return redirect()
            ->route('dokter.rekam-medis.detail.index', ['rekam_medis' => $idrekam_medis])
            ->with('success', 'Detail rekam medis berhasil diperbarui.');
    }

    /**
     * Remove the specified detail rekam medis.
     * Only for Dokter
     */
    public function destroy($idrekam_medis, DetailRekamMedis $detail)
    {
        // Verify the detail belongs to the specified rekam_medis
        if ($detail->idrekam_medis != $idrekam_medis) {
            abort(404);
        }

        $detail->delete();

        return redirect()
            ->route('dokter.rekam-medis.detail.index', ['rekam_medis' => $idrekam_medis])
            ->with('success', 'Detail rekam medis berhasil dihapus.');
    }
}
