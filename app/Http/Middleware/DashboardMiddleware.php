<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Periksa divisi pengguna
            switch ($user->divisi) {
                case 'Staff':
                    // Jika pengguna adalah "Staff", arahkan mereka ke halaman index dengan parameter 'nip'
                    return redirect()->route('/', ['nip' => $user->nip]);
                    break;
                case 'Staff HR':
                case 'Atasan':
                    // Jika pengguna adalah "Staff HR" atau "Atasan", arahkan mereka langsung ke halaman index
                    return redirect()->route('/');
                    break;
                default:
                    // Divisi tidak terdefinisi, kembalikan kode status 403
                    abort(403, 'Anda tidak memiliki akses untuk halaman ini.');
                    break;
            }
        }
    
        // Jika pengguna tidak terotentikasi, kembalikan ke halaman login
        return redirect()->route('login');
        }
    
}