<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TemuDokter;
use App\Models\RekamMedis;

class UpdateAppointmentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointment:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status appointment yang sudah memiliki rekam medis dari Menunggu ke Check-in';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai update status appointment...');

        // Cari semua appointment yang:
        // 1. Status masih "Menunggu" (0)
        // 2. Sudah memiliki rekam medis
        $appointments = TemuDokter::where('status', TemuDokter::STATUS_MENUNGGU)
            ->whereHas('rekamMedis')
            ->get();

        if ($appointments->isEmpty()) {
            $this->info('Tidak ada appointment yang perlu diupdate.');
            return 0;
        }

        $count = 0;
        foreach ($appointments as $appointment) {
            $appointment->status = TemuDokter::STATUS_CHECKIN;
            $appointment->save();
            $count++;

            $this->line("Updated appointment ID: {$appointment->idreservasi_dokter}");
        }

        $this->info("Berhasil update {$count} appointment dari status Menunggu ke Check-in.");
        return 0;
    }
}
