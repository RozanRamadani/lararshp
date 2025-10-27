<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KategoriController extends Controller
{
    
    // Menampilkan daftar kategori
    public function index(): View
    {
        // Mengambil semua kategori beserta jumlah kode tindakan terapi terkait
        $kategori = Kategori::withCount('kodeTindakanTerapi')->get();
        
        return view('admin.kategori.index', compact('kategori'));
    }

    // Menampilkan form untuk membuat kategori baru
    public function create(): View
    {
        return view('admin.kategori.create');
    }

    // Menyimpan kategori baru ke dalam database
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori',
        ]);

        // Simpan kategori baru
        Kategori::create($validated);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Menampilkan detail kategori beserta kode tindakan terapi terkait
    public function show(Kategori $kategori): View
    {
        // Muat relasi kode tindakan terapi terkait
        $kategori->load(['kodeTindakanTerapi']);
        
        return view('admin.kategori.show', compact('kategori'));
    }

    // Menampilkan form untuk mengedit kategori
    public function edit(Kategori $kategori): View
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    // Memperbarui data kategori di database
    public function update(Request $request, Kategori $kategori): RedirectResponse
    {
        // Validasi input
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $kategori->idkategori . ',idkategori',
        ]);

        $kategori->update($validated);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori): RedirectResponse
    {
        // Check if there are any related kode_tindakan_terapi
        if ($kategori->kodeTindakanTerapi()->exists()) {
            return redirect()
                ->route('admin.kategori.index')
                ->with('error', 'Tidak dapat menghapus kategori yang masih memiliki kode tindakan terapi.');
        }

        $kategori->delete();

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
