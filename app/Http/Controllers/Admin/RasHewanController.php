<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RasHewan;
use App\Models\JenisHewan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RasHewanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $rasHewan = RasHewan::with(['jenisHewan'])->withCount('pets')->get();
        
        return view('admin.ras-hewan.index', compact('rasHewan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $jenisHewan = JenisHewan::all();
        
        return view('admin.ras-hewan.create', compact('jenisHewan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_ras' => 'required|string|max:255',
            'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan',
        ]);

        RasHewan::create($validated);

        return redirect()
            ->route('admin.ras-hewan.index')
            ->with('success', 'Ras hewan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RasHewan $rasHewan): View
    {
        $rasHewan->load(['jenisHewan', 'pets']);
        
        return view('admin.ras-hewan.show', compact('rasHewan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RasHewan $rasHewan): View
    {
        $jenisHewan = JenisHewan::all();
        
        return view('admin.ras-hewan.edit', compact('rasHewan', 'jenisHewan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RasHewan $rasHewan): RedirectResponse
    {
        $validated = $request->validate([
            'nama_ras' => 'required|string|max:255',
            'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan',
        ]);

        $rasHewan->update($validated);

        return redirect()
            ->route('admin.ras-hewan.index')
            ->with('success', 'Ras hewan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RasHewan $rasHewan): RedirectResponse
    {
        // Check if there are any related pets
        if ($rasHewan->pets()->exists()) {
            return redirect()
                ->route('admin.ras-hewan.index')
                ->with('error', 'Tidak dapat menghapus ras hewan yang masih memiliki pets.');
        }

        $rasHewan->delete();

        return redirect()
            ->route('admin.ras-hewan.index')
            ->with('success', 'Ras hewan berhasil dihapus.');
    }
}
