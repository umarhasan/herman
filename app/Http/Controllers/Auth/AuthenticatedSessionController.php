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

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Role-based redirect
        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('Teacher')) {
            return redirect()->route('teacher.dashboard');
        } elseif ($user->hasRole('Student')) {
            return redirect('/');
        } elseif ($user->hasRole('Parent')) {
            return redirect()->route('parent.dashboard');
        } elseif ($user->hasRole('User')) {
            return redirect()->route('user.dashboard');
        }

        // If no role matched
        Auth::logout();
        return redirect()->route('login')->withErrors(['role' => 'No valid role assigned.']);
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
