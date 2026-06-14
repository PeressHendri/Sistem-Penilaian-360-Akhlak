<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Update last_login timestamp
            $user = Auth::user();
            $user->last_login = now();
            $user->save();

            \App\Helpers\ActivityLogger::log('User logged in: ' . $user->email, 'Auth');

            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah. Silakan coba lagi.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    protected function redirectBasedOnRole($user)
    {
        if ($user->hasRole('Administrator')) {
            return redirect('/admin/dashboard');
        } elseif ($user->hasRole('Human Capital')) {
            return redirect('/hc/dashboard');
        } elseif ($user->hasRole('Penilai')) {
            return redirect('/reviewer/dashboard');
        } elseif ($user->hasRole('Management')) {
            return redirect('/management/dashboard');
        }

        return redirect('/dashboard');
    }
}
