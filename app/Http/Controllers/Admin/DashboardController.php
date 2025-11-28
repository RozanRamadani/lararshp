<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Role;
use App\Models\Pemilik;
use App\Models\Pet;
use App\Models\JenisHewan;
use App\Models\RasHewan;
use App\Models\TemuDokter;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the appropriate dashboard based on user role
     */
    public function index(): View
    {
        $user = auth()->user();

        // Redirect ke dashboard sesuai role utama
        if ($user->hasRole('Administrator')) {
            return $this->adminDashboard();
        } elseif ($user->hasRole('Resepsionis')) {
            return $this->resepsionDashboard();
        } elseif ($user->hasRole('Dokter')) {
            return $this->dokterDashboard();
        } elseif ($user->hasRole('Perawat')) {
            return $this->perawatDashboard();
        } elseif ($user->hasRole('Pemilik')) {
            return $this->pemilikDashboard();
        }

        // Default dashboard
        return view('dashboard.default');
    }

    /**
     * Administrator Dashboard
     */
    private function adminDashboard(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_roles' => Role::count(),
            'total_pemilik' => Pemilik::count(),
            'total_pets' => Pet::count(),
        ];

        $recent_users = User::with('roles')->latest('iduser')->take(5)->get();
        $recent_pemilik = Pemilik::with('user')->latest('idpemilik')->take(5)->get();

        return view('dashboard.administrator', compact('stats', 'recent_users', 'recent_pemilik'));
    }

    /**
     * Resepsionis Dashboard
     */
    private function resepsionDashboard(): View
    {
        $stats = [
            'total_pemilik' => Pemilik::count(),
            'total_pets' => Pet::count(),
            'today_appointments' => TemuDokter::today()->count(),
            'pending_appointments' => TemuDokter::byStatus(TemuDokter::STATUS_MENUNGGU)->count(),
            'completed_appointments' => TemuDokter::byStatus(TemuDokter::STATUS_SELESAI)->count(),
        ];

        $recent_pemilik = Pemilik::with('user')->latest('idpemilik')->take(10)->get();
        $recent_pets = Pet::with(['pemilik.user', 'rasHewan.jenisHewan'])->latest('idpet')->take(10)->get();
        $today_appointments = TemuDokter::with(['pet.pemilik.user', 'roleUser'])->today()->latest('waktu_daftar')->take(5)->get();

        return view('dashboard.resepsionis', compact('stats', 'recent_pemilik', 'recent_pets', 'today_appointments'));
    }

    /**
     * Dokter Dashboard
     */
    private function dokterDashboard(): View
    {
        $user = auth()->user();

        // Map authenticated user to their role_user ids (role_user.idrole_user)
        $roleUserIds = DB::table('role_user')->where('iduser', $user->iduser)->pluck('idrole_user')->toArray();

        $stats = [
            'total_patients' => Pet::count(),
            // TemuDokter stores role_user id in `idrole_user`, so use whereIn
            'today_appointments' => TemuDokter::today()->whereIn('idrole_user', $roleUserIds)->count(),
            // rekam_medis references dokter via `dokter_pemeriksa` (which is a role_user id)
            'completed_diagnoses' => RekamMedis::whereIn('dokter_pemeriksa', $roleUserIds)->count(),
            'pending_reviews' => TemuDokter::whereIn('idrole_user', $roleUserIds)->byStatus(TemuDokter::STATUS_MENUNGGU)->count(),
        ];

        $recent_patients = Pet::with(['pemilik.user', 'rasHewan.jenisHewan'])->latest('idpet')->take(10)->get();
        $my_appointments = TemuDokter::with(['pet.pemilik.user', 'pet.rasHewan.jenisHewan'])
            ->whereIn('idrole_user', $roleUserIds)
            ->upcoming()
            ->latest('waktu_daftar')
            ->take(5)
            ->get();

        return view('dashboard.dokter', compact('stats', 'recent_patients', 'my_appointments'));
    }

    /**
     * Perawat Dashboard
     */
    private function perawatDashboard(): View
    {
        $user = auth()->user();

        // Map authenticated user to their role_user ids
        $roleUserIds = DB::table('role_user')->where('iduser', $user->iduser)->pluck('idrole_user')->toArray();

        // Use related temu_dokter records as a proxy for perawat assignments.
        $stats = [
            'under_care' => RekamMedis::whereHas('temuDokter', function($q) use ($roleUserIds) {
                $q->whereIn('idrole_user', $roleUserIds);
            })->count(),
            'today_treatments' => TemuDokter::whereIn('idrole_user', $roleUserIds)->today()->count(),
            'completed_treatments' => RekamMedis::whereHas('temuDokter', function($q) use ($roleUserIds) {
                $q->whereIn('idrole_user', $roleUserIds);
            })->count(),
            'pending_treatments' => TemuDokter::whereIn('idrole_user', $roleUserIds)
                ->whereIn('status', [
                    TemuDokter::STATUS_CHECKIN,
                    TemuDokter::STATUS_PEMERIKSAAN,
                    TemuDokter::STATUS_TREATMENT,
                ])->count(),
        ];

        $monitoring_patients = Pet::with(['pemilik.user', 'rasHewan.jenisHewan'])->latest('idpet')->take(10)->get();
        $my_treatments = RekamMedis::with(['pet.pemilik.user', 'temuDokter'])
            ->whereHas('temuDokter', function($q) use ($roleUserIds) {
                $q->whereIn('idrole_user', $roleUserIds);
            })
            ->latest('idrekam_medis')
            ->take(5)
            ->get();

        return view('dashboard.perawat', compact('stats', 'monitoring_patients', 'my_treatments'));
    }

    /**
     * Pemilik Dashboard
     */
    private function pemilikDashboard(): View
    {
        $user = auth()->user();
        $pemilik = $user->pemilik;

        $my_pets = Pet::where('idpemilik', $pemilik->idpemilik)->with(['rasHewan.jenisHewan'])->get();
        $petIds = $my_pets->pluck('idpet');

        $stats = [
            'my_pets' => $my_pets->count(),
            'upcoming_appointments' => TemuDokter::whereIn('idpet', $petIds)->upcoming()->count(),
            // rekam_medis does not contain idpet directly in this schema; count via related temu_dokter
            'total_visits' => RekamMedis::whereHas('temuDokter', function($q) use ($petIds) {
                $q->whereIn('idpet', $petIds);
            })->count(),
        ];

        $upcoming_appointments = TemuDokter::with(['pet', 'roleUser'])
            ->whereIn('idpet', $petIds)
            ->upcoming()
            ->orderBy('waktu_daftar', 'asc')
            ->take(3)
            ->get();

        return view('dashboard.pemilik', compact('stats', 'my_pets', 'upcoming_appointments'));
    }
}
