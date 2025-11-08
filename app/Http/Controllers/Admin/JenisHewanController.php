<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisHewan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JenisHewanController extends Controller
{
    // Menampilkan daftar jenis hewan
    public function index(): View
    {
        // Mengambil semua jenis hewan beserta jumlah hewan terkait
        $jenisHewan = JenisHewan::withCount('pets')->get();

        return view('admin.jenis-hewan.index', compact('jenisHewan'));
    }


    // Menampilkan form untuk membuat jenis hewan baru
    public function create(): View
    {
        return view('admin.jenis-hewan.create');
    }

    // Menyimpan jenis hewan baru ke dalam database
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_jenis_hewan' => 'required|string|max:255|unique:jenis_hewan,nama_jenis_hewan',
        ], [
            'nama_jenis_hewan.required' => 'Nama jenis hewan wajib diisi.',
            'nama_jenis_hewan.string' => 'Nama jenis hewan harus berupa teks.',
            'nama_jenis_hewan.max' => 'Nama jenis hewan maksimal 255 karakter.',
            'nama_jenis_hewan.unique' => 'Nama jenis hewan sudah terdaftar.',
        ]);

        JenisHewan::create($validated);

        return redirect()
            ->route('admin.jenis-hewan.index')
            ->with('success', 'Jenis hewan berhasil ditambahkan.');
    }

    // Menampilkan detail jenis hewan beserta ras dan hewan terkait
    public function show(JenisHewan $jenisHewan): View
    {
        // Muat relasi ras hewan dan hewan terkait
        $jenisHewan->load(['rasHewan.pets']);

        return view('admin.jenis-hewan.show', compact('jenisHewan'));
    }

    // Menampilkan form untuk mengedit jenis hewan
    public function edit(JenisHewan $jenisHewan): View
    {
        return view('admin.jenis-hewan.edit', compact('jenisHewan'));
    }

    // Memperbarui data jenis hewan di database
    public function update(Request $request, JenisHewan $jenisHewan): RedirectResponse
    {
        $validated = $request->validate([
            'nama_jenis_hewan' => 'required|string|max:255|unique:jenis_hewan,nama_jenis_hewan,' . $jenisHewan->idjenis_hewan . ',idjenis_hewan',
        ], [
            'nama_jenis_hewan.required' => 'Nama jenis hewan wajib diisi.',
            'nama_jenis_hewan.string' => 'Nama jenis hewan harus berupa teks.',
            'nama_jenis_hewan.max' => 'Nama jenis hewan maksimal 255 karakter.',
            'nama_jenis_hewan.unique' => 'Nama jenis hewan sudah terdaftar.',
        ]);

        $jenisHewan->update($validated);

        return redirect()
            ->route('admin.jenis-hewan.index')
            ->with('success', 'Jenis hewan berhasil diperbarui.');
    }

    // Menghapus jenis hewan dari database
    public function destroy(JenisHewan $jenisHewan): RedirectResponse
    {
        // Cek apakah ada ras hewan terkait sebelum menghapus
        if ($jenisHewan->rasHewan()->exists()) {
            return redirect()
                ->route('admin.jenis-hewan.index')
                ->with('error', 'Tidak dapat menghapus jenis hewan yang masih memiliki ras hewan.');
        }

        // Hapus jenis hewan
        $jenisHewan->delete();

        return redirect()
            ->route('admin.jenis-hewan.index')
            ->with('success', 'Jenis hewan berhasil dihapus.');
    }
}
