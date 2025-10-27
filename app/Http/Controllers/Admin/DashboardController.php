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
            'today_registrations' => 0, // TODO: implement
        ];
        
        $recent_pemilik = Pemilik::with('user')->latest('idpemilik')->take(10)->get();
        $recent_pets = Pet::with(['pemilik.user', 'jenis_hewan', 'ras_hewan'])->latest('idpet')->take(10)->get();
        
        return view('dashboard.resepsionis', compact('stats', 'recent_pemilik', 'recent_pets'));
    }
    
    /**
     * Dokter Dashboard
     */
    private function dokterDashboard(): View
    {
        $stats = [
            'total_patients' => Pet::count(),
            'today_appointments' => 0, // TODO: implement
            'completed_diagnoses' => 0, // TODO: implement
            'pending_reviews' => 0, // TODO: implement
        ];
        
        $recent_patients = Pet::with(['pemilik.user', 'jenis_hewan', 'ras_hewan'])->latest('idpet')->take(10)->get();
        
        return view('dashboard.dokter', compact('stats', 'recent_patients'));
    }
    
    /**
     * Perawat Dashboard
     */
    private function perawatDashboard(): View
    {
        $stats = [
            'under_care' => 0, // TODO: implement
            'today_treatments' => 0, // TODO: implement
            'completed_treatments' => 0, // TODO: implement
            'critical_patients' => 0, // TODO: implement
        ];
        
        $monitoring_patients = Pet::with(['pemilik.user', 'jenis_hewan'])->latest('idpet')->take(10)->get();
        
        return view('dashboard.perawat', compact('stats', 'monitoring_patients'));
    }
    
    /**
     * Pemilik Dashboard
     */
    private function pemilikDashboard(): View
    {
        $user = auth()->user();
        
        $my_pets = $user->pets()->with(['jenis_hewan', 'ras_hewan'])->get();
        
        $stats = [
            'my_pets' => $my_pets->count(),
            'upcoming_appointments' => 0, // TODO: implement
            'total_visits' => 0, // TODO: implement
        ];
        
        return view('dashboard.pemilik', compact('stats', 'my_pets'));
    }
}
