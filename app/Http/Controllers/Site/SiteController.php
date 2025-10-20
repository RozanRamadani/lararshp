<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function index()
    {
        return view('site.home', [
            'title' => 'Home'
        ]);
    }

    public function layanan()
    {
        return view('site.layanan', [
            'title' => 'Layanan'
        ]);
    }

    public function kontak()
    {
        return view('site.kontak', [
            'title' => 'Kontak'
        ]);
    }

    public function struktur()
    {
        return view('site.struktur', [
            'title' => 'Struktur Organisasi'
        ]);
    }

    public function cekKoneksi() {
        try {
            DB::connection()->getPdo();
            return "Koneksi database berhasil!";
        } catch (\Exception $e) {
            return "Koneksi database gagal: " . $e->getMessage();
        }
    }
}
