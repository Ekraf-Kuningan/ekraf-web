<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CustomLoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function create()
    {
        return view('auth.custom-login');
    }

    /**
     * Handle login request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Cek apakah input adalah email atau username
        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        if (Auth::attempt([$fieldType => $request->email, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();

            if($request->has('remember')){
                // Set cookie untuk 5 hari
                setcookie('remember_email', $request->email, time() + (5 * 24 * 60 * 60), "/");
            } else {
                // Hapus cookie jika ada
                if(isset($_COOKIE['remember_email'])) {
                    setcookie('remember_email', '', time() - 3600, "/");
                }
            }
            

            $user = Auth::user();   

            // Admin (level 1/2) -> Filament, Mitra (level 3) -> Dashboard Mitra
            if ($user->level_id == 1 || $user->level_id == 2) {
                return redirect()->intended(route('filament.admin.pages.dashboard'));
            }

            // Default arahkan ke dashboard mitra
            return redirect()->intended(route('pelaku-ekraf.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => 'Email/Username atau password yang Anda masukkan salah.',
        ]);
    }

    /**
     * Handle logout request.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
