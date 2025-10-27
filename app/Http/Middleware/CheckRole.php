<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles - Role names yang diizinkan (contoh: 'Administrator', 'Dokter')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            abort(401, 'Unauthorized - Anda harus login terlebih dahulu.');
        }

        $user = auth()->user();

        // Jika tidak ada role yang ditentukan, izinkan semua authenticated user
        if (empty($roles)) {
            return $next($request);
        }

        // Cek apakah user memiliki salah satu dari role yang diizinkan
        if (!$user->hasAnyRole($roles)) {
            abort(403, 'Forbidden - Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
