<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodeTindakanTerapi;
use App\Models\Kategori;
use App\Models\KategoriKlinis;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KodeTindakanTerapiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $kodeTindakan = KodeTindakanTerapi::with(['kategori', 'kategoriKlinis'])->get();
        
        return view('admin.kode-tindakan-terapi.index', compact('kodeTindakan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $kategori = Kategori::all();
        $kategoriKlinis = KategoriKlinis::all();
        
        return view('admin.kode-tindakan-terapi.create', compact('kategori', 'kategoriKlinis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_tindakan' => 'required|string|max:50|unique:kode_tindakan_terapi,kode_tindakan',
            'nama_tindakan' => 'required|string|max:255',
            'tarif' => 'required|numeric|min:0',
            'idkategori' => 'required|exists:kategori,idkategori',
            'idkategori_klinis' => 'required|exists:kategori_klinis,idkategori_klinis',
        ]);

        KodeTindakanTerapi::create($validated);

        return redirect()
            ->route('admin.kode-tindakan-terapi.index')
            ->with('success', 'Kode tindakan terapi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KodeTindakanTerapi $kodeTindakanTerapi): View
    {
        $kodeTindakanTerapi->load(['kategori', 'kategoriKlinis']);
        
        return view('admin.kode-tindakan-terapi.show', compact('kodeTindakanTerapi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KodeTindakanTerapi $kodeTindakanTerapi): View
    {
        $kategori = Kategori::all();
        $kategoriKlinis = KategoriKlinis::all();
        
        return view('admin.kode-tindakan-terapi.edit', compact('kodeTindakanTerapi', 'kategori', 'kategoriKlinis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KodeTindakanTerapi $kodeTindakanTerapi): RedirectResponse
    {
        $validated = $request->validate([
            'kode_tindakan' => 'required|string|max:50|unique:kode_tindakan_terapi,kode_tindakan,' . $kodeTindakanTerapi->idkode_tindakan_terapi . ',idkode_tindakan_terapi',
            'nama_tindakan' => 'required|string|max:255',
            'tarif' => 'required|numeric|min:0',
            'idkategori' => 'required|exists:kategori,idkategori',
            'idkategori_klinis' => 'required|exists:kategori_klinis,idkategori_klinis',
        ]);

        $kodeTindakanTerapi->update($validated);

        return redirect()
            ->route('admin.kode-tindakan-terapi.index')
            ->with('success', 'Kode tindakan terapi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KodeTindakanTerapi $kodeTindakanTerapi): RedirectResponse
    {
        $kodeTindakanTerapi->delete();

        return redirect()
            ->route('admin.kode-tindakan-terapi.index')
            ->with('success', 'Kode tindakan terapi berhasil dihapus.');
    }
}
