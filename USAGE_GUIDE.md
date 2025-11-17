# Quick Reference - Model Usage

## RekamMedis Accessors (Sudah Diperbaiki)

### Medical Data
```php
$rekam = RekamMedis::find(3);

// Accessor untuk backward compatibility
$rekam->anamnesa;           // returns $this->anamesis
$rekam->pemeriksaan_fisik;  // returns $this->temuan_klinis  
$rekam->diagnosis;          // returns $this->diagnosa

// Direct DB columns
$rekam->anamesis;
$rekam->temuan_klinis;
$rekam->diagnosa;
```

### Patient & Owner Info
```php
// Get pet (via temuDokter relation)
$pet = $rekam->pet;  // Returns Pet model or null
$pet->nama;
$pet->jenisHewan->nama_jenis;
$pet->rasHewan->nama_ras;

// Get owner (via pet->pemilik)
$owner = $rekam->owner;  // Returns Pemilik model or null
$owner->nama;
$owner->alamat;
```

### Doctor Info
```php
// Get dokter (resolved via RoleUser -> User)
$dokter = $rekam->dokter;  // Returns User model or null
$dokter->nama;
$dokter->email;

// Role info
$roleUser = $rekam->temuDokter->roleUser;
$roleUser->role->nama_role;  // 'Dokter', 'Perawat', etc
```

### Details/Procedures
```php
// Get all procedures
$details = $rekam->details;

foreach ($details as $detail) {
    $detail->kodeTindakanTerapi->nama_tindakan;
    $detail->keterangan;
}
```

## Blade View Usage

### Show Patient Info
```blade
<div class="patient-info">
    <h3>{{ $rekamMedis->pet?->nama ?? 'Unknown Pet' }}</h3>
    <p>Owner: {{ $rekamMedis->owner?->nama ?? 'Not recorded' }}</p>
    <p>Species: {{ $rekamMedis->pet?->jenisHewan?->nama_jenis ?? '-' }}</p>
    <p>Breed: {{ $rekamMedis->pet?->rasHewan?->nama_ras ?? '-' }}</p>
</div>
```

### Show Medical Info
```blade
<div class="medical-info">
    <h4>Anamnesa</h4>
    <p>{{ $rekamMedis->anamnesa ?? 'Not recorded' }}</p>
    
    <h4>Pemeriksaan Fisik</h4>
    <p>{{ $rekamMedis->pemeriksaan_fisik ?? 'Not recorded' }}</p>
    
    <h4>Diagnosis</h4>
    <p>{{ $rekamMedis->diagnosis ?? 'Not recorded' }}</p>
</div>
```

### Show Doctor Info
```blade
<div class="doctor-info">
    <p>Dokter: {{ $rekamMedis->dokter?->nama ?? 'Not assigned' }}</p>
    <p>Email: {{ $rekamMedis->dokter?->email ?? '-' }}</p>
</div>
```

### Show Procedures
```blade
<div class="procedures">
    <h4>Tindakan/Terapi</h4>
    @forelse($rekamMedis->details as $detail)
        <div class="procedure-item">
            <strong>{{ $detail->kodeTindakanTerapi?->nama_tindakan ?? 'N/A' }}</strong>
            <p>{{ $detail->keterangan ?? 'No notes' }}</p>
        </div>
    @empty
        <p>No procedures recorded</p>
    @endforelse
</div>
```

## Controller Usage

### Eager Load untuk Performance
```php
// Di index/show methods
$rekamMedis = RekamMedis::with([
    'temuDokter.pet.pemilik',
    'temuDokter.pet.jenisHewan',
    'temuDokter.pet.rasHewan',
    'temuDokter.roleUser.user',
    'temuDokter.roleUser.role',
    'details.kodeTindakanTerapi'
])->get();
```

### Create RekamMedis (Transactional)
```php
use App\Services\AppointmentService;

public function complete(Request $request, $idreservasi)
{
    $service = app(AppointmentService::class);
    
    $validated = $request->validate([
        'idrole_user_dokter' => 'required|integer|exists:role_user,idrole_user',
        'anamesis' => 'nullable|string|max:1000',
        'temuan_klinis' => 'nullable|string|max:1000',
        'diagnosa' => 'nullable|string|max:1000',
    ]);
    
    $rekam = $service->completeVisit(
        $idreservasi,
        $validated['idrole_user_dokter'],
        [
            'anamesis' => $validated['anamesis'],
            'temuan_klinis' => $validated['temuan_klinis'],
            'diagnosa' => $validated['diagnosa'],
        ]
    );
    
    return redirect()->route('perawat.rekam-medis.show', $rekam);
}
```

## Query Examples

### Find by Pet
```php
$rekamMedis = RekamMedis::whereHas('temuDokter', function($q) use ($idpet) {
    $q->where('idpet', $idpet);
})->get();
```

### Find by Doctor
```php
$rekamMedis = RekamMedis::whereHas('temuDokter.roleUser', function($q) use ($iduser) {
    $q->where('iduser', $iduser);
})->get();
```

### Find by Date Range
```php
$rekamMedis = RekamMedis::whereBetween('created_at', [$start, $end])
    ->with('temuDokter.pet')
    ->get();
```

### Find Pending Appointments
```php
use App\Models\TemuDokter;

$pending = TemuDokter::where('status', TemuDokter::STATUS_MENUNGGU)
    ->with('pet', 'roleUser.user')
    ->get();
```

## Common Patterns

### Check if RekamMedis exists for appointment
```php
$temu = TemuDokter::find($id);
$hasRekamMedis = RekamMedis::where('idreservasi_dokter', $temu->idreservasi_dokter)->exists();

if (!$hasRekamMedis) {
    // Show complete visit button
}
```

### Get stats for dashboard
```php
// Total visits for a pet
$totalVisits = RekamMedis::whereHas('temuDokter', function($q) use ($idpet) {
    $q->where('idpet', $idpet);
})->count();

// Visits by doctor
$doctorVisits = RekamMedis::where('dokter_pemeriksa', $idrole_user)->count();

// Recent visits
$recent = RekamMedis::with('temuDokter.pet')
    ->orderBy('created_at', 'desc')
    ->take(10)
    ->get();
```
