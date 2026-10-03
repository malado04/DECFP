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
        $request->session()->regenerate();

        $user = auth()->user();

        switch ($user->role) {

            case 'super-admin':
                return redirect()->route('admin.dashboard.admin');

            case 'ministere':
                return redirect()->route('admin.dashboard.ministere');

            case 'regional-admin':
                return redirect()->route('admin.dashboard.region');

            case 'centre-admin':
                return redirect()->route('admin.dashboard.centre');

            case 'jury':
                return redirect()->route('admin.dashboard.jury');

            case 'etudiant':
                return redirect()->route('admin.dashboard.student');
                default:
                return redirect()->route('admin.dashboard.student');
        }

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
