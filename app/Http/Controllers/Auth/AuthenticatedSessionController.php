<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect berdasarkan level user
        $user = Auth::user();
        
        // Cek kolom id_level dan redirect accordingly
        if (isset($user->id_level)) {
            if ($user->id_level == 1) {
                // SuperAdmin ke panel superadmin
                return redirect('/superadmin');
            } elseif ($user->id_level == 2) {
                // Admin ke panel admin
                return redirect('/admin');
            }
        }
        
        // Default redirect untuk member atau role lainnya
        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
