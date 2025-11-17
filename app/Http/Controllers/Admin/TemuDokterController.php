<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemuDokter;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TemuDokterController extends Controller
{
    /**
     * Display a listing of appointments
     * Untuk Resepsionis: Semua appointment
     * Untuk Dokter/Perawat: View only
     */
    public function index(): View
    {
        $appointments = TemuDokter::with(['pet.pemilik.user', 'pet.rasHewan.jenisHewan', 'roleUser'])
            ->orderBy('waktu_daftar', 'desc')
            ->paginate(15);

        return view('admin.temu-dokter.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment
     * Hanya untuk Resepsionis
     */
    public function create(): View
    {
        $pets = Pet::with(['pemilik.user', 'rasHewan.jenisHewan'])->get();

        // Get dokter dan perawat (role_user entries with status 1)
        $medicalStaff = DB::table('role_user')
            ->join('user', 'role_user.iduser', '=', 'user.iduser')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->whereIn('role.nama_role', ['Dokter', 'Perawat'])
            ->where('role_user.status', 1)
            ->select('role_user.idrole_user', 'user.nama', 'role.nama_role')
            ->get();

        // Get nomor urut berikutnya untuk hari ini
        $nextNumber = $this->getNextQueueNumber();

        return view('admin.temu-dokter.create', compact('pets', 'medicalStaff', 'nextNumber'));
    }

    /**
     * Store a newly created appointment
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            $this->storeValidationRules(),
            $this->validationMessages()
        );

        try {
            DB::beginTransaction();

            // Auto-assign nomor urut jika tidak diisi
            if (empty($validated['no_urut'])) {
                $validated['no_urut'] = $this->getNextQueueNumber();
            }

            // Set waktu daftar ke sekarang jika tidak diisi
            if (empty($validated['waktu_daftar'])) {
                $validated['waktu_daftar'] = now();
            }

            // Default status menunggu
            $validated['status'] = $validated['status'] ?? TemuDokter::STATUS_MENUNGGU;

            TemuDokter::create($validated);

            DB::commit();

            return redirect()
                ->route('resepsionis.temu-dokter.index')
                ->with('success', 'Appointment berhasil dibuat. Nomor urut: ' . $validated['no_urut']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create appointment: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal membuat appointment.');
        }
    }

    /**
     * Display the specified appointment
     */
    public function show(TemuDokter $temuDokter): View
    {
        $temuDokter->load(['pet.pemilik.user', 'pet.rasHewan.jenisHewan', 'roleUser']);

        return view('admin.temu-dokter.show', compact('temuDokter'));
    }

    /**
     * Show the form for editing appointment
     */
    public function edit(TemuDokter $temuDokter): View
    {
        $temuDokter->load(['pet.pemilik', 'roleUser']);
        $pets = Pet::with(['pemilik.user', 'rasHewan.jenisHewan'])->get();

        // Get dokter dan perawat (role_user entries with status 1)
        $medicalStaff = DB::table('role_user')
            ->join('user', 'role_user.iduser', '=', 'user.iduser')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->whereIn('role.nama_role', ['Dokter', 'Perawat'])
            ->where('role_user.status', 1)
            ->select('role_user.idrole_user', 'user.nama', 'role.nama_role')
            ->get();

        return view('admin.temu-dokter.edit', compact('temuDokter', 'pets', 'medicalStaff'));
    }

    /**
     * Update the specified appointment
     */
    public function update(Request $request, TemuDokter $temuDokter): RedirectResponse
    {
        $validated = $request->validate(
            $this->updateValidationRules($temuDokter),
            $this->validationMessages()
        );

        try {
            DB::beginTransaction();

            // Remove no_urut from validated data to prevent updates
            unset($validated['no_urut']);

            $temuDokter->update($validated);

            DB::commit();

            return redirect()
                ->route('resepsionis.temu-dokter.index')
                ->with('success', 'Appointment berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update appointment: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui appointment.');
        }
    }

    /**
     * Remove the specified appointment
     */
    public function destroy(TemuDokter $temuDokter): RedirectResponse
    {
        try {
            $temuDokter->delete();
            return redirect()
                ->route('resepsionis.temu-dokter.index')
                ->with('success', 'Appointment berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Failed to delete appointment: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus appointment.');
        }
    }

    /**
     * Display appointments for authenticated Pemilik
     */
    public function myAppointments(): View
    {
        $user = Auth::user();

        // Get pemilik dari user yang login
        $pemilik = $user->pemilik;

        if (!$pemilik) {
            abort(403, 'Anda tidak terdaftar sebagai pemilik.');
        }

        // Get semua pet milik pemilik ini
        $petIds = $pemilik->pets->pluck('idpet');

        $appointments = TemuDokter::with(['pet.rasHewan.jenisHewan', 'roleUser'])
            ->whereIn('idpet', $petIds)
            ->orderBy('waktu_daftar', 'desc')
            ->paginate(10);

        return view('pemilik.my-appointments', compact('appointments'));
    }

    /**
     * Helper: Get next queue number for today
     */
    private function getNextQueueNumber(): int
    {
        $lastNumber = TemuDokter::whereDate('waktu_daftar', today())
            ->max('no_urut');

        return ($lastNumber ?? 0) + 1;
    }

    /**
     * Helper: Validation messages
     */
    private function validationMessages(): array
    {
        return [
            'idpet.required' => 'Pet wajib dipilih.',
            'idpet.exists' => 'Pet tidak ditemukan.',
            'idrole_user.exists' => 'Petugas medis tidak ditemukan.',
            'status.in' => 'Status tidak valid.',
            'waktu_daftar.date' => 'Format tanggal tidak valid.',
        ];
    }

    /**
     * Helper: Store validation rules
     */
    private function storeValidationRules(): array
    {
        return [
            'idpet' => 'required|exists:pet,idpet',
            'idrole_user' => 'nullable|exists:role_user,idrole_user',
            'no_urut' => 'nullable|integer|min:1',
            'waktu_daftar' => 'nullable|date',
            'status' => 'nullable|in:0,1,2,3',
        ];
    }

    /**
     * Helper: Update validation rules
     */
    private function updateValidationRules(TemuDokter $temuDokter): array
    {
        return [
            'idpet' => 'required|exists:pet,idpet',
            'idrole_user' => 'nullable|exists:role_user,idrole_user',
            'waktu_daftar' => 'required|date',
            'status' => 'required|in:0,1,2,3',
        ];
    }
}
