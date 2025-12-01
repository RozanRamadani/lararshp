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
     * Mendapatkan pesan validasi kustom dalam bahasa Indonesia
     */
    private function validationMessages(): array
    {
        return [
            'kode.required' => 'Kode tindakan wajib diisi.',
            'kode.string' => 'Kode tindakan harus berupa teks.',
            'kode.max' => 'Kode tindakan maksimal 50 karakter.',
            'kode.unique' => 'Kode tindakan sudah digunakan.',
            'deskripsi_tindakan_terapi.required' => 'Nama tindakan wajib diisi.',
            'deskripsi_tindakan_terapi.string' => 'Nama tindakan harus berupa teks.',
            'deskripsi_tindakan_terapi.max' => 'Nama tindakan maksimal 255 karakter.',
            'tarif.required' => 'Tarif wajib diisi.',
            'tarif.numeric' => 'Tarif harus berupa angka.',
            'tarif.min' => 'Tarif minimal 0.',
            'idkategori.required' => 'Kategori wajib dipilih.',
            'idkategori.exists' => 'Kategori yang dipilih tidak valid.',
            'idkategori_klinis.required' => 'Kategori klinis wajib dipilih.',
            'idkategori_klinis.exists' => 'Kategori klinis yang dipilih tidak valid.',
        ];
    }

    /**
     * Mendapatkan aturan validasi untuk store
     */
    private function storeValidationRules(): array
    {
        return [
            'kode' => 'required|string|max:50|unique:kode_tindakan_terapi,kode',
            'deskripsi_tindakan_terapi' => 'required|string|max:255',
            'tarif' => 'required|numeric|min:0',
            'idkategori' => 'required|exists:kategori,idkategori',
            'idkategori_klinis' => 'required|exists:kategori_klinis,idkategori_klinis',
        ];
    }

    /**
     * Mendapatkan aturan validasi untuk update
     */
    private function updateValidationRules(KodeTindakanTerapi $kodeTindakanTerapi): array
    {
        return [
            'kode' => 'required|string|max:50|unique:kode_tindakan_terapi,kode,' . $kodeTindakanTerapi->idkode_tindakan_terapi . ',idkode_tindakan_terapi',
            'deskripsi_tindakan_terapi' => 'required|string|max:255',
            'tarif' => 'required|numeric|min:0',
            'idkategori' => 'required|exists:kategori,idkategori',
            'idkategori_klinis' => 'required|exists:kategori_klinis,idkategori_klinis',
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = KodeTindakanTerapi::with(['kategori', 'kategoriKlinis']);

        if ($request->query('show_trashed')) {
            $query->onlyTrashed();
        }

        $kodeTindakan = $query->get();

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
        $validated = $request->validate(
            $this->storeValidationRules(),
            $this->validationMessages()
        );

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
        $validated = $request->validate(
            $this->updateValidationRules($kodeTindakanTerapi),
            $this->validationMessages()
        );

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

    /**
     * Restore soft deleted kode tindakan terapi
     */
    public function restore($id): RedirectResponse
    {
        $kodeTindakan = KodeTindakanTerapi::withTrashed()->findOrFail($id);
        $kodeTindakan->restore();

        return redirect()
            ->route('admin.kode-tindakan-terapi.index', ['show_trashed' => 1])
            ->with('success', 'Kode tindakan terapi berhasil dipulihkan.');
    }

    /**
     * Permanently delete kode tindakan terapi
     */
    public function forceDelete($id): RedirectResponse
    {
        $kodeTindakan = KodeTindakanTerapi::withTrashed()->findOrFail($id);
        $kodeTindakan->forceDelete();

        return redirect()
            ->route('admin.kode-tindakan-terapi.index', ['show_trashed' => 1])
            ->with('success', 'Kode tindakan terapi berhasil dihapus permanen.');
    }
}
