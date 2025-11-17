<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\RekamMedis;

try {
    $count = RekamMedis::whereHas('temuDokter', function($q){
        $q->whereIn('idpet', [11,13]);
    })->count();

    echo "RekamMedis count (pets 11,13): " . $count . PHP_EOL;
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    echo $e;
}
