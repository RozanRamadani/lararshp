<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\RekamMedis;

$rekam = RekamMedis::with(['temuDokter.pet.pemilik', 'temuDokter.roleUser.user', 'details.kodeTindakanTerapi'])->first();
if (!$rekam) {
    echo "No RekamMedis records found\n";
    exit(0);
}

echo "=== REKAM MEDIS TEST ===\n\n";
echo "RekamMedis ID: " . ($rekam->idrekam_medis ?? 'n/a') . "\n";
echo "Created: " . ($rekam->created_at ?? 'n/a') . "\n\n";

echo "--- Medical Data (using accessors) ---\n";
echo "Anamnesa: " . ($rekam->anamnesa ?? '-') . "\n";
echo "Pemeriksaan Fisik: " . ($rekam->pemeriksaan_fisik ?? '-') . "\n";
echo "Diagnosis: " . ($rekam->diagnosis ?? '-') . "\n\n";

echo "--- Patient Info (using pet accessor) ---\n";
$pet = $rekam->pet;
if ($pet) {
    echo "Pet: " . ($pet->nama ?? '-') . " (ID: " . ($pet->idpet ?? '-') . ")\n";
    echo "Species: " . ($pet->jenisHewan->nama_jenis ?? '-') . "\n";
    echo "Breed: " . ($pet->rasHewan->nama_ras ?? '-') . "\n";
    $owner = $rekam->owner;
    echo "Owner: " . ($owner->nama ?? '-') . " (ID: " . ($owner->idpemilik ?? '-') . ")\n";
} else {
    echo "Pet: Not found\n";
    echo "Owner: Not found\n";
}

echo "\n--- Doctor Info (using dokter accessor) ---\n";
$dokter = $rekam->dokter;
if ($dokter) {
    echo "Dokter: " . ($dokter->nama ?? '-') . " (ID: " . ($dokter->iduser ?? '-') . ")\n";
    echo "Email: " . ($dokter->email ?? '-') . "\n";
} else {
    echo "Dokter: Not assigned\n";
}

echo "\n--- Details/Procedures ---\n";
if ($rekam->details && $rekam->details->count() > 0) {
    foreach ($rekam->details as $detail) {
        $tindakan = $detail->kodeTindakanTerapi;
        echo "- " . ($tindakan->nama_tindakan ?? 'N/A') . ": " . ($detail->keterangan ?? 'No notes') . "\n";
    }
} else {
    echo "No procedures recorded\n";
}

echo "\n--- Relation Status ---\n";
echo "temuDokter loaded: " . ($rekam->relationLoaded('temuDokter') ? 'yes' : 'no') . "\n";
echo "temuDokter.roleUser loaded: " . ($rekam->temuDokter && $rekam->temuDokter->relationLoaded('roleUser') ? 'yes' : 'no') . "\n";
echo "details loaded: " . ($rekam->relationLoaded('details') ? 'yes' : 'no') . "\n";

echo "\n=== TEST COMPLETE ===\n";

