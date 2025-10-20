<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\RasHewan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $pets = Pet::with(['user', 'rasHewan.jenisHewan'])->get();
        
        return view('admin.pet.index', compact('pets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $rasHewan = RasHewan::with('jenisHewan')->get();
        $users = User::all();
        
        return view('admin.pet.create', compact('rasHewan', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_pet' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Jantan,Betina',
            'warna' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
            'iduser' => 'required|exists:users,id',
        ]);

        Pet::create($validated);

        return redirect()
            ->route('admin.pet.index')
            ->with('success', 'Pet berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet): View
    {
        $pet->load(['user', 'rasHewan.jenisHewan']);
        
        return view('admin.pet.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet): View
    {
        $rasHewan = RasHewan::with('jenisHewan')->get();
        $users = User::all();
        
        return view('admin.pet.edit', compact('pet', 'rasHewan', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pet $pet): RedirectResponse
    {
        $validated = $request->validate([
            'nama_pet' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Jantan,Betina',
            'warna' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
            'iduser' => 'required|exists:users,id',
        ]);

        $pet->update($validated);

        return redirect()
            ->route('admin.pet.index')
            ->with('success', 'Pet berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet): RedirectResponse
    {
        $pet->delete();

        return redirect()
            ->route('admin.pet.index')
            ->with('success', 'Pet berhasil dihapus.');
    }
}
