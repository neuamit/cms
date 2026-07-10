<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email',
            'password'              => 'required|min:6|confirmed',
            'g-recaptcha-response'  => ['required', new Recaptcha()],
             ], [
        'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
    ]);

        if (User::where('email', $data['email'])->exists()) {
            return back()->withErrors(['email' => 'Email already registered']);
        }

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'admin', // self-registration is always a restaurant admin
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email',
            'password'              => 'required',
            'g-recaptcha-response'  => ['required', new Recaptcha()],
            ], [
        'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return Auth::user()->role === 'super_admin'
                ? redirect()->route('superadmin.dashboard')
                : redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}