<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\RasHewan;
use App\Models\Pemilik;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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

        $petJantan = Pet::where('jenis_kelamin', 'J')->count();
        $petBetina = Pet::where('jenis_kelamin', 'B')->count();

        return view('admin.pet.index', compact('pets', 'totalPets', 'totalOwners', 'petJantan', 'petBetina'));
    }

    /**
     * Helper: pesan validasi kustom
     */
    private function validationMessages(): array
    {
        return [
            'nama_pet.required' => 'Nama pet wajib diisi.',
            'nama_pet.string' => 'Nama pet harus berupa teks.',
            'nama_pet.min' => 'Nama pet minimal 2 karakter.',
            'nama_pet.max' => 'Nama pet maksimal 255 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'idras_hewan.required' => 'Ras hewan wajib dipilih.',
            'idras_hewan.exists' => 'Ras hewan tidak ditemukan.',
            'idpemilik.required' => 'Pemilik wajib dipilih.',
            'idpemilik.exists' => 'Pemilik tidak ditemukan.',
        ];
    }

    /**
     * Helper: aturan validasi store
     */
    private function storeValidationRules(): array
    {
        return [
            'nama_pet' => 'required|string|min:2|max:255',
            'jenis_kelamin' => 'required|in:J,B',
            'warna' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date|before_or_equal:today',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
            'idpemilik' => 'required|exists:pemilik,idpemilik',
        ];
    }

    /**
     * Helper: aturan validasi update
     */
    private function updateValidationRules(Pet $pet): array
    {
        // Sama dengan store untuk kasus ini
        return $this->storeValidationRules();
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
        // Validasi
        $validated = $request->validate($this->storeValidationRules(), $this->validationMessages());

        try {
            DB::beginTransaction();

            Pet::create([
                'nama' => ucwords(strtolower($validated['nama_pet'])),
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'warna_tanda' => $validated['warna'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'idras_hewan' => $validated['idras_hewan'],
                'idpemilik' => $validated['idpemilik'],
            ]);

            DB::commit();
            $indexRoute = request()->routeIs('resepsionis.pet.*') || request()->is('resepsionis/*') ? 'resepsionis.pet.index' : 'admin.pet.index';
            return redirect()->route($indexRoute)->with('success', 'Pet berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create pet: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menambahkan pet.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet): View
    {
        $pet->load([
            'user',
            'rasHewan.jenisHewan',
            'pemilik.user',
            'rekamMedis' => function($query) {
                $query->with(['detailRekamMedis'])
                      ->orderBy('created_at', 'desc')
                      ->limit(10);
            },
            'temuDokter' => function($query) {
                $query->orderBy('waktu_daftar', 'desc')
                      ->limit(10);
            }
        ]);

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
        // Validasi
        $validated = $request->validate($this->updateValidationRules($pet), $this->validationMessages());

        try {
            DB::beginTransaction();

            $pet->update([
                'nama' => ucwords(strtolower($validated['nama_pet'])),
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'warna_tanda' => $validated['warna'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'idras_hewan' => $validated['idras_hewan'],
                'idpemilik' => $validated['idpemilik'],
            ]);

            DB::commit();
            $indexRoute = request()->routeIs('resepsionis.pet.*') || request()->is('resepsionis/*') ? 'resepsionis.pet.index' : 'admin.pet.index';
            return redirect()->route($indexRoute)->with('success', 'Pet berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update pet: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui pet.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Check if pet has related records
            $hasTemuDokter = $pet->temuDokter()->exists();
            $hasRekamMedis = $pet->rekamMedis()->exists();

            if ($hasTemuDokter || $hasRekamMedis) {
                DB::rollBack();
                return back()->with('error', 'Tidak dapat menghapus pet karena masih memiliki data rekam medis atau temu dokter. Hapus data tersebut terlebih dahulu.');
            }

            $pet->delete();
            DB::commit();

            $indexRoute = request()->routeIs('resepsionis.pet.*') || request()->is('resepsionis/*') ? 'resepsionis.pet.index' : 'admin.pet.index';
            return redirect()->route($indexRoute)->with('success', 'Pet berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete pet: ' . $e->getMessage());

            // Specific message for foreign key constraint
            if (str_contains($e->getMessage(), 'foreign key constraint')) {
                return back()->with('error', 'Tidak dapat menghapus pet karena masih terkait dengan data lain di sistem.');
            }

            return back()->with('error', 'Gagal menghapus pet.');
        }
    }

    /**
     * Display pets owned by authenticated user (Pemilik only)
     */
    public function myPets(): View
    {
        $myPets = auth()->user()->pets()->with(['jenis_hewan', 'ras_hewan'])->get();
        return view('pemilik.my-pets', compact('myPets'));
    }

    /**
     * Display single pet detail owned by authenticated user (Pemilik only)
     */
    public function showMyPet(Pet $pet): View
    {
        if (!auth()->user()->pets()->where('idpet', $pet->idpet)->exists()) {
            abort(403, 'Anda tidak memiliki akses ke data pet ini.');
        }

        $pet->load([
            'jenis_hewan',
            'ras_hewan',
            'pemilik.user',
            'rekamMedis' => function($query) {
                $query->with(['detailRekamMedis'])
                      ->orderBy('created_at', 'desc')
                      ->limit(10);
            },
            'temuDokter' => function($query) {
                $query->where('waktu_daftar', '>=', now())
                      ->orderBy('waktu_daftar', 'asc');
            }
        ]);

        return view('pemilik.my-pet-detail', compact('pet'));
    }
}
