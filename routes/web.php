<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Admin\PemilikController;
use App\Http\Controllers\Admin\JenisHewanController;
use App\Http\Controllers\Admin\RasHewanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\KategoriKlinisController;
use App\Http\Controllers\Admin\KodeTindakanTerapiController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DataManagementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RekamMedisController;
use App\Http\Controllers\Admin\TemuDokterController;
use App\Http\Controllers\Admin\AppointmentTransactionController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\PerawatController;
use App\Http\Controllers\Admin\ResepsionisController;
use App\Http\Controllers\Admin\DetailRekamMedisController;

// Public Site Routes
Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/layanan', [SiteController::class, 'layanan'])->name('layanan');
Route::get('/kontak', [SiteController::class, 'kontak'])->name('kontak');
Route::get('/struktur', [SiteController::class, 'struktur'])->name('struktur');

// 1. ADMINISTRATOR ROUTES (Role ID: 1)
// Kewenangan: Full access - Manajemen User, Role, dan semua Data Master
Route::middleware(['auth', 'verified', 'role:Administrator'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // User & Role Management
        Route::resource('user', UserController::class);

        // User Role Management routes
        Route::get('user/{user}/manage-roles', [UserController::class, 'manageRoles'])->name('user.manage-roles');
        Route::post('user/{user}/attach-role', [UserController::class, 'attachRole'])->name('user.attach-role');
        Route::patch('user/{user}/role/{roleUser}/status', [UserController::class, 'updateRoleStatus'])->name('user.update-role-status');
        Route::delete('user/{user}/role/{roleUser}', [UserController::class, 'detachRole'])->name('user.detach-role');

        Route::resource('role', RoleController::class);

        // Data Master Management (Full CRUD)
        Route::resource('jenis-hewan', JenisHewanController::class);
        Route::resource('ras-hewan', RasHewanController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('kategori-klinis', KategoriKlinisController::class);
        Route::resource('kode-tindakan-terapi', KodeTindakanTerapiController::class);
        Route::resource('pet', PetController::class);
        Route::resource('pemilik', PemilikController::class);

        // Staff Management (Dokter, Perawat & Resepsionis)
        Route::resource('dokter', DokterController::class);
        Route::resource('perawat', PerawatController::class);
        Route::resource('resepsionis', ResepsionisController::class);

        // Upgrade user to pemilik
        Route::post('pemilik/upgrade-user', [PemilikController::class, 'upgradeUser'])->name('pemilik.upgrade-user');

        // Data Management Dashboard
        Route::get('/data', [DataManagementController::class, 'index'])->name('data.index');
    });

// 2. DOKTER ROUTES (Role ID: 2)
// Kewenangan: Read-only data pasien dan rekam medis
Route::middleware(['auth', 'verified', 'role:Administrator,Dokter'])
    ->prefix('dokter')
    ->name('dokter.')
    ->group(function () {
        // View Only - Jenis & Ras Hewan
        Route::get('jenis-hewan', [JenisHewanController::class, 'index'])->name('jenis-hewan.index');
        Route::get('jenis-hewan/{jenis_hewan}', [JenisHewanController::class, 'show'])->name('jenis-hewan.show');
        Route::get('ras-hewan', [RasHewanController::class, 'index'])->name('ras-hewan.index');
        Route::get('ras-hewan/{ras_hewan}', [RasHewanController::class, 'show'])->name('ras-hewan.show');

        // View Only - Pet/Pasien
        Route::get('pasien', [PetController::class, 'index'])->name('pasien.index');
        Route::get('pasien/{pet}', [PetController::class, 'show'])->name('pasien.show');

        // Read-only Rekam Medis
        Route::get('rekam-medis', [RekamMedisController::class, 'index'])->name('rekam-medis.index');
        Route::get('rekam-medis/{rekamMedis}', [RekamMedisController::class, 'show'])->name('rekam-medis.show');
        Route::get('pasien/{pet}/rekam-medis', [RekamMedisController::class, 'petRecords'])->name('pasien.rekam-medis');

        // Full CRUD Detail Rekam Medis (Dokter can add treatments/procedures)
        Route::prefix('rekam-medis/{rekam_medis}/detail')->name('rekam-medis.detail.')->group(function () {
            Route::get('/', [DetailRekamMedisController::class, 'index'])->name('index');
            Route::get('create', [DetailRekamMedisController::class, 'create'])->name('create');
            Route::post('/', [DetailRekamMedisController::class, 'store'])->name('store');
            Route::get('{detail}', [DetailRekamMedisController::class, 'show'])->name('show');
            Route::get('{detail}/edit', [DetailRekamMedisController::class, 'edit'])->name('edit');
            Route::put('{detail}', [DetailRekamMedisController::class, 'update'])->name('update');
            Route::delete('{detail}', [DetailRekamMedisController::class, 'destroy'])->name('destroy');
        });
    });

// 3. PERAWAT ROUTES (Role ID: 3)
// Kewenangan: Full CRUD rekam medis, view data pasien
Route::middleware(['auth', 'verified', 'role:Administrator,Perawat'])
    ->prefix('perawat')
    ->name('perawat.')
    ->group(function () {
        // View Data Pasien
        Route::get('pasien', [PetController::class, 'index'])->name('pasien.index');
        Route::get('pasien/{pet}', [PetController::class, 'show'])->name('pasien.show');

        // Full CRUD Rekam Medis
        Route::resource('rekam-medis', RekamMedisController::class);
        // Transactional endpoint to complete an appointment and create RekamMedis
        Route::post('rekam-medis/{idreservasi}/complete', [AppointmentTransactionController::class, 'complete'])->name('rekam-medis.complete');
        Route::get('pasien/{pet}/rekam-medis', [RekamMedisController::class, 'petRecords'])->name('pasien.rekam-medis');

        // View Only Detail Rekam Medis (Perawat can only view treatments/procedures added by Dokter)
        Route::prefix('rekam-medis/{rekam_medis}/detail')->name('rekam-medis.detail.')->group(function () {
            Route::get('/', [DetailRekamMedisController::class, 'index'])->name('index');
            Route::get('{detail}', [DetailRekamMedisController::class, 'show'])->name('show');
        });
    });

// 4. RESEPSIONIS ROUTES (Role ID: 4)
// Kewenangan: Manajemen pemilik/pet untuk reservasi
Route::middleware(['auth', 'verified', 'role:Administrator,Resepsionis'])
    ->prefix('resepsionis')
    ->name('resepsionis.')
    ->group(function () {
        // Upgrade user to pemilik (must be before resource route)
        Route::post('pemilik/upgrade-user', [PemilikController::class, 'upgradeUser'])->name('pemilik.upgrade-user');

        // Manajemen Pemilik (CRUD untuk registrasi)
        Route::resource('pemilik', PemilikController::class);

        // Manajemen Pet (CRUD)
        Route::resource('pet', PetController::class);

        // Manajemen Appointment/Reservasi
        Route::resource('temu-dokter', TemuDokterController::class);
    });

// 5. PEMILIK/OWNER ROUTES (Role ID: 5)
// Kewenangan: View only data pet dan rekam medis sendiri
Route::middleware(['auth', 'verified', 'role:Pemilik'])
    ->prefix('pemilik')
    ->name('pemilik.')
    ->group(function () {
        // View Only - Pet Pribadi
        Route::get('my-pets', [PetController::class, 'myPets'])->name('my-pets');
        Route::get('my-pets/{pet}', [PetController::class, 'showMyPet'])->name('my-pets.show');

        // View Only - Rekam Medis Pet Sendiri
        Route::get('my-pets/{pet}/rekam-medis', [RekamMedisController::class, 'petRecords'])->name('my-pets.rekam-medis');

        // View Only - Appointment Sendiri
        Route::get('my-appointments', [TemuDokterController::class, 'myAppointments'])->name('my-appointments');
    });

Route::get('/cek-koneksi', [SiteController::class, 'cekKoneksi'])->name('cek-koneksi');

// Dashboard Route (authenticated users - role-based dashboard)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Freepik proxy (used by icon fallback)
use App\Http\Controllers\FreepikController;
Route::get('/freepik/proxy', [FreepikController::class, 'proxy'])->name('freepik.proxy')->middleware('throttle:30,1');

// Icon test page (untuk debug Flaticon)
Route::get('/test-icons', function () {
    return view('test-icons');
})->name('test-icons');
