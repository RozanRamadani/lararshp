<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKlinis;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KategoriKlinisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $kategoriKlinis = KategoriKlinis::withCount('kodeTindakanTerapi')->get();
        
        return view('admin.kategori-klinis.index', compact('kategoriKlinis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.kategori-klinis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori_klinis' => 'required|string|max:255|unique:kategori_klinis,nama_kategori_klinis',
        ]);

        KategoriKlinis::create($validated);

        return redirect()
            ->route('admin.kategori-klinis.index')
            ->with('success', 'Kategori klinis berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriKlinis $kategoriKlini): View
    {
        $kategoriKlini->load(['kodeTindakanTerapi']);
        
        return view('admin.kategori-klinis.show', compact('kategoriKlini'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriKlinis $kategoriKlini): View
    {
        return view('admin.kategori-klinis.edit', compact('kategoriKlini'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriKlinis $kategoriKlini): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori_klinis' => 'required|string|max:255|unique:kategori_klinis,nama_kategori_klinis,' . $kategoriKlini->idkategori_klinis . ',idkategori_klinis',
        ]);

        $kategoriKlini->update($validated);

        return redirect()
            ->route('admin.kategori-klinis.index')
            ->with('success', 'Kategori klinis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriKlinis $kategoriKlini): RedirectResponse
    {
        // Check if there are any related kode_tindakan_terapi
        if ($kategoriKlini->kodeTindakanTerapi()->exists()) {
            return redirect()
                ->route('admin.kategori-klinis.index')
                ->with('error', 'Tidak dapat menghapus kategori klinis yang masih memiliki kode tindakan terapi.');
        }

        $kategoriKlini->delete();

        return redirect()
            ->route('admin.kategori-klinis.index')
            ->with('success', 'Kategori klinis berhasil dihapus.');
    }
}
