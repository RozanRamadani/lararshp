<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AppointmentService;
use Illuminate\Support\Facades\Log;
use App\Models\TemuDokter;

class AppointmentTransactionController extends Controller
{
    protected $service;

    public function __construct(AppointmentService $service)
    {
        $this->service = $service;
        // Hanya perawat dan admin yang bisa complete visit
        $this->middleware('role:Administrator,Perawat');
    }

    /**
     * Complete an appointment and create RekamMedis (transactionally).
     */
    public function complete(Request $request, $idreservasi)
    {

        $data = $request->validate([
            'idrole_user_dokter' => 'required|integer',
            'anamesis' => 'nullable|string',
            'temuan_klinis' => 'nullable|string',
            'diagnosa' => 'nullable|string',
        ]);

        try {
            $rekam = $this->service->completeVisit(
                (int) $idreservasi,
                (int) $data['idrole_user_dokter'],
                [
                    'anamesis' => $data['anamesis'] ?? null,
                    'temuan_klinis' => $data['temuan_klinis'] ?? null,
                    'diagnosa' => $data['diagnosa'] ?? null,
                ]
            );

            return redirect()
                ->route('perawat.rekam-medis.show', $rekam->idrekam_medis)
                ->with('success', 'Kunjungan berhasil diselesaikan. Rekam medis telah dibuat.');
        } catch (\Throwable $e) {
            Log::error('Appointment complete failed', [
                'idreservasi' => $idreservasi,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
