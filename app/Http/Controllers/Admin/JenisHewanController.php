<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisHewan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JenisHewanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $jenisHewan = JenisHewan::withCount('pets')->get();
        
        return view('admin.jenis-hewan.index', compact('jenisHewan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.jenis-hewan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_jenis_hewan' => 'required|string|max:255|unique:jenis_hewan,nama_jenis_hewan',
        ]);

        JenisHewan::create($validated);

        return redirect()
            ->route('admin.jenis-hewan.index')
            ->with('success', 'Jenis hewan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisHewan $jenisHewan): View
    {
        $jenisHewan->load(['rasHewan.pets']);
        
        return view('admin.jenis-hewan.show', compact('jenisHewan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisHewan $jenisHewan): View
    {
        return view('admin.jenis-hewan.edit', compact('jenisHewan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisHewan $jenisHewan): RedirectResponse
    {
        $validated = $request->validate([
            'nama_jenis_hewan' => 'required|string|max:255|unique:jenis_hewan,nama_jenis_hewan,' . $jenisHewan->idjenis_hewan . ',idjenis_hewan',
        ]);

        $jenisHewan->update($validated);

        return redirect()
            ->route('admin.jenis-hewan.index')
            ->with('success', 'Jenis hewan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisHewan $jenisHewan): RedirectResponse
    {
        // Check if there are any related ras_hewan
        if ($jenisHewan->rasHewan()->exists()) {
            return redirect()
                ->route('admin.jenis-hewan.index')
                ->with('error', 'Tidak dapat menghapus jenis hewan yang masih memiliki ras hewan.');
        }

        $jenisHewan->delete();

        return redirect()
            ->route('admin.jenis-hewan.index')
            ->with('success', 'Jenis hewan berhasil dihapus.');
    }
}
