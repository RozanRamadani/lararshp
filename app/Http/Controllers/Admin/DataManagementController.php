<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisHewan;
use App\Models\RasHewan;
use App\Models\Kategori;
use App\Models\KategoriKlinis;
use App\Models\KodeTindakanTerapi;
use App\Models\Pet;
use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;

class DataManagementController extends Controller
{
    /**
     * Display the data management dashboard.
     */
    public function index(): View
    {
        $stats = [
            'jenis_hewan' => JenisHewan::count(),
            'ras_hewan' => RasHewan::count(),
            'kategori' => Kategori::count(),
            'kategori_klinis' => KategoriKlinis::count(),
            'kode_tindakan_terapi' => KodeTindakanTerapi::count(),
            'pets' => Pet::count(),
            'roles' => Role::count(),
            'users' => User::count(),
        ];

        return view('admin.data.index', compact('stats'));
    }
}
