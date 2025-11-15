<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JenisHewanController extends Controller
{
    /**
     * Helper: Pesan validasi kustom dalam Bahasa Indonesia
     */
    private function validationMessages(): array
    {
        return [
            'nama_jenis_hewan.required' => 'Nama jenis hewan wajib diisi.',
            'nama_jenis_hewan.string' => 'Nama jenis hewan harus berupa teks.',
            'nama_jenis_hewan.max' => 'Nama jenis hewan maksimal 255 karakter.',
            'nama_jenis_hewan.unique' => 'Nama jenis hewan sudah terdaftar.',
        ];
    }

    /**
     * Helper: Aturan validasi untuk store
     */
    private function storeValidationRules(): array
    {
        return [
            'nama_jenis_hewan' => 'required|string|max:255|unique:jenis_hewan,nama_jenis_hewan',
        ];
    }

    /**
     * Helper: Aturan validasi untuk update
     */
    private function updateValidationRules($id): array
    {
        return [
            // $id is the idjenis_hewan value
            'nama_jenis_hewan' => 'required|string|max:255|unique:jenis_hewan,nama_jenis_hewan,' . (int) $id . ',idjenis_hewan',
        ];
    }

    // Menampilkan daftar jenis hewan (query builder)
    public function index(): View
    {
        // Mengambil semua jenis_hewan beserta jumlah pets terkait (melalui ras_hewan)
        $jenisHewan = DB::table('jenis_hewan')
            ->select('jenis_hewan.*', DB::raw('(select count(*) from pet join ras_hewan on pet.idras_hewan = ras_hewan.idras_hewan where ras_hewan.idjenis_hewan = jenis_hewan.idjenis_hewan) as pets_count'))
            ->get();

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
        $validated = $request->validate(
            $this->storeValidationRules(),
            $this->validationMessages()
        );

        // Simpan jenis hewan baru menggunakan Query Builder
        DB::table('jenis_hewan')->insert([
            'nama_jenis_hewan' => $validated['nama_jenis_hewan']
        ]);

        return redirect()
            ->route('admin.jenis-hewan.index')
            ->with('success', 'Jenis hewan berhasil ditambahkan.');
    }

    // Menampilkan detail jenis hewan beserta ras dan hewan terkait
    public function show($id): View
    {
        // Ambil jenis hewan
        $jenisHewan = DB::table('jenis_hewan')->where('idjenis_hewan', $id)->first();
        if (! $jenisHewan) {
            abort(404);
        }

        // Muat relasi ras_hewan dan masing-masing pets (simple eager-loading)
        $ras = DB::table('ras_hewan')->where('idjenis_hewan', $id)->get();
        // attach pets collection to each ras
        $ras = $ras->map(function ($r) {
            $r->pets = DB::table('pet')->where('idras_hewan', $r->idras_hewan)->get();
            return $r;
        });

        // attach property name expected by views
        $jenisHewan->rasHewan = $ras;

        return view('admin.jenis-hewan.show', compact('jenisHewan'));
    }

    // Menampilkan form untuk mengedit jenis hewan
    public function edit($id): View
    {
        $jenisHewan = DB::table('jenis_hewan')
            ->select('jenis_hewan.*', DB::raw('(select count(*) from pet join ras_hewan on pet.idras_hewan = ras_hewan.idras_hewan where ras_hewan.idjenis_hewan = jenis_hewan.idjenis_hewan) as pets_count'))
            ->where('idjenis_hewan', $id)
            ->first();

        if (! $jenisHewan) {
            abort(404);
        }

        return view('admin.jenis-hewan.edit', compact('jenisHewan'));
    }

    // Memperbarui data jenis hewan di database
    public function update(Request $request, $id): RedirectResponse
    {
        // Pastikan jenis hewan ada
        $existing = DB::table('jenis_hewan')->where('idjenis_hewan', $id)->first();
        if (! $existing) {
            abort(404);
        }

        // Validasi input
        $validated = $request->validate(
            $this->updateValidationRules($id),
            $this->validationMessages()
        );

        // Perbarui data jenis hewan
        DB::table('jenis_hewan')
            ->where('idjenis_hewan', $id)
            ->update([
                'nama_jenis_hewan' => $validated['nama_jenis_hewan']
            ]);

        return redirect()
            ->route('admin.jenis-hewan.index')
            ->with('success', 'Jenis hewan berhasil diperbarui.');
    }

    // Menghapus jenis hewan dari database
    public function destroy($id): RedirectResponse
    {
        // Cek apakah ada ras_hewan terkait sebelum menghapus
        if (DB::table('ras_hewan')->where('idjenis_hewan', $id)->exists()) {
            return redirect()
                ->route('admin.jenis-hewan.index')
                ->with('error', 'Tidak dapat menghapus jenis hewan yang masih memiliki ras hewan.');
        }

        // Hapus jenis hewan
        DB::table('jenis_hewan')->where('idjenis_hewan', $id)->delete();

        return redirect()
            ->route('admin.jenis-hewan.index')
            ->with('success', 'Jenis hewan berhasil dihapus.');
    }
}
