<?php

namespace App\Services;

use App\Models\RekamMedis;
use App\Models\TemuDokter;
use App\Models\DetailRekamMedis;
use Illuminate\Support\Facades\DB;

class AppointmentService
{
    /**
     * Complete an appointment and create RekamMedis (and optional details) in a DB transaction.
     *
     * @param int $idreservasi_dokter
     * @param int $idrole_user_dokter  role_user.idrole_user
     * @param array $rekamPayload ['anamesis','temuan_klinis','diagnosa']
     * @param array $details optional: array of detail [{idkode_tindakan_terapi, keterangan}]
     * @return RekamMedis
     */
    public function completeVisit(int $idreservasi_dokter, int $idrole_user_dokter, array $rekamPayload, array $details = []): RekamMedis
    {
        return DB::transaction(function() use ($idreservasi_dokter, $idrole_user_dokter, $rekamPayload, $details) {
            $temu = TemuDokter::findOrFail($idreservasi_dokter);

            // Create rekam medis with timestamp
            $rekam = RekamMedis::create([
                'idreservasi_dokter' => $idreservasi_dokter,
                'anamesis' => $rekamPayload['anamesis'] ?? null,
                'temuan_klinis' => $rekamPayload['temuan_klinis'] ?? null,
                'diagnosa' => $rekamPayload['diagnosa'] ?? null,
                'dokter_pemeriksa' => $idrole_user_dokter,
                'created_at' => now(),
            ]);

            // Load relations for later use
            $rekam->load('temuDokter.pet.pemilik', 'temuDokter.roleUser.user');

            // Optionally insert detail_rekam_medis rows
            foreach ($details as $d) {
                $payload = [
                    'idrekam_medis' => $rekam->idrekam_medis,
                    'idkode_tindakan_terapi' => $d['idkode_tindakan_terapi'] ?? null,
                    'keterangan' => $d['keterangan'] ?? null,
                ];
                DetailRekamMedis::create($payload);
            }

            // Mark temu_dokter as selesai
            $temu->update([
                'status' => TemuDokter::STATUS_SELESAI
            ]);

            return $rekam;
        });
    }

    /**
     * Cancel an appointment (transactional)
     */
    public function cancelAppointment(int $idreservasi_dokter, ?string $alasan = null): TemuDokter
    {
        return DB::transaction(function() use ($idreservasi_dokter, $alasan) {
            $temu = TemuDokter::findOrFail($idreservasi_dokter);

            $temu->update([
                'status' => TemuDokter::STATUS_BATAL
            ]);

            return $temu;
        });
    }
}
