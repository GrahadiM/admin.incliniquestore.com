<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $user = $request->user();

        // 1. Cek status user
        if ($user->status === 'inactive') {
            Auth::logout(); // logout langsung
            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Akun Anda sedang tidak aktif. Silakan hubungi admin untuk mengaktifkan akun Anda.',
                ])
                ->withInput($request->only('email'));
        }

        // 2. Cek role user (hanya admin / super-admin yang bisa login)
        if (! $user->hasRole(['admin', 'super-admin'])) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Akses ditolak. Hanya admin atau super-admin yang dapat masuk.',
                ])
                ->withInput($request->only('email'));
        }

        // Login success
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
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
