<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required','string'],
            'password' => ['required','string'],
        ]);

        $loginInput = $request->input('email');
        $password = $request->input('password');

        $user = User::query()
            ->where('email', $loginInput)
            ->orWhere('username', $loginInput)
            ->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return back()->withErrors(['login' => 'Email/username atau password salah']);
        }

        if (($user->status ?? 'aktif') !== 'aktif') {
            return back()->withErrors(['login' => 'Akun nonaktif']);
        }

        Auth::login($user);

        return redirect()->route('dashboard', ['role' => $user->role ?? 'pembeli']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => ['required','string','max:255'],
            'last_name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'username' => ['required','string','max:255','unique:users,username'],
            'password' => ['required','string','min:6','max:255'],
            'role' => ['nullable','in:admin,pembeli'],
        ]);

        $role = $request->input('role', 'pembeli');

        $user = User::create([
            'name' => trim(($request->input('first_name') ?? '') . ' ' . ($request->input('last_name') ?? '')),
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'role' => $role,
            'status' => 'aktif',
            'password' => Hash::make($request->input('password')),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard', ['role' => $user->role ?? 'pembeli']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index');
    }
}

