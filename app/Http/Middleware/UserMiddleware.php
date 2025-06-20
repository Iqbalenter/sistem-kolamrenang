<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Jika admin mencoba akses halaman user, redirect ke admin dashboard
        if (Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return $next($request);
    }
} 