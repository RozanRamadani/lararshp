<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\RasHewan;
use App\Models\Pemilik;
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
        // Load pets for table
        $pets = Pet::with(['user', 'rasHewan.jenisHewan'])->get();

        // Compute statistics explicitly (DB queries or optimized counts)
        $totalPets = Pet::count();

        // Count unique owners referenced by pets (unique idpemilik)
        $totalOwners = Pet::distinct('idpemilik')->count('idpemilik');

        $petJantan = Pet::where('jenis_kelamin', 'Jantan')->count();
        $petBetina = Pet::where('jenis_kelamin', 'Betina')->count();

        return view('admin.pet.index', compact('pets', 'totalPets', 'totalOwners', 'petJantan', 'petBetina'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $rasHewan = RasHewan::with('jenisHewan')->get();
        $pemilikList = Pemilik::with('user')->get();
        
        return view('admin.pet.create', compact('rasHewan', 'pemilikList'));
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
            'idpemilik' => 'required|exists:pemilik,idpemilik',
        ]);

        // Map field names to match Pet model fillable
        $petData = [
            'nama' => $validated['nama_pet'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'warna_tanda' => $validated['warna'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'idras_hewan' => $validated['idras_hewan'],
            'idpemilik' => $validated['idpemilik'],
        ];

        Pet::create($petData);

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
        $pemilikList = Pemilik::with('user')->get();
        
        return view('admin.pet.edit', compact('pet', 'rasHewan', 'pemilikList'));
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
            'idpemilik' => 'required|exists:pemilik,idpemilik',
        ]);

        // Map field names to match Pet model fillable
        $petData = [
            'nama' => $validated['nama_pet'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'warna_tanda' => $validated['warna'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'idras_hewan' => $validated['idras_hewan'],
            'idpemilik' => $validated['idpemilik'],
        ];

        $pet->update($petData);

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

    /**
     * Display pets owned by authenticated user (Pemilik only)
     */
    public function myPets(): View
    {
        $user = auth()->user();
        
        // Get pets milik user yang login
        $myPets = $user->pets()->with(['jenis_hewan', 'ras_hewan'])->get();
        
        return view('pemilik.my-pets', compact('myPets'));
    }

    /**
     * Display single pet detail owned by authenticated user (Pemilik only)
     */
    public function showMyPet(Pet $pet): View
    {
        $user = auth()->user();
        
        // Pastikan pet ini milik user yang login
        if (!$user->pets()->where('idpet', $pet->idpet)->exists()) {
            abort(403, 'Anda tidak memiliki akses ke data pet ini.');
        }
        
        $pet->load(['jenis_hewan', 'ras_hewan', 'pemilik.user']);
        
        return view('pemilik.my-pet-detail', compact('pet'));
    }
}
