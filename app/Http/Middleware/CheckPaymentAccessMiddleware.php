<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPaymentAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Memeriksa apakah pengguna terautentikasi
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        // Memeriksa apakah pengguna memiliki sesi pembayaran yang valid
        if (!$request->session()->has('cart')) {
            return redirect()->route('schedule.index')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return $next($request);
    }
}
