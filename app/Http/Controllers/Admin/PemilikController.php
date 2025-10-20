<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pemilik;
use App\Models\Pet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PemilikController extends Controller
{
    public function index()
    {
        $pemilik = Pemilik::with(['user', 'pets.rasHewan.jenisHewan'])->get();
        $totalPemilik = $pemilik->count();
        $totalPets = Pet::count();
        $aktivePemilik = $pemilik->count(); // Semua pemilik dianggap aktif
        $kunjunganBulanIni = 0; // Placeholder - nanti bisa ditambahkan logic untuk hitung kunjungan
        
        return view('admin.pemilik.index', compact(
            'pemilik', 
            'totalPemilik', 
            'totalPets',
            'aktivePemilik',
            'kunjunganBulanIni'
        ));
    }
}
