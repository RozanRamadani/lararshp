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
    public function index(Request $request): View
    {
        // Handle trash view
        $query = TemuDokter::with(['pet.pemilik.user', 'pet.rasHewan.jenisHewan', 'roleUser']);

        if ($request->query('show_trashed')) {
            $query->onlyTrashed();
        }

        // Paginated appointments for the table
        $appointments = $query->orderBy('waktu_daftar', 'desc')->paginate(15);

        // Compute real counts from DB using the current status constants
        $menungguCount = TemuDokter::where('status', TemuDokter::STATUS_MENUNGGU)->count();
        $prosesCount = TemuDokter::whereIn('status', [
            TemuDokter::STATUS_CHECKIN,
            TemuDokter::STATUS_PEMERIKSAAN,
            TemuDokter::STATUS_TREATMENT,
        ])->count();
        $selesaiCount = TemuDokter::where('status', TemuDokter::STATUS_SELESAI)->count();
        $batalCount = TemuDokter::where('status', TemuDokter::STATUS_BATAL)->count();

        return view('admin.temu-dokter.index', compact('appointments', 'menungguCount', 'prosesCount', 'selesaiCount', 'batalCount'));
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
     * Remove the specified appointment (soft delete)
     */
    public function destroy(TemuDokter $temuDokter): RedirectResponse
    {
        try {
            // Soft delete appointment and related rekam medis if exists
            if ($temuDokter->rekamMedis) {
                $temuDokter->rekamMedis->details()->update(['deleted_by' => auth()->id()]);
                $temuDokter->rekamMedis->details()->delete();
                $temuDokter->rekamMedis->deleted_by = auth()->id();
                $temuDokter->rekamMedis->save();
                $temuDokter->rekamMedis->delete();
            }

            $temuDokter->deleted_by = auth()->id();
            $temuDokter->save();
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
     * Restore soft deleted appointment
     */
    public function restore($id): RedirectResponse
    {
        try {
            $temuDokter = TemuDokter::withTrashed()->findOrFail($id);

            // Restore related rekam medis if exists
            if ($temuDokter->rekamMedis()->withTrashed()->exists()) {
                $rekamMedis = $temuDokter->rekamMedis()->withTrashed()->first();
                $rekamMedis->details()->withTrashed()->restore();
                $rekamMedis->restore();
            }

            $temuDokter->restore();

            return redirect()
                ->route('resepsionis.temu-dokter.index')
                ->with('success', 'Appointment berhasil dipulihkan.');
        } catch (\Exception $e) {
            Log::error('Failed to restore appointment: ' . $e->getMessage());
            return back()->with('error', 'Gagal memulihkan appointment.');
        }
    }

    /**
     * Permanently delete appointment
     */
    public function forceDelete($id): RedirectResponse
    {
        try {
            $temuDokter = TemuDokter::withTrashed()->findOrFail($id);

            // Force delete related rekam medis if exists
            if ($temuDokter->rekamMedis()->withTrashed()->exists()) {
                $rekamMedis = $temuDokter->rekamMedis()->withTrashed()->first();
                $rekamMedis->details()->withTrashed()->forceDelete();
                $rekamMedis->forceDelete();
            }

            $temuDokter->forceDelete();

            return redirect()
                ->route('resepsionis.temu-dokter.index')
                ->with('success', 'Appointment berhasil dihapus permanen.');
        } catch (\Exception $e) {
            Log::error('Failed to force delete appointment: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus permanen appointment.');
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

        $appointments = TemuDokter::with(['pet.rasHewan.jenisHewan', 'roleUser.user', 'roleUser.role'])
            ->whereIn('idpet', $petIds)
            ->orderBy('waktu_daftar', 'desc')
            ->paginate(10);

        return view('pemilik.my-appointments', compact('appointments'));
    }

    /**
     * Cancel appointment - Pemilik only
     */
    public function cancelAppointment(TemuDokter $temuDokter): RedirectResponse
    {
        $user = Auth::user();
        $pemilik = $user->pemilik;

        if (!$pemilik) {
            abort(403, 'Anda tidak terdaftar sebagai pemilik.');
        }

        // Verify appointment belongs to owner's pet
        $petIds = $pemilik->pets->pluck('idpet');
        if (!$petIds->contains($temuDokter->idpet)) {
            abort(403, 'Appointment ini bukan milik Anda.');
        }

        // Validate appointment can be canceled (not already completed or canceled)
        if (in_array($temuDokter->status, [TemuDokter::STATUS_SELESAI, TemuDokter::STATUS_BATAL])) {
            return back()->withErrors(['error' => 'Appointment dengan status ' . $temuDokter->status_label . ' tidak dapat dibatalkan.']);
        }

        // Update status to canceled
        $temuDokter->status = TemuDokter::STATUS_BATAL;
        $temuDokter->save();

        return back()->with('success', 'Appointment berhasil dibatalkan.');
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
            // include all defined statuses (0-5)
            'status' => 'nullable|in:0,1,2,3,4,5',
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
            // include all defined statuses (0-5)
            'status' => 'required|in:0,1,2,3,4,5',
        ];
    }
}
