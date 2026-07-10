<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login DAN memiliki role 'admin'
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        // Jika bukan admin, lemparkan error 403 (Forbidden)
        // Atau bisa juga di-redirect ke home: return redirect()->route('home');
        abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}