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

// Public Site Routes
Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/layanan', [SiteController::class, 'layanan'])->name('layanan');
Route::get('/kontak', [SiteController::class, 'kontak'])->name('kontak');
Route::get('/struktur', [SiteController::class, 'struktur'])->name('struktur');

// Admin Routes (require authentication)
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    
    // Data Management Dashboard
    Route::get('/data', [DataManagementController::class, 'index'])->name('data.index');
    
    // Resource Routes
    Route::resource('jenis-hewan', JenisHewanController::class);
    Route::resource('ras-hewan', RasHewanController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('kategori-klinis', KategoriKlinisController::class);
    Route::resource('kode-tindakan-terapi', KodeTindakanTerapiController::class);
    Route::resource('pet', PetController::class);
    Route::resource('role', RoleController::class);
    Route::resource('user', UserController::class);
    
    // Legacy routes for compatibility
    Route::get('/pemilik', [PemilikController::class, 'index'])->name('pemilik.index');
});

Route::get('/cek-koneksi', [SiteController::class, 'cekKoneksi'])->name('cek-koneksi');

// Admin Dashboard Routes (require authentication)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
