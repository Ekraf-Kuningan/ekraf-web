<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user sudah login, redirect berdasarkan level
        if (Auth::check()) {
            $user = Auth::user();
            
            // SuperAdmin ke panel superadmin
            if ($user->id_level == 1 && !$request->is('superadmin*')) {
                return redirect('/superadmin');
            }
            
            // Admin ke panel admin  
            if ($user->id_level == 2 && !$request->is('admin*')) {
                return redirect('/admin');
            }
        }
        
        return $next($request);
    }
}
