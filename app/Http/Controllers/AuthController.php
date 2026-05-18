<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return redirect()->route('dashboard', ['role' => $user->role]);
        }
        return view('login');
    }

    /**
     * Tampilkan halaman register
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return redirect()->route('dashboard', ['role' => $user->role]);
        }
        return view('login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek apakah input berupa email atau username
        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginField => $request->login,
            'password' => $request->password,
            'status' => 'aktif' // Hanya user aktif yang bisa login
        ];

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirect berdasarkan role
            return redirect()->route('dashboard', ['role' => $user->role]);
        }

        return back()->withErrors([
            'login' => 'Email/Username atau password salah.',
        ])->onlyInput('login');
    }

    /**
     * Proses register
     */
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'pembeli', // Default role pembeli
            'status' => 'aktif',
        ]);

        // Redirect ke halaman login dengan notifikasi sukses
        return redirect()->route('login')
            ->with('register_success', 'Akun Anda sudah terdaftar! Silakan masuk dengan akun baru Anda.');
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('index');
    }
}